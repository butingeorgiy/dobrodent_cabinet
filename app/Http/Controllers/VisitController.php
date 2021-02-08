<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\UncategorizedApiException;
use App\Facades\Authorization;
use App\Models\Administrator;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Illness;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\VisitAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    public function showByPatient($id)
    {
        $visit = Visit::where('patient_id', Authorization::user()->id)->findOrFail($id);

        $visit->load(['doctor:id,first_name,last_name,middle_name', 'illness:id,title']);

        $attachments = VisitAttachment::select('id', 'name')->where('visit_id', $id)->get();

        return view('patient.visit', compact('visit', 'attachments'));
    }

    public function showByAdministrator($id)
    {
        $visit = Visit::findOrFail($id);

        $visit->load(['doctor:id,first_name,last_name,middle_name', 'illness:id,title', 'patient:id,first_name,last_name,middle_name']);

        $attachments = VisitAttachment::select('id', 'name')->where('visit_id', $id)->get();

        $viewData = compact('visit', 'attachments');

        if (Authorization::user()->privileges_id === 2) {
            $viewData['illnesses'] = Illness::where('patient_id', $visit->patient_id)->get();

            $doctors = Doctor::all();

            foreach ($doctors as $doctor) {
                $data = [];

                $data['id'] = $doctor->id;
                $data['title'] = $doctor->full_name;

                $photo = asset('images/default_profile.jpg');

                if (Storage::exists('profile_photos/doctors/' . $doctor->id  . '.jpeg')) {
                    $photo = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/doctors/' . $doctor->id  . '.jpeg'));
                }

                $data['photo'] = $photo;

                $viewData['doctors'][] = $data;
            }

            $viewData['doctors'] = json_encode($viewData['doctors']);

            $patients = Patient::all();

            foreach ($patients as $patient) {
                $data = [];

                $data['id'] = $patient->id;
                $data['title'] = $patient->full_name;

                $photo = asset('images/default_profile.jpg');

                if (Storage::exists('profile_photos/patients/' . $patient->id  . '.jpeg')) {
                    $photo = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id  . '.jpeg'));
                }

                $data['photo'] = $photo;

                $viewData['patients'][] = $data;
            }

            $viewData['patients'] = json_encode($viewData['patients']);
        }

        return view('administrator.visit', $viewData);
    }

    public function showByDoctor($id) {
        $visit = Visit::where([
            ['id', $id],
            ['doctor_id', Authorization::user()->id]
        ])->get()->first();

        if ($visit === null) { abort(404); }

        $visit->load(['illness:id,title', 'patient:id,first_name,last_name,middle_name']);

        $attachments = VisitAttachment::select('id', 'name')->where('visit_id', $id)->get();

        $illnesses = Illness::where('patient_id', $visit->patient_id)->get();

        return view('doctor.visit', compact('visit', 'illnesses', 'attachments'));
    }

    public function attachFile(Request $request, $id)
    {
        $file = $request->file('attachment');

        $visit = Visit::find($id);

        if (!$visit) {
            throw new Exception('Визита не найдено! Возможно он был удалён кем-то');
        }

        if (in_array($visit->visit_status_id, [5,6]) && Authorization::user()->privileges_id !== 2) {
            throw new Exception('Нельзя прикрепить файл, так как визит уже завершен/отменён');
        }

        $visitAttachment = new VisitAttachment();

        $visitAttachment->visit_id = $visit->id;
        $visitAttachment->name = $file->getClientOriginalName();
        $visitAttachment->ext = $file->extension();

        if(!$visitAttachment->save()) {
            throw new UncategorizedApiException('Не удалось прикрепить файл');
        }

        $file->storeAs('visits_attachments', $visitAttachment->id . '.' . $file->extension());

        return back();
    }

    public function downloadAttachment($id)
    {
        $visitAttachment = VisitAttachment::findOrFail($id);

        $user = Authorization::user();

        if (get_class($user) === Doctor::class) {
            if (!Visit::where([['id', $visitAttachment->visit_id], ['doctor_id', $user->id]])->get()->first()) {
                abort(401);
            }
        }

        $filePath = storage_path('app/visits_attachments/' . $visitAttachment->id . '.' . $visitAttachment->ext);

        if (!Storage::exists('visits_attachments/' . $visitAttachment->id . '.' . $visitAttachment->ext)) {
            abort(404);
        }

        return response()
            ->download($filePath, $visitAttachment->name);
    }

    public function deleteAttachment($id)
    {
        $visitAttachment = VisitAttachment::findOrFail($id);

        $user = Authorization::user();

        $visit = Visit::where([['id', $visitAttachment->visit_id], ['doctor_id', $user->id]])->get()->first();

        if (get_class($user) === Doctor::class) {
            if (!$visit) {
                abort(401);
            }
        }

        if (in_array($visit->visit_status_id, [5,6]) && Authorization::user()->privileges_id !== 2) {
            throw new Exception('Нельзя удалить файл, так как визит уже завершен/отменён');
        }

        if (!Storage::exists('visits_attachments/' . $visitAttachment->id . '.' . $visitAttachment->ext)) {
            abort(404);
        }

        Storage::delete('visits_attachments/' . $visitAttachment->id . '.' . $visitAttachment->ext);
        $visitAttachment->delete();

        return back();
    }

    public function showCreationForm()
    {
        $entity = null;

        switch (get_class(Authorization::user())) {
            case Administrator::class:
                $entity = 'administrator';
                break;
            case Doctor::class:
                $entity = 'doctor';
                break;
            case Patient::class:
                $entity = 'patient';
                break;
            default:
                abort(401);
        }


        $options = [
            [
                'id' => '',
                'title' => 'Без назначения',
                'extra' => '',
                'photo' => asset('images/favicon.png')
            ]
        ];

        $clinics = Clinic::all();

        foreach ($clinics as $clinic) {
            $data = [];

            $data['id'] = 'c' . $clinic->id;
            $data['title'] = $clinic->name;
            $data['extra'] = $clinic->address ?: 'Адрес не указан';
            $data['photo'] = asset('images/clinic_default_profile.png');

            $options[] = $data;
        }


        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            $data = [];

            $data['id'] = 'd' . $doctor->id;
            $data['title'] = $doctor->full_name;

            $occupation = $doctor->occupations()->get()->first();

            $data['extra'] = $occupation->title ?? 'Нет специализации';

            $photo = asset('images/default_profile.jpg');

            if (Storage::exists('profile_photos/doctors/' . $doctor->id  . '.jpeg')) {
                $photo = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/doctors/' . $doctor->id  . '.jpeg'));
            }

            $data['photo'] = $photo;

            $options[] = $data;
        }

        $options = json_encode($options);

        $patientsOptions = [
            [
                'id' => '',
                'title' => 'Выбрать пациента',
                'photo' => asset('images/favicon.png')
            ]
        ];

        if ($entity !== 'patient') {
            $patients = Patient::all();

            foreach ($patients as $patient) {
                $data = [];

                $data['id'] = $patient->id;
                $data['title'] = $patient->full_name;

                $photo = asset('images/default_profile.jpg');

                if (Storage::exists('profile_photos/patients/' . $patient->id  . '.jpeg')) {
                    $photo = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id  . '.jpeg'));
                }

                $data['photo'] = $photo;

                $patientsOptions[] = $data;
            }

            $patientsOptions = json_encode($patientsOptions);
        }

        $data = [
            'options' => $options
        ];

        if ($entity !== 'patient') {
            $data['patientsOptions'] = $patientsOptions;
        }

        return view($entity . '.create-visit-form', $data);
    }
}
