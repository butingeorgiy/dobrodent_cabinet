<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    public function get(Request $request, $offset)
    {
        $doctors = Doctor::search($request->get('q') ?: '', $offset);

        return response()
            ->json($doctors);
    }

    public function generalSearch(Request $request)
    {
        $value = $request->get('q');

        if (!$value) {
            return [];
        }

        $output = [];

        $output['visits'] = Visit::search($value, 0, true);
        $output['patients'] = Patient::searchByAdministrator($value, 0);

        return $output;
    }
}
