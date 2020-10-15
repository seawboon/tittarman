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
use Spatie\Permission\Models\Role;

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
      $myBranchID = '';
      if(Session::get('myBranch')) {
        $myBranch = Session::get('myBranch');
        $myBranch = session('myBranch');
        $myBranchID = $myBranch->id;
      } else {
        return redirect()->route('checkin.mybranch');
      }

      $branches = Branches::pluck('name','id')->all();

      $nranc = Branches::all(['id','name as title']);
      $tiBranch = json_encode($nranc);

      $patients = Patient::where('branch_id', 'like', '%'.$myBranchID.'%')->whereDate('created_at', Carbon::today())->get();
      $appo = Appointment::where('branch_id', 'like', '%'.$myBranchID.'%')->whereDate('appointment_date', Carbon::today())->get();
      $treats = Payment::where('branch_id', 'like', '%'.$myBranchID.'%')->whereDate('created_at', Carbon::today())->get();

      $events = Appointment::whereDate('appointment_date', '>',Carbon::today()->subDays(30))->whereDate('appointment_date', '<',Carbon::today()->addDays(60))->get();
      $event_list = [];
      $hs = [];
      foreach ($events as $key => $event) {
        if(isset($event->user)) {
          $eventkk = $event->user->name.' - '.$event->salutation.' '.$event->name;
        } else {
          $eventkk = $event->salutation.' '.$event->name;
        }

        $kk = new class{};

        $kk->id = $event->id;
        $kk->resourceId = $event->branch_id;
        $kk->start = $event->appointment_date;
        $kk->end = '';
        $kk->title = $event->salutation.'. '.$event->name.' ('.$event->state.')';
        $kk->url = route('appointments.edit', $event->id);
        if(isset($event->user)) {
          //$kk->title .= ' - '.$event->user->name;
          $kk->color = $event->user->color;
        }


        array_push($hs, $kk);
      }


      $event_list = json_encode($event_list);
      $hs = json_encode($hs);

      $role = Role::where('name', 'master')->first();
      $master = $role->users()->get();

      $calendar=array(
          'branches' => $tiBranch,
          'events' => $hs,
          'master' => $master
      );

      return view('dashboard', compact('patients', 'treats', 'appo', 'calendar', 'branches'));
    }

    public function mybranch()
    {
        return view('checkin.choose');
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
