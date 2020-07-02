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

use Session;

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

    public function mybranch()
    {
        return view('checkin.choose');
    }


    public function CheckIns()
    {
      if(Session::get('myBranch')) {
        $myBranch = Session::get('myBranch');
        $myBranch = session('myBranch');
        $checkins = Checkin::where('branch_id', $myBranch->id)->whereDate('created_at', Carbon::today())->get();
        $checkins->load('patient', 'branch', 'matter');


        /*$patient->load(['matters' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'treats']);*/

        return view('checkin.index', compact('checkins'));
      } else {
        return redirect()->route('checkin.mybranch');
      }

    }

    public function actionCheckIn($action, CheckIn $checkin, Request $request )
    {

      $checkin->state = $action;
      $checkin->save();
      if($request->input()) {
        if($request->input('matter')) {
          if($action=='paid' && $request->input('matter')) {
            return redirect()->route('treat.edit', ['patient' => $request->input('patient'), 'matter' => $request->input('matter'), 'treat' => $request->input('treat') ]);
          } else {
            return redirect()->route('matter.edit', ['patient' => $request->input('patient'), 'matter' => $request->input('matter') ]);
          }
        } else {
          return redirect()->route('patient.edit', ['patient' => $request->input('patient')]);
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

        $appo->state = 'checkin';
        $appo->save();

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

    public function setSession(Branches $branch)
    {
      Session::put('myBranch', $branch);
      return redirect()->route('home');
    }

    public function getSession()
    {
      $value = Session::get('myBranch');
      $value = session('myBranch');

      return $value;
    }

    public function forgetSession()
    {
      $value = Session::forget('myBranch');

      return $value;
    }


}
