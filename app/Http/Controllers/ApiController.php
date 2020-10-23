<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;
use App\Branches;
use App\Appointment;
use App\Matter;
use Spatie\Permission\Models\Role;
use App\Rules;

class ApiController extends Controller
{
    public function calendar()
    {

      $nranc = Branches::all(['id','name as title']);
      //$nranc = Branches::select('id','name as title')->orderBy('id', 'desc')->get();
      //$tiBranch = json_encode($nranc);
      $tiBranch = $nranc;

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
        if($event->branch_id == 1) {
          $kk->classNames = ['MV-s'];
        } else {
          $kk->classNames = ['ARK-s'];
        }
        $kk->start = $event->appointment_date;
        $kk->end = '';
        if($event->patient_id) {
          $kk->title = $event->patient_id.'. ';
        } else {
          $kk->title = 'NEW ';
        }

        //$kk->title = $event->salutation.'. '.$event->name.' ('.$event->state.')';
        //$kk->title .= $event->salutation.'. '.$event->name.' - '.$event->provider.$event->contact;
        $kk->title .= $event->name.' - '.$event->provider.$event->contact;
        if($event->matter_id) {
          $Matter = Matter::find($event->matter_id);
          $kk->title .= ' ('.count($Matter->treats).')';
        } else {
          $kk->title .= ' (0)';
        }
        $kk->url = route('appointments.edit', $event->id);
        if(isset($event->user)) {
          //$kk->title .= ' - '.$event->user->name;
          $kk->color = $event->user->color;
        }

        array_push($hs, $kk);
      }


      $event_list = json_encode($event_list);
      //$hs = json_encode($hs);

      $role = Role::where('name', 'master')->first();
      $master = $role->users()->get();

      $calendar=array(
          'branches' => $tiBranch,
          'events' => $hs,
          'master' => $master
      );

      return compact('calendar');
    }

    public function calendarStore(Request $request) {
      //request()->validate([
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
        /*'appointment_date' => [
            'required',
             Rule::unique('appointments')->where(function ($query) {
               $query->where('branch_id', request()->branch_id)
               ->where('user_id', request()->user_id)
               ->where('state', '!=', 'cancelled')
               ->where('appointment_date', 'like', request()->appointment_date . '%' );
             }),
        ],*/
        'remarks' => '',
        'source' => '',
      ]);


      $result = Appointment::updateOrCreate($data);

      $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
      if($result){
      	$arr = array('msg' => 'Contact Added Successfully!', 'status' => true);
      }
      return Response()->json($arr);

    }

}
