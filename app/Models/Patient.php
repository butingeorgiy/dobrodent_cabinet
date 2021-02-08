<?php

namespace App\Models;

use App\Facades\Authorization;
use App\Models\AuthTokens\PatientToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Patient extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public function tokens()
    {
        return $this->hasMany(PatientToken::class);
    }

    public function invalidTokens() {
        return $this->hasMany(PatientToken::class)->where(
                DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
                '>',
                DB::raw('`time_valid`')
        );
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = hash('sha256', $value);
    }

    public function scopeByPhone($query, $value)
    {
        return $query->where(DB::raw('CONCAT(`phone_code`, `phone`)'), $value);
    }

    public function getBirthdayAttribute($value)
    {
        $cbTime = Carbon::parse($value);

        return $cbTime->toDateString();
    }

    static public function searchByAdministrator($value, $offset)
    {
        $selectRaw = 'id, phone_code, phone, full_name';
        $value = str_replace(' ', '|', $value);

        if (trim($value) !== '') {
            $selectRaw .= ', CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(REPLACE(CONCAT(full_name, phone_code, phone), \' \', \'\'), ?, \'~\', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency';
            $patients = Patient::selectRaw($selectRaw, [$value])
                ->orderBy('frequency', 'desc')
                ->having('frequency', '>', 0);
        } else {
            $patients = Patient::selectRaw($selectRaw);
        }

        $patients = $patients
            ->limit(15)
            ->offset($offset)->get();

        $output = [];

        foreach ($patients as $patient) {
            $item['id'] = $patient->id;
            $item['full_name'] = $patient->full_name;
            $item['phone'] = '+' . $patient->phone_code . ' ' . preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2 $3', $patient->phone);
            $item['profile_photo'] = asset('images/default_profile.jpg');

            if (Storage::exists('profile_photos/patients/' . $patient->id . '.jpeg')) {
                $item['profile_photo'] = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id . '.jpeg'));
            }

            $output[] = $item;
        }

        return $output;
    }

    static public function searchByDoctor($value, $offset)
    {
        $selectRaw = 'DISTINCT patients.id as id, phone_code, phone, full_name, IF(visits.id IS NOT NULL, true, false) as was_visit';
        $value = str_replace(' ', '|', $value);

        $patients = Patient::leftJoin('visits', function ($join) {
            $join
                ->on('patients.id', '=', 'visits.patient_id')
                ->where('visits.doctor_id', '=', Authorization::user()->id);
        });

        if (trim($value) !== '') {
            $selectRaw .= ', CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(REPLACE(CONCAT(full_name, phone_code, phone), \' \', \'\'), ?, \'~\', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency';
            $patients = $patients
                ->selectRaw($selectRaw, [$value])
                ->orderBy('frequency', 'desc')
                ->having('frequency', '>', 0);
        } else {
            $patients = $patients->selectRaw($selectRaw);
        }

        $patients = $patients
            ->orderBy('was_visit', 'desc')
            ->limit(15)
            ->offset($offset)->get();
        $output = [];

        foreach ($patients as $patient) {
            $item['id'] = $patient->id;
            $item['full_name'] = $patient->full_name;
            $item['was_visit'] = $patient->was_visit;
            $item['phone'] = '+' . $patient->phone_code . ' ' . preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2 $3', $patient->phone);
            $item['profile_photo'] = asset('images/default_profile.jpg');

            if (Storage::exists('profile_photos/patients/' . $patient->id . '.jpeg')) {
                $item['profile_photo'] = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id . '.jpeg'));
            }

            $output[] = $item;
        }

        return $output;
    }
}
