<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Appointment;
use App\Patient;
use App\Matter;
use App\User;
use App\Branches;

class AppointmentController extends Controller
{
    public function index()
    {
        $appos = Appointment::paginate(10);
        return view('appointment.index', compact('appos'));
    }

    public function create(Request $request)
    {
        //dd($request->input());
        $extra = null;
        if($request->input()) {
          $extra['patient'] = Patient::find($request->input('patient'));
          $extra['matter'] = Matter::find($request->input('matter'));
        }
        $branches = Branches::pluck('name','id')->all();
        $users = User::pluck('name','id')->all();
        return view('appointment.create', compact('branches','users', 'extra'));
    }

    public function store(Request $request)
    {

      $data = request()->validate([
        'branch_id' => 'required',
        'user_id' => '',
        'matter_id' => '',
        'patient_id' => '',
        'salutation' => '',
        'name' => 'required',
        'email' => '',
        'provider' => 'required',
        'contact' => 'required|integer',
        'appointment_date' => 'required',
        'remarks' => '',
      ]);

      Appointment::create($data);

      return redirect()->route('appointments.index');

    }

    public function edit(Appointment $appointment)
    {
        $appo = $appointment;
        $branches = Branches::pluck('name','id')->all();
        $users = User::pluck('name','id')->all();
        return view('appointment.edit', compact('appo','branches','users'));
    }

    public function update(Appointment $appointment)
    {

      $data = request()->validate([
        'branch_id' => 'required',
        'user_id' => '',
        'matter_id' => '',
        'patient_id' => '',
        'salutation' => '',
        'name' => 'required',
        'email' => '',
        'provider' => 'required',
        'contact' => 'required|integer',
        'appointment_date' => 'required',
        'remarks' => '',
        'state' => '',
      ]);

      $appointment->update($data);

      return redirect()->route('appointments.index');

    }

}
