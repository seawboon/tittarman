<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Voucher;
use App\PatientVoucher;

class VoucherController extends Controller
{
    public function index(Patient $patient)
    {
        //$patient = Patient::with('matters')->get();
        //$patient->load('matters');

        /*$patient->load(['matters' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'treats']);*/

        $patient->load('packages.patientvouchers');

        /*$vouchers = $patient->vouchers()->paginate(10);
        $transfers = $patient->transfers()->paginate(10);*/

      return view('voucher.index', compact('patient'/*, 'vouchers', 'transfers'*/));
    }

    public function updateVouchers(Patient $patient, Request $request)
    {
        foreach($request->voucher as $voucher) {
          $newExpiry = PatientVoucher::find($voucher['id']);
          $newExpiry->expired_date = $voucher['expiry'];
          if($newExpiry->isDirty('expired_date')) {
            $newExpiry->save();
          }
        }

        return redirect()->route('voucher.index', $patient);
    }

    public function transfer(Patient $patient, Voucher $voucher)
    {
      $patients = Patient::where('id', '!=', $voucher->patient_id)->get();
      return view('voucher.transfer', compact('patients', 'voucher', 'patient'));
    }

    public function transferUpdate(Patient $patient, Voucher $voucher, Request $request)
    {

      $data = request()->validate([
        'patient_id' => 'required',
        'owner_id' => 'required',
      ]);

      if($voucher->owner_id == null) {
        $voucher->owner_id = $request->owner_id;
      }
      $voucher->patient_id = $request->patient_id;
      $voucher->transfer = 'yes';
      $voucher->transfer_date = now();
      $voucher->update();

      return redirect()->route('voucher.index', $request->patient_id);

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
