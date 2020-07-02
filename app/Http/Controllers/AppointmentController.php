<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;
use App\Appointment;
use App\Patient;
use App\Matter;
use App\User;
use App\Branches;
use App\Rules;

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
          if($request->input('matter')) {
            $extra['matter'] = Matter::find($request->input('matter'));
          }
        }
        $branches = Branches::pluck('name','id')->all();
        $users = User::pluck('name','id')->all();
        return view('appointment.create', compact('branches','users', 'extra'));
    }

    public function store(Request $request)
    {
      //dd(request()->appointment_date);
      $test = Appointment::where('user_id',request()->user_id)->where('appointment_date', 'like', request()->appointment_date . '%' )->get();
      //dd($test);
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
        'appointment_date' => [
            'required',
             Rule::unique('appointments')->where(function ($query) {
               $query->where('branch_id', request()->branch_id)
               ->where('user_id', request()->user_id)
               ->where('state', '!=', 'cancelled')
               ->where('appointment_date', 'like', request()->appointment_date . '%' );
             }),
        ],
        'remarks' => '',
      ]);

      Appointment::updateOrCreate($data);

      return redirect()->route('appointments.index');

    }

    public function edit(Appointment $appointment)
    {
        $appo = $appointment;
        $branches = Branches::pluck('name','id')->all();
        $users = User::pluck('name','id')->all();
        return view('appointment.edit', compact('appo','branches','users'));
    }

    public function update(Appointment $appointment, Request $request)
    {
      //dd($request->appointment_date);
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
        'appointment_date' => [
            'required',
             Rule::unique('appointments')->where(function ($query) {
               $query->where('id', '!=',request()->appointment_id)
               ->where('branch_id', request()->branch_id)
               ->where('user_id', request()->user_id)
               ->where('state', '!=', 'cancelled')
               ->where('appointment_date', 'like', request()->appointment_date . '%' );
             }),
        ],
        'remarks' => '',
        'state' => '',
      ]);

      $appointment->update($data);

      return redirect()->route('appointments.index');

    }



}
