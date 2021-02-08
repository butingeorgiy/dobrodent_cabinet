<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\UncategorizedApiException;
use App\Facades\Authorization;
use App\Models\Doctor;
use App\Models\DoctorReview;
use App\Models\Patient;
use App\Models\Visit;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * @param $field
     * @param $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function isExist($field, $value)
    {
        if (!in_array($field, ['phone', 'email'])) throw new Exception('Undefined field for checking patient.');

        if ($field === 'phone') {
            $patient = Patient::byPhone($value)->get();
        } else {
            $patient = Patient::where($field, $value)->get();
        }

        return response()->json(['isExist' => $patient->count() !== 0]);
    }

    public function getByDoctor(Request $request, $offset)
    {
        return Patient::searchByDoctor($request->get('q') ?: '', $offset);
    }

    public function getByAdministrator(Request $request, $offset)
    {
        return Patient::searchByAdministrator($request->get('q') ?: '', $offset);
    }

    public function update(Request $request, $id)
    {
        if (Authorization::user()->privileges_id !== 2) {
            throw new UncategorizedApiException('Вы не имеете прав на редактирование пациентов');
        }

        $validator = Validator::make($request->all(),
            [
                'first_name' => 'bail|min:1|max:32',
                'last_name' => 'bail|min:1|max:32',
                'middle_name' => 'bail|max:32',
                'gender' => 'bail|in:0,1'
            ],
            [
                'first_name.min' => 'Имя не может быть пустым',
                'first_name.max' => 'Длина имени не должно привышать 32 символов',
                'last_name.min' => 'Фамилия не может быть пустой',
                'last_name.max' => 'Длина фамилии не должна привышать 32 символов',
                'middle_name.max' => 'Длина отчества не должна привышать 32 символов',
                'gender.in' => 'Некорретное значение пола пользователя'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $patient = Patient::find($id);

        if ($patient === null) {
            throw new UncategorizedApiException('Пользователь не найден! Возможно он был кем-то удалён');
        }

        if ($request->has('first_name') and trim($request->post('first_name')) !== '') {
            $patient->first_name = $request->post('first_name');
        }

        if ($request->has('last_name') and trim($request->post('last_name')) !== '') {
            $patient->last_name = $request->post('last_name');
        }

        if ($request->has('middle_name')) {
            $patient->middle_name = $request->post('middle_name');
        }

        if ($request->has('gender') and in_array($request->post('gender'), ['0', '1'])) {
            $patient->gender = $request->post('gender');
        }

        if (!$patient->save()) {
            throw new UncategorizedApiException('Не удалось сохранить по неизвестной изменения');
        }

        return response()
            ->json(['success' => 'Изменения успешно сохранены']);
    }

    public function likeDoctor(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'doctor_id' => 'bail|required|numeric'
            ],
            [
                'doctor_id.required' => 'Необходимо указать айди врача',
                'doctor_id.numeric' => 'Айди врача должно быть числом'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $patient = Authorization::user();

        if (!$patient) {
            throw new UncategorizedApiException('Добавить/удалить в избранное врача может только авторизованный пациент');
        }

        if (get_class($patient) !== Patient::class) {
            throw new UncategorizedApiException('Добавить/удалить в избранное врача может только пациент');
        }

        $doctor = Doctor::find($request->post('doctor_id'));

        if (!$doctor) {
            throw new UncategorizedApiException('Не удалось найти выбранного врача! Возможно он был кем-то удалён');
        }

        $doctor->likes()->toggle([$patient->id]);

        return response()
            ->json(['success' => 'Всё прошло успешно']);
    }

    public function createDoctorReview(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'mark' => 'bail|required|in:1,3,5',
                'doctor_id' => 'bail|required'
            ],
            [
                'mark.required' => 'Необходимо указать оценку отзыва',
                'mark.in' => 'Недопустимая оценка отзыва',
                'doctor_id.required' => 'Необходимо указать врача'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $patient = Authorization::user();
        $doctor = Doctor::find($request->post('doctor_id'));

        if (!$doctor) {
            throw new UncategorizedApiException('Данного врача не существует! Возможно он был кем-то удалён');
        }

        $review = new DoctorReview();

        $review->mark = $request->post('mark');

        if ($request->post('comment')) {
            $review->message = $request->post('comment');
        }

        $review->doctor_id = $doctor->id;
        $review->patient_id = $patient->id;

        if (!$review->save()) {
            throw new UncategorizedApiException('Не удалось сохранить отзыв');
        }

        return response()
            ->json(['success' => 'Ваш отзыв успешно сохранён']);
    }

    public function generalSearch(Request $request)
    {
        $value = $request->get('q');

        if (!$value) {
            return [];
        }

        $output = [];

        $output['doctors'] = Doctor::search($value, 0, true);
        $output['visits'] = Visit::search($value, 0, true);

        return $output;
    }
}
