<?php

namespace App\Models;

use App\Facades\Authorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Visit extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function status()
    {
        return $this->belongsTo(VisitStatus::class, 'visit_status_id', 'id');
    }

    public function illness()
    {
        return $this->belongsTo(Illness::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function attachments()
    {
        return $this->hasMany(VisitAttachment::class);
    }

    static public function search($value, $offset, $liteSearch = false)
    {
        $output = [];
        $value = str_replace(' ', '|', $value);
        $selectRaw = 'visits.id, visits.visit_date, CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(REPLACE(CONCAT(IF(visits.cause IS NOT NULL, visits.cause, \'\'), IF(visits.result IS NOT NULL, visits.result, \'\'), IF(visit_attachments.id IS NOT NULL, visit_attachments.name, \'\')), \' \', \'\'), ?, \'~\', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency, full_name';

        $user = Authorization::user();

        $visits = DB::table('visits')
            ->leftJoin('visit_attachments', 'visit_attachments.visit_id', '=', 'visits.id')
            ->having('frequency', '>', 0)
            ->orderByDesc('frequency')
            ->limit(15)
            ->offset($offset);

        if (get_class($user) !== Doctor::class) {
            $visits
                ->leftJoin('doctors', 'doctors.id', '=', 'visits.doctor_id')
                ->selectRaw($selectRaw . ', doctors.full_name, doctors.first_name, doctors.last_name, doctors.middle_name', [$value]);

            if (get_class($user) === Patient::class) {
                $visits
                    ->where('patient_id', $user->id);
            }
        } else {
            $visits
                ->leftJoin('patients', 'patients.id', '=', 'visits.patient_id')
                ->selectRaw($selectRaw . ', patients.full_name, patients.first_name, patients.last_name, patients.middle_name', [$value])
                ->where('visits.doctor_id', $user->id);
        }

        foreach ($visits->get()->unique('id') as $visit) {
            $item['id'] = $visit->id;
            $item['visit_date'] = $visit->visit_date ? Carbon::parse($visit->visit_date)->format('m.d') : '--.--';

            if (get_class($user) !== Doctor::class) {
                $item['doctor_full_name'] = $visit->full_name ? $visit->last_name . ' ' . mb_substr($visit->first_name, 0, 1) . '.' . mb_substr($visit->middle_name, 0, 1) . '.' : 'Не указан';
            } else {
                $item['patient_full_name'] = $visit->full_name ? $visit->last_name . ' ' . mb_substr($visit->first_name, 0, 1) . '.' . mb_substr($visit->middle_name, 0, 1) . '.' : 'Не указан';;
            }

            $output[] = $item;
        }

        return $output;
    }
}
