<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Patient;
use App\Matter;
use App\Treat;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patients = Patient::get();
        $treats = Treat::get();
        $matters = Matter::get();

        return view('dashboard', compact('patients', 'treats', 'matters'));
    }
}
