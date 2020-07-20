<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Voucher;

class VoucherController extends Controller
{
    public function index(Patient $patient)
    {
        //$patient = Patient::with('matters')->get();
        //$patient->load('matters');

        /*$patient->load(['matters' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'treats']);*/
        $vouchers = $patient->vouchers()->paginate(10);

        //dd($patient);

        //$age = Carbon::parse($patient->dob)->age;
        //dd($patient);
        //$matters = Patient::paginate(10);
        return view('voucher.index', compact('patient', 'vouchers'));
    }
}
