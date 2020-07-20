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

    public function adminIndex(Request $request)
    {
        switch(request('show')) {
          case 'all':
            $vouchers = Voucher::where('state', 'like', '%%');
          break;

          case 'sold':
            $vouchers = Voucher::where('patient_id', '!=', '');
          break;

          case 'claimed':
          $vouchers = Voucher::where('state', 'claimed');
          break;

          default:
            $vouchers = Voucher::where('state', 'enable')->where('patient_id', null);
        }

        $vouchers = $vouchers->paginate(10);
        return view('voucher.admin.index', compact('vouchers'));
    }

}
