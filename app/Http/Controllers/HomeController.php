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
use Calendar;

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

      $patients = Patient::where('branch_id', 'like', '%'.$myBranchID.'%')->whereDate('created_at', Carbon::today())->get();
      $appo = Appointment::where('branch_id', 'like', '%'.$myBranchID.'%')->whereDate('appointment_date', Carbon::today())->get();
      $treats = Payment::where('branch_id', 'like', '%'.$myBranchID.'%')->whereDate('created_at', Carbon::today())->get();

      $events = Appointment::where('branch_id', 'like', '%'.$myBranchID.'%')->get();
      $event_list = [];
      foreach ($events as $key => $event) {
        if(isset($event->user)) {
          $eventkk = $event->user->name.' - '.$event->salutation.' '.$event->name;
        } else {
          $eventkk = $event->salutation.' '.$event->name;
        }

        $event_list[] = Calendar::event(
          $eventkk,
          false,
          new \DateTime($event->appointment_date),
          new \DateTime($event->appointment_date),
          $event->id,
          [
            //'url' => 'https://fullcalendar.io/',
            'description' => 'Lecture'
          ]
        );
      }

      $calendar_details = Calendar::addEvents($event_list, [ //set custom color fo this event
                              //'color' => '#70db70',

                              //'display' => 'list-item',
                              //'textColor' => '#000',
                              'backgroundColor' => '#fff'
                          ])->setOptions([ //set fullcalendar options
                              //'header'=>['left'=>'prev, next today', 'center'=>'title', 'right'=>'listDay,listWeek,listMonth'],
                              'firstDay' => 1,
                              //'initialView' => 'listWeek'
                              //'editable' => true,
                              //'navLinks' => true
                          ]);

      return view('dashboard', compact('patients', 'treats', 'appo', 'calendar_details'));
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
