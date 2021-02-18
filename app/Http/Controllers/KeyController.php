<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;

class KeyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.apikey');
    }

    public function details(Patient $patient)
    {
        return $patient;
    }
}
