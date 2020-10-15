<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Branches;
use App\Appointment;
use Spatie\Permission\Models\Role;

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
}
