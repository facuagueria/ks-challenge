<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    public function index()
    {
        return Dentist::with('country')->get();
    }

    public function getByFilter(Request $request)
    {
        $dentist = Dentist::with('country');
            if ($request->name !== null){
                $dentist->where('name', '=', $request->name);
            }
            if ($request->surname !== null){
                $dentist->where('surname', '=', $request->surname);
            }
            if ($request->country_id !== null){
                $dentist->where('country_id', '=', $request->country_id);
            }
            if ($request->created_at !== null){
                $dentist->where('created_at', '=', $request->created_at);
            }

        return $dentist->get();
    }
}
