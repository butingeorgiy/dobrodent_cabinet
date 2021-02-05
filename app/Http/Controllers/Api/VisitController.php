<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\UncategorizedApiException;
use App\Facades\Authorization;
use App\Models\Administrator;
use App\Models\Doctor;
use App\Models\Illness;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\VisitStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Throwable;

class VisitController extends Controller
{
    public function createByPatient(Request $request)
    {
        try {
            $visit = new Visit();

            if ($request->post('dest')) {
                $type = mb_substr($request->post('dest'), 0, 1);
                $id = mb_substr($request->post('dest'), 1, 1);

                if ($type === 'c') {
                    $visit->clinic_id = $id;
                } else if ($type === 'd') {
                    $visit->doctor_id = $id;
                } else {
                    throw new UncategorizedApiException('Undefined type of destination: ' . $type);
                }
            }

            if ($request->post('cause')) {
                $visit->cause = $request->post('cause');
            }

            if ($request->post('date')) {
                $visit->visit_date = Carbon::parse($request->post('date'));
            }

            if ($request->post('time')) {
                $visit->visit_time = Carbon::parse($request->post('time'));
            }

            $visit->patient_id = Authorization::user()->id;

            $visit = $visit->save();

            if (!$visit) {
                throw new UncategorizedApiException('Визит не был создан! Повторите попытку заново');
            }

            return response()
                ->json(['success' => 'Визит успешно создан!']);
        } catch (Throwable $e) {
            throw new UncategorizedApiException($e->getMessage());
        }
    }

    public function createByDoctor(Request $request)
    {
        try {
            if (!$request->post('patient_id')) {
                throw new UncategorizedApiException('Необходимо указать пациента');
            }

            $patient = Patient::find($request->post('patient_id'));

            if (!$patient) {
                throw new UncategorizedApiException('Выбранного пациента не существует! Возможно он был кем-то удалён');
            }

            $visit = new Visit();

            if ($request->post('dest')) {
                $type = mb_substr($request->post('dest'), 0, 1);
                $id = mb_substr($request->post('dest'), 1, 1);

                if ($type === 'c') {
                    $visit->clinic_id = $id;
                } else if ($type === 'd') {
                    $visit->doctor_id = $id;
                } else {
                    throw new UncategorizedApiException('Undefined type of destination: ' . $type);
                }
            }

            if ($request->post('cause')) {
                $visit->cause = $request->post('cause');
            }

            if ($request->post('date')) {
                $visit->visit_date = Carbon::parse($request->post('date'));
            }

            if ($request->post('time')) {
                $visit->visit_time = Carbon::parse($request->post('time'));
            }

            $visit->patient_id = $patient->id;

            $visit = $visit->save();

            if (!$visit) {
                throw new UncategorizedApiException('Визит не был создан! Повторите попытку заново');
            }

            return response()
                ->json(['success' => 'Визит успешно создан!']);
        } catch (Throwable $e) {
            throw new UncategorizedApiException($e->getMessage());
        }
    }

