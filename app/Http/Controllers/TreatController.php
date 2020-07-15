<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Branches;
use App\Patient;
use App\Matter;
use App\injury;
use App\MatterInjury;
use App\Treat;
use App\User;
use Spatie\Permission\Models\Role;
use App\Product;
use App\TreatProduct;
use App\Images;
use App\Checkin;
use App\Payment;
use Image;
use File;

class TreatController extends Controller
{
    private $days = [
      '2' => '2 Days',
      '3' => '3 Days',
      '4' => '4 Days',
      '5' => '5 Days',
      '6' => '6 Days',
      '7' => '1 Week',
      '14' => '2 Weeks',
      '30' => '1 Month',
    ];

    public function index(Patient $patient, Matter $matter)
    {
        //$patient = Patient::with('matters')->get();
        $matter->load(['treats' => function ($query) {
            $query->orderBy('treat_date', 'desc');
        }]);

        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();

        $age = Carbon::parse($patient->dob)->age;
        //dd($patient);
        //$matters = Patient::paginate(10);
        return view('treat.index', compact('patient', 'age', 'matter', 'ii'));
    }

    public function create(Patient $patient, Matter $matter)
    {
        $age = Carbon::parse($patient->dob)->age;
        $role = Role::where('name', 'master')->first();
        $users = $role->users()->pluck('name','id')->all();
        $branches = Branches::pluck('name','id')->all();
        $days = $this->days;

        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();

        return view('treat.create', compact('patient', 'matter', 'age', 'users', 'ii', 'branches', 'days'));
    }

    public function store(Patient $patient, Matter $matter)
    {

        //dd($request->all());
        $data = request()->validate([
          'treat.treat_date' => 'required',
          'treat.treatment' => 'required',
          'treat.user_id' => 'required',
          'treat.branch_id' => 'required',
          'treat.remarks' => '',
          'treat.fee' => 'required',
          'treat.total' => 'required',
          'treat.days' => '',
          //'product.*' => '',
          'filenamebefore' => '',
          'filenamebefore.*' => 'image',
          'filenamebefore.*.state' => '',
          'filenameafter' => '',
          'filenameafter.*' => 'image',
          'filenameafter.*.state' => '',
        ]);

        //$data['treat']['product_amount'] = $data['treat']['total'] - $data['treat']['fee'];
        //dd($data['treat']);

        $data['treat']['patient_id'] = $patient->id;
        $data['treat']['product_amount'] = 0;

        //dd($data['treat']['treat_date']);

        $treat = $matter->treats()->firstOrCreate($data['treat']);

        $payment = [
          'patient_id' => $patient->id,
          'matter_id' => $matter->id,
          'treatment_fee' =>   $data['treat']['fee'],
          'total' =>   $data['treat']['fee'],
          'branch_id' => $data['treat']['branch_id']
        ];

        $treat->payment()->firstOrCreate($payment);
        //$treat->products()->createMany($data['product']);
        //$matter->injuries()->createMany($data['injuries']); ≈

        if(isset($data['filenamebefore']))
        {
          foreach ($data['filenamebefore'] as $key => $image) {

            $name = $image->getClientOriginalName();
            $extensss = $image->getClientOriginalExtension();
            $newName = $matter->id.'_'.$key.'_'.Carbon::now()->timestamp.'.'.$extensss;
            //$image->move(public_path().'/image/', $newName);
            $image = Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $local = public_path().'/image/';
            $savefile = $local.$newName;

            if (!file_exists($local)) {
                mkdir($local, 666, true);
            }

            $image->save($savefile,80);

            Storage::put('public/'.$newName, $image);

            File::delete($savefile);
            //$newName = Storage::disk('public')->put('/', $image);
            $mfile[] = ['filename' => $newName, 'state'=>'before'];
          }

          $treat->images()->createMany($mfile);
        }

        if(isset($data['filenameafter']))
        {
          foreach ($data['filenameafter'] as $key => $image) {

            $name = $image->getClientOriginalName();
            $extensss = $image->getClientOriginalExtension();
            $newName = $matter->id.'_'.$key.'_'.Carbon::now()->timestamp.'.'.$extensss;
            //$image->move(public_path().'/image/', $newName);
            $image = Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $local = public_path().'/image/';
            $savefile = $local.$newName;

            if (!file_exists($local)) {
                mkdir($local, 666, true);
            }

            $image->save($savefile,80);

            Storage::put('public/'.$newName, $image);

            File::delete($savefile);
            //$newName = Storage::disk('public')->put('/', $image);
            $amfile[] = ['filename' => $newName, 'state'=>'after'];
          }

          $treat->images()->createMany($amfile);
        }

        $checkin = $patient->checkins->where('state', 'treating')->first();
        if($checkin) {
          $checkin->matter_id = $matter->id;
          $checkin->state = 'treated';
          $checkin->treat_id = $treat->id;
          $checkin->save();
        } else {
          $newC['branch_id'] = $data['treat']['branch_id'];
          $newC['patient_id'] = $patient->id;
          $newC['matter_id'] = $matter->id;
          $newC['state'] = 'treated';
          $newC['treat_id'] = $treat->id;
          $patient->checkins()->firstOrCreate($newC);
        }

        switch(request('submit')) {
          case 'save':
            return redirect()->route('checkin.index');
          break;

          case 'new-treat':
            return redirect()->route('treat.create', ['patient' => $patient, 'matter' => $matter]);
          break;
        }

    }

