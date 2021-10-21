<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Voucher;
use App\PatientPackage;
use App\PatientVoucher;
use PDF;

class VoucherController extends Controller
{
    public function index(Patient $patient)
    {
        //$patient = Patient::with('matters')->get();
        //$patient->load('matters');

        /*$patient->load(['matters' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'treats']);*/

        $patient->load('packages.patientvouchers.useInPayment.treat.branch');
        /*$vouchers = $patient->vouchers()->paginate(10);
        $transfers = $patient->transfers()->paginate(10);*/

      return view('voucher.index', compact('patient'/*, 'vouchers', 'transfers'*/));
    }

    public function updateVouchers(Patient $patient, Request $request)
    {
        //dd($request->all());
        PatientVoucher::where('patient_package_id', $request->package_id)
        ->update(['expired_date' => $request->package_voucher_expiry_date]);
        /*foreach($request->voucher as $voucher) {
          $newExpiry = PatientVoucher::find($voucher['id']);
          $newExpiry->expired_date = $voucher['expiry'];
          if($newExpiry->isDirty('expired_date')) {
            $newExpiry->save();
          }
        }*/

        return redirect()->route('voucher.index', $patient);
    }

    public function updateSingleCode(PatientVoucher $code, Request $request)
    {
        $chk = PatientVoucher::where('code', $request['voucher-code'])->first();

        if ($chk === null) {
          $code->code = $request['voucher-code'];
          $code->save();
        }

        return redirect()->back();

        //return redirect()->route('voucher.index', $patient);
    }

    public function packagePdf(PatientPackage $package)
    {
      $package->load('patientvouchers','patient.accounts','package');
      $package->alacarte = json_decode($package->alacarte, true);
      $pdf = PDF::loadView('voucher.packagePdf', compact('package'));
      $patientName = strtolower($package->patient->fullname);
      $patientName = str_replace(' ', '-', $patientName);
      $filename = $patientName.'-'.str_replace(' ', '-',$package->variant->name).'_'.Carbon::now()->format('d-M-Y');
    	return $pdf->stream($filename.'.pdf');
      //return view('voucher.packagePdf', compact('package'));
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
