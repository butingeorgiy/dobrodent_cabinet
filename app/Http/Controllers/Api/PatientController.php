<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Exception;
use App\Http\Controllers\Controller;

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
}