    public function getByPatient(Request $request, $offset)
    {
        $validator = Validator::make($request->all(),
            [
                'statuses' => 'bail|json',
                'date_start' => 'bail|date|date_format:Y-m-d',
                'date_end' => 'bail|date|date_format:Y-m-d'
            ],
            [
                'statuses.json' => 'Некорректный тип переменной statuses',
                'date_start.date' => 'Некорректный тип переменной date_start',
                'date_start.date_format' => 'Некорректный формат даты date_start',
                'date_end.json' => 'Некорректный тип переменной date_start',
                'date_end.date_format' => 'Некорректный формат даты date_end'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visits = Visit::with(['doctor:id,first_name,last_name,middle_name', 'status'])
            ->where('patient_id', Authorization::user()->id);

        if ($request->get('statuses')) {
            $visits->whereIn('visit_status_id', json_decode($request->get('statuses')));
        }

        if ($request->get('date_start')) {
            $visits->where('visit_date', '>=', $request->get('date_start'));
        }

        if ($request->get('date_end')) {
            $visits->where('visit_date', '<=', $request->get('date_end'));
        }

        if ($request->get('illnesses')) {
            $visits->whereIn('illness_id', json_decode($request->get('illnesses')));
        }

        $visits = $visits->offset($offset)->limit(15)->orderByDesc('id')->get();

        $output = [];

        foreach ($visits as $visit) {
            $item['id'] = $visit->id;
            $item['status'] = $visit->status->name ?: null;

            if ($visit->doctor) {
                $item['doctor'] = [
                    $visit->doctor->id,
                    $visit->doctor->last_name . ' ' . mb_substr($visit->doctor->first_name, 0, 1) . '.' . mb_substr($visit->doctor->middle_name, 0, 1) . '.'
                ];
            } else {
                $item['doctor'] = null;
            }

            $item['cause'] = $visit->cause ?: null;

            $item['time'] = $visit->visit_time ? Carbon::parse($visit->visit_time)->format('H:i') : '--:--';
            $item['date'] = $visit->visit_date ? Carbon::parse($visit->visit_date)->format('m.d') : '--.--';

            $output[] = $item;
        }

        return response()
            ->json($output);
    }

    public function createByAdministrator(Request $request)
    {
        try {
            if (!$request->post('patient_id')) {
                throw new UncategorizedApiException('Необходимо указать пациента');
            }

            $patient = Patient::find($request->post('patient_id'));

            if (!$patient) {
                throw new UncategorizedApiException('Выбранного пациента не существует! Возможно он был кем-то удалён');
            }

            $visit = new Visit();

            if ($request->post('dest')) {
                $type = mb_substr($request->post('dest'), 0, 1);
                $id = mb_substr($request->post('dest'), 1, 1);

                if ($type === 'c') {
                    $visit->clinic_id = $id;
                } else if ($type === 'd') {
                    $visit->doctor_id = $id;
                } else {
                    throw new UncategorizedApiException('Undefined type of destination: ' . $type);
                }
            }

            if ($request->post('cause')) {
                $visit->cause = $request->post('cause');
            }

            if ($request->post('date')) {
                $visit->visit_date = Carbon::parse($request->post('date'));
            }

            if ($request->post('time')) {
                $visit->visit_time = Carbon::parse($request->post('time'));
            }

            $visit->patient_id = $patient->id;

            $visit = $visit->save();

            if (!$visit) {
                throw new UncategorizedApiException('Визит не был создан! Повторите попытку заново');
            }

            return response()
                ->json(['success' => 'Визит успешно создан!']);
        } catch (Throwable $e) {
            throw new UncategorizedApiException($e->getMessage());
        }
    }

    public function getByAdministrator(Request $request, $offset)
    {
        $validator = Validator::make($request->all(),
            [
                'statuses' => 'bail|json',
                'date_start' => 'bail|date|date_format:Y-m-d',
                'date_end' => 'bail|date|date_format:Y-m-d',
                'doctors' => 'bail|json',
                'patients' => 'bail|json'
            ],
            [
                'statuses.json' => 'Некорректный тип переменной statuses',
                'date_start.date' => 'Некорректный тип переменной date_start',
                'date_start.date_format' => 'Некорректный формат даты date_start',
                'date_end.json' => 'Некорректный тип переменной date_start',
                'date_end.date_format' => 'Некорректный формат даты date_end',
                'doctors.json' => 'Некорректный тип переменной doctors',
                'patients.json' => 'Некорректный тип переменной patients'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visits = Visit::with(['doctor:id,first_name,last_name,middle_name', 'status', 'patient:id,first_name,last_name,middle_name']);

        if ($request->get('statuses')) {
            $visits->whereIn('visit_status_id', json_decode($request->get('statuses')));
        }

        if ($request->get('date_start')) {
            $visits->where('visit_date', '>=', $request->get('date_start'));
        }

        if ($request->get('date_end')) {
            $visits->where('visit_date', '<=', $request->get('date_end'));
        }

        if ($request->get('doctors')) {
            $visits->whereIn('doctor_id', json_decode($request->get('doctors')));
        }

        if ($request->get('patients')) {
            $visits->whereIn('patient_id', json_decode($request->get('patients')));
        }

        $visits = $visits->offset($offset)->limit(15)->orderByDesc('id')->get();

        $output = [];

        foreach ($visits as $visit) {
            $item['id'] = $visit->id;
            $item['status'] = $visit->status->name ?: null;

            if ($visit->doctor) {
                $item['doctor'] = [
                    $visit->doctor->id,
                    $visit->doctor->last_name . ' ' . mb_substr($visit->doctor->first_name, 0, 1) . '.' . mb_substr($visit->doctor->middle_name, 0, 1) . '.'
                ];
            } else {
                $item['doctor'] = null;
            }

            if ($visit->patient) {
                $item['patient'] = [
                    $visit->patient->id,
                    $visit->patient->last_name . ' ' . mb_substr($visit->patient->first_name, 0, 1) . '.' . mb_substr($visit->patient->middle_name, 0, 1) . '.'
                ];
            }

            $item['cause'] = $visit->cause ?: null;

            $item['time'] = $visit->visit_time ? Carbon::parse($visit->visit_time)->format('H:i') : '--:--';
            $item['date'] = $visit->visit_date ? Carbon::parse($visit->visit_date)->format('m.d') : '--.--';

            $output[] = $item;
        }

        return response()
            ->json($output);
    }

    public function updateStatusByAdministrator(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['status_id' => 'bail|required|in:1,2,3,4,5,6'],
            [
                'status_id.required' => 'Необходимо указать айди статуса',
                'status_id.in' => 'Айди статуса вне диапазона допустимых значений'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visit = Visit::find($id);

        if ($visit === null) {
            throw new UncategorizedApiException('Данного визита не существует! Возможно он был недавно удалён');
        }

        $status = VisitStatus::find($request->post('status_id'));

        if ($status === null) {
            throw new UncategorizedApiException('Данного статуса не существует');
        }

        if ($status->id === $visit->visit_status_id) {
            throw new UncategorizedApiException('Данный визит уже имеет выбранный статус');
        }

        $visit->status()->associate($status);

        if (!$visit->save()) {
            throw new UncategorizedApiException('Не удалось обновить статус визита');
        }

        return response()
            ->json(['success' => 'Статус визита успешно обновлён']);
    }

    public function updateStatusByDoctor(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['status_id' => 'bail|required|in:2,3,4,5,6'],
            [
                'status_id.required' => 'Необходимо указать айди статуса',
                'status_id.in' => 'Айди статуса вне диапазона допустимых значений'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visit = Visit::find($id);

        if ($visit === null) {
            throw new UncategorizedApiException('Данного визита не существует! Возможно он был недавно удалён');
        }

        $status = VisitStatus::find($request->post('status_id'));

        if ($status === null) {
            throw new UncategorizedApiException('Данного статуса не существует');
        }

        if ($status->id === $visit->visit_status_id) {
            throw new UncategorizedApiException('Данный визит уже имеет выбранный статус');
        }

        if ($status->id < $visit->visit_status_id) {
            throw new UncategorizedApiException('Изменять статус можно только в восходящем порядке');
        }

        if ($status->id === 6 and in_array($visit->visit_status_id, [4, 5])) {
            throw new UncategorizedApiException('Нельзя отменить визит, так как он уже проведён');
        }

        $visit->status()->associate($status);

        if (!$visit->save()) {
            throw new UncategorizedApiException('Не удалось обновить статус визита');
        }

        return response()
            ->json(['success' => 'Статус визита успешно обновлён']);
    }

    public function move(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'visit_date' => 'bail|nullable|date_format:Y-m-d',
                'visit_time' => 'bail|nullable|date_format:H:i',
            ],
            [
                'visit_date.date_format' => 'Некорректный форматы даты',
                'visit_time.date_format' => 'Некорректный форматы времени'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visit = Visit::find($id);

        if ($visit === null) {
            throw new UncategorizedApiException('Данного визита не существует! Возможно он был недавно удалён');
        }

        if ($visit->visit_status_id !== 1 && Authorization::user()->privileges_id !== 2) {
            throw new UncategorizedApiException('Сместить можно только визит со статусом \'На рассмотрении\'');
        }

        $visit->visit_date = $request->post('visit_date') ?: null;
        $visit->visit_time = $request->post('visit_time') ?: null;

        if (!$visit->save()) {
            throw new UncategorizedApiException('Не удалось обновить статус визита');
        }

        return response()
            ->json(['success' => 'Визит успешно перемещён']);
    }

    public function getByDoctor(Request $request, $offset)
    {
        $validator = Validator::make($request->all(),
            [
                'statuses' => 'bail|json',
                'date_start' => 'bail|date|date_format:Y-m-d',
                'date_end' => 'bail|date|date_format:Y-m-d',
                'patients' => 'bail|json'
            ],
            [
                'statuses.json' => 'Некорректный тип переменной statuses',
                'date_start.date' => 'Некорректный тип переменной date_start',
                'date_start.date_format' => 'Некорректный формат даты date_start',
                'date_end.json' => 'Некорректный тип переменной date_start',
                'date_end.date_format' => 'Некорректный формат даты date_end',
                'patients.json' => 'Некорректный тип переменной patients'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visits = Visit::with(['status', 'patient:id,first_name,last_name,middle_name'])
            ->where('doctor_id', Authorization::user()->id);

        if ($request->get('statuses')) {
            $visits->whereIn('visit_status_id', json_decode($request->get('statuses')));
        }

        if ($request->get('date_start')) {
            $visits->where('visit_date', '>=', $request->get('date_start'));
        }

        if ($request->get('date_end')) {
            $visits->where('visit_date', '<=', $request->get('date_end'));
        }

        if ($request->get('patients')) {
            $visits->whereIn('patient_id', json_decode($request->get('patients')));
        }

        $visits = $visits->offset($offset)->limit(15)->orderByDesc('id')->get();

        $output = [];

        foreach ($visits as $visit) {
            $item['id'] = $visit->id;
            $item['status'] = $visit->status->name ?: null;

            if ($visit->patient) {
                $item['patient'] = [
                    $visit->patient->id,
                    $visit->patient->last_name . ' ' . mb_substr($visit->patient->first_name, 0, 1) . '.' . mb_substr($visit->patient->middle_name, 0, 1) . '.'
                ];
            }

            $item['cause'] = $visit->cause ?: null;

            $item['time'] = $visit->visit_time ? Carbon::parse($visit->visit_time)->format('H:i') : '--:--';
            $item['date'] = $visit->visit_date ? Carbon::parse($visit->visit_date)->format('m.d') : '--.--';

            $output[] = $item;
        }

        return response()
            ->json($output);
    }

    public function attachIllness(Request $request, $visitId)
    {
        $validator = Validator::make($request->all(),
            ['illness' => 'required'],
            ['illness.required' => 'Необходимо указать болезнь']
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $visit = Visit::find($visitId);
        $user = Authorization::user();

        if (get_class($user) === Administrator::class and $user->privileges_id !== 2) {
            throw new UncategorizedApiException('У вас нет прав на привязывание заболевания к визиту!');
        }

        if (!$visit) {
            throw new UncategorizedApiException('Визита не существует! Возможно он был кем-то удалён');
        }

        if ($visit->visit_status_id === 5 and $user->privileges_id !== 2) {
            throw new UncategorizedApiException('Визит уже завершен');
        }

        if ($visit->visit_status_id === 6 and $user->privileges_id !== 2) {
            throw new UncategorizedApiException('Визит был отменён');
        }

        if (is_numeric($request->post('illness'))) {
            $illness = Illness::find($request->post('illness'));
        } else {
            $illness = new Illness;

            $illness->title = $request->post('illness');
            $illness->patient_id = $visit->patient_id;

            if (!$illness->save()) {
                throw new UncategorizedApiException('Не удалось создать новую болезнь');
            }
        }

        if (!$illness) {
            throw new UncategorizedApiException('Данной болезни не существует! Возможно она была кем-то удалена');
        }

        $visit->illness()->associate($illness);

        if (!$visit->save()) {
            throw new UncategorizedApiException('Не удалось прикрепить болезнь к визиту');
        }

        return response()
            ->json(['success' => 'Болезнь успешно прикреплена к визиту']);
    }

    public function updateResult(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['result' => 'required'],
            ['result.required' => 'Необходимо указать заключение']
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $user = Authorization::user();

        if (get_class($user) === Administrator::class and $user->privileges_id !== 2) {
            throw new UncategorizedApiException('Вы не имеете прав на редактирование заключения врача');
        }

        $visit = Visit::findOrFail($id);

        if (in_array($visit->visit_status_id, [5, 6]) && Authorization::user()->privileges_id !== 2) {
            throw new UncategorizedApiException('Визит уже завершён или отменён');
        }

        if (strlen($request->post('result')) > 2048) {
            throw new UncategorizedApiException('Заключение визита не должно превышать длину в 2048 символов');
        }

        $visit->result = $request->post('result');

        if(!$visit->save()) {
            throw new UncategorizedApiException('Не удалось обновить заключение визита');
        }

        return response()
            ->json(['success' => 'Заключение успешно сохранено']);
    }

    public function updateDoctor(Request $request, $id)
    {
        if (Authorization::user()->privileges_id !== 2) {
            throw new UncategorizedApiException('У вас нет прав на редактирование врача у визита');
        }

        $visit = Visit::find($id);

        if ($visit === null) {
            throw new UncategorizedApiException('Не удалось найти визит! Возможно он был кем-то удалён');
        }

        $doctor = Doctor::find($request->post('doctor_id'));

        if ($doctor === null) {
            throw new UncategorizedApiException('Не удалось найти врача! Возможно он был кем-то удалён');
        }

        $visit->doctor()->associate($doctor);

        if (!$visit->save()) {
            throw new UncategorizedApiException('Не удалось сохранить изменения');
        }

        return response()
            ->json(['success' => 'Врач успешно привязан к визиту']);
    }

    public function updatePatient(Request $request, $id)
    {
        if (Authorization::user()->privileges_id !== 2) {
            throw new UncategorizedApiException('У вас нет прав на редактирование пациента у визита');
        }

        $visit = Visit::find($id);

        if ($visit === null) {
            throw new UncategorizedApiException('Не удалось найти визит! Возможно он был кем-то удалён');
        }

        $patient = Patient::find($request->post('patient_id'));

        if ($patient === null) {
            throw new UncategorizedApiException('Не удалось найти пациента! Возможно он был кем-то удалён');
        }

        $visit->patient()->associate($patient);

        if (!$visit->save()) {
            throw new UncategorizedApiException('Не удалось сохранить изменения');
        }

        return response()
            ->json(['success' => 'Пациент успешно привязан к визиту']);
    }
}
