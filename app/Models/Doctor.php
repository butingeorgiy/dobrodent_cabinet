<?php

namespace App\Models;

use App\Facades\Authorization;
use App\Models\AuthTokens\DoctorToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Doctor extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function tokens()
    {
        return $this->hasMany(DoctorToken::class);
    }

    public function invalidTokens()
    {
        return $this->hasMany(DoctorToken::class)->where(
            DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
            '>',
            DB::raw('`time_valid`')
        );
    }

    public function occupations()
    {
        return $this->belongsToMany(Occupation::class, 'doctors_occupations');
    }

    public function phones() {
        return $this->hasMany(DoctorPhone::class);
    }

    public function patients() {
        return $this->hasManyThrough(Patient::class, Visit::class, 'doctor_id', 'id', 'id', 'patient_id')
            ->distinct();
    }

    public function likes()
    {
        return $this->belongsToMany(Patient::class, 'patients_likes_doctors');
    }

    static public function search($value, $offset, $liteSearch = false)
    {
        $output = [];
        $value = str_replace(' ', '|', $value);

        if (trim($value) === '') {
            $doctors = DB::table('doctors')
                ->leftJoin('doctors_occupations', 'doctors.id', '=', 'doctors_occupations.doctor_id')
                ->leftJoin('occupations', 'occupations.id', '=', 'doctors_occupations.occupation_id')
                ->selectRaw('doctors.id as id, full_name')
                ->whereNull('deleted_at')
                ->limit(15)
                ->offset($offset)
                ->get();
        } else {
            $doctors = DB::table('doctors')
                ->leftJoin('doctors_occupations', 'doctors.id', '=', 'doctors_occupations.doctor_id')
                ->leftJoin('occupations', 'occupations.id', '=', 'doctors_occupations.occupation_id')
                ->selectRaw(
                    'doctors.id, CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(LOWER(REPLACE(CONCAT(full_name, IF(occupations.title IS NOT NULL, occupations.title, \'\')), \' \', \'\')), ?, \'~\', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency, full_name',
                    [$value]
                )
                ->whereNull('deleted_at')
                ->having('frequency', '>', 0)
                ->orderByDesc('frequency')
                ->limit(15)
                ->offset($offset)
                ->get();
        }

        $user = Authorization::user();

        foreach ($doctors->unique('id') as $doctor) {
            $item = [
                'id' => $doctor->id,
                'full_name' => $doctor->full_name
            ];

            $avatar = asset('images/default_profile.jpg');

            if (Storage::exists('profile_photos/doctors/' . $doctor->id . '.jpeg')) {
                $avatar = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/doctors/' . $doctor->id . '.jpeg'));
            }

            $item['profile_photo'] = $avatar;
            $item['occupation'] = null;

            $doctorEloquent = Doctor::find($doctor->id);

            $occupations = $doctorEloquent->occupations()->get();

            foreach ($occupations as $i => $occupation) {
                $item['occupation'] .= $occupation->title;

                if ($i < count($occupations) - 1) {
                    $item['occupation'] .= ', ';
                }
            }

            if (!$item['occupation']) {
                $item['occupation'] = 'Специализация не указана';
            }

            if (!$liteSearch) {
                $likes = $doctorEloquent->likes();

                $item['likes'] = $likes->get()->count();

                if (get_class($user) === Patient::class) {
                    $item['is_liked'] = $likes->get()->contains($user);
                } else {
                    $item['is_liked'] = false;
                }
            }

            $output[] = $item;
        }

        return $output;
    }

    public function getBirthdayAttribute($value)
    {
        if ($value) {
            $cbTime = Carbon::parse($value);

            return $cbTime->toDateString();
        } else {
            return null;
        }
    }
}