    public function edit(Patient $patient, Matter $matter, Treat $treat)
    {
        $age = Carbon::parse($patient->dob)->age;
        $role = Role::where('name', 'master')->first();
        $users = $role->users()->pluck('name','id')->all();
        $branches = Branches::pluck('name','id')->all();
        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();
        $days = $this->days;

        //$treat->load('products');

        return view('treat.edit', compact('patient', 'matter', 'treat', 'age', 'users', 'ii', 'branches', 'days'));
    }

    public function update(Patient $patient, Matter $matter, Treat $treat)
    {
        $data = request()->validate([
          'treat.treat_date' => 'required',
          'treat.treatment' => 'required',
          'treat.branch_id' => 'required',
          'treat.remarks' => '',
          'treat.fee' => 'required',
          'treat.total' => 'required',
          'treat.days' => '',
          //'product.*' => '',
          'filenamebefore' => '',
          'filenamebefore.*' => 'image',
          'filenamebefore.*.state' => '',
          'filenameafter' => '',
          'filenameafter.*' => 'image',
          'filenameafter.*.state' => '',
        ]);

        //TreatProduct::where('treat_id', $treat->id)->delete();

        $treat->update($data['treat']);

        $payment = Payment::where('treat_id', $treat->id)->first();
        $payment->treatment_fee = $data['treat']['fee'];
        $payment->save();
        //$treat->products()->createMany($data['product']);

        if(isset($data['filenamebefore']))
        {
          foreach ($data['filenamebefore'] as $key => $image) {

            $name = $image->getClientOriginalName();
            $extensss = $image->getClientOriginalExtension();
            $newName = $matter->id.'_'.$key.'_'.Carbon::now()->timestamp.'.'.$extensss;
            //$image->move(public_path().'/image/', $newName);
            $image = Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $local = public_path().'/image/';
            $savefile = $local.$newName;

            if (!file_exists($local)) {
                mkdir($local, 666, true);
            }

            $image->save($savefile,80);

            Storage::put('public/'.$newName, $image);

            File::delete($savefile);
            //$newName = Storage::disk('public')->put('/', $image);
            $mfile[] = ['filename' => $newName, 'state'=>'before'];
          }

          $treat->images()->createMany($mfile);
        }

        if(isset($data['filenameafter']))
        {
          foreach ($data['filenameafter'] as $key => $image) {

            $name = $image->getClientOriginalName();
            $extensss = $image->getClientOriginalExtension();
            $newName = $matter->id.'_'.$key.'_'.Carbon::now()->timestamp.'.'.$extensss;
            //$image->move(public_path().'/image/', $newName);
            $image = Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $local = public_path().'/image/';
            $savefile = $local.$newName;

            if (!file_exists($local)) {
                mkdir($local, 666, true);
            }

            $image->save($savefile,80);

            Storage::put('public/'.$newName, $image);

            File::delete($savefile);
            //$newName = Storage::disk('public')->put('/', $image);
            $amfile[] = ['filename' => $newName, 'state'=>'after'];
          }

          $treat->images()->createMany($amfile);
        }


        switch(request('submit')) {
          case 'save':
            return redirect()->route('checkin.index');
          break;

          case 'new-appointment':
            return redirect()->route('appointments.create', ['patient' => $patient, 'matter' => $matter]);
          break;
        }



        //return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
    }

}
