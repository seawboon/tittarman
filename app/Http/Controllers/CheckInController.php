<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Matter;
use App\Treat;
use App\CheckIn;
use App\Branches;
use App\Appointment;
use App\Payment;
use App\User;
use Spatie\Permission\Models\Role;
use Calendar;

use Session;

class CheckInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CheckIns()
    {
      if(Session::get('myBranch')) {
        $myBranch = Session::get('myBranch');
        $myBranch = session('myBranch');
        $checkins = Checkin::where('branch_id', $myBranch->id)->whereDate('created_at', Carbon::today())->get();
        $checkins->load('patient', 'branch', 'matter');

        $payments = Payment::where('branch_id', $myBranch->id)->whereDate('created_at', Carbon::today())->get();
        /*$patient->load(['matters' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'treats']);*/

        return view('checkin.index', compact('checkins','payments'));
      } else {
        return redirect()->route('checkin.mybranch');
      }

    }

    public function create(Patient $patient, Request $request)
    {
        $branches = Branches::pluck('name','id')->all();
        $role = Role::where('name', 'master')->first();
        $users = $role->users()->pluck('name','id')->all();
        $extra = null;
        if($request->input()) {
          $extra['matter'] = Matter::find($request->input('matter'));
        }
        return view('checkin.create', compact('patient','branches','users', 'extra'));
    }

    public function storeCreate(Patient $patient, Request $request)
    {
        $data = request()->validate([
          'branch_id' => 'required',
          'user_id' => '',
          'matter_id' => '',
          'patient_id' => 'required',
          'state' => 'awaiting',
        ]);

        $checkin = $patient->checkins()->create($data);

        return redirect()->route('checkin.index');
    }

    public function edit(CheckIn $checkin, Request $request)
    {
        $branches = Branches::pluck('name','id')->all();
        $role = Role::where('name', 'master')->first();
        $users = $role->users()->pluck('name','id')->all();
        return view('checkin.edit', compact('checkin', 'branches', 'users'));
    }

    public function update(CheckIn $checkin, Request $request)
    {
        $data = request()->validate([
          'branch_id' => 'required',
          'user_id' => '',
          'matter_id' => '',
          'patient_id' => 'required',
        ]);

        $checkin->update($data);

        return redirect()->route('checkin.index');
    }

    public function actionCheckIn($action, CheckIn $checkin, Request $request )
    {
      $checkin->state = $action;
      //$checkin->user_id = $request->user;
      $checkin->save();
      if($request->input()) {
        if($request->input('matter')) {
          if($action=='paid' && $request->input('matter')) {
            return redirect()->route('treat.edit', ['patient' => $request->input('patient'), 'matter' => $request->input('matter'), 'treat' => $request->input('treat') ]);
          } else {
            return redirect()->route('matter.edit', ['patient' => $request->input('patient'), 'matter' => $request->input('matter') ]);
          }
        } else {
          return redirect()->route('matter.create', ['patient' => $request->input('patient')]);
        }
      } else {
        return redirect()->route('checkin.index');
      }

    }

    public function storeCheckIn(Patient $patient)
    {
      if(Session::get('myBranch')) {
        $myBranch = Session::get('myBranch');
        $myBranch = session('myBranch');
        $data['branch_id'] = $myBranch->id;
        if(request()->matter) {
          $data['matter_id'] = request()->matter;
        }

        $exist = CheckIn::whereDate('created_at', Carbon::today())
        ->where('patient_id', $patient->id)
        ->where('state', 'awaiting')
        ->where('branch_id', $myBranch->id)
        ->get();
        if(count($exist) == 0) {
          $checkin = $patient->checkins()->create($data);
        }

        return redirect()->route('checkin.index');

      } else {
        return redirect()->route('checkin.mybranch');
      }

    }

    public function storeCheckInFromAppointment(Patient $patient, Appointment $appo, Request $request)
    {
      if(Session::get('myBranch')) {
        $myBranch = Session::get('myBranch');
        $myBranch = session('myBranch');
        $data['branch_id'] = $myBranch->id;
        if(request()->matter) {
          $data['matter_id'] = request()->matter;
        }

        if(request()->user) {
          $data['user_id'] = request()->user;
        }

        $appo->state = 'checkin';
        $appo->save();

        if(!request()->user) {
          return redirect()->route('checkin.create', $patient);
        }

        $exist = CheckIn::whereDate('created_at', Carbon::today())
        ->where('patient_id', $patient->id)
        ->where('state', 'awaiting')
        ->where('branch_id', $myBranch->id)
        ->get();
        if(count($exist) == 0) {
          $checkin = $patient->checkins()->create($data);
        }

        return redirect()->route('checkin.index');

      } else {
        return redirect()->route('checkin.mybranch');
      }

    }
}
