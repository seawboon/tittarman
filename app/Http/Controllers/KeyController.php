<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;

class KeyController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth.apikey');
    }*/

    public function details(Patient $patient)
    {
        //dd($patient);
        return compact('patient');
    }

    public function search(Request $request)
    {
        //$data = request();
        $searchTerm = $request->search;
        if(empty($searchTerm)) {
          $searchTerm = '';
        }
        //$patients = Patient::whereLike(['fullname', 'email', 'nric'], $searchTerm)->get();
        $patients = Patient::whereLike(['fullname', 'email', 'nric', 'id', 'contact'], $searchTerm)->paginate(10);
        return compact('patients');
    }

}
