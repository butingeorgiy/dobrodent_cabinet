<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
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
}
