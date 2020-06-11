<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Patient;
use App\Matter;
use App\injury;
use App\MatterInjury;
use App\Image;

class MatterController extends Controller
{

  public function index(Patient $patient)
  {
      //$patient = Patient::with('matters')->get();
      //$patient->load('matters');

      $patient->load(['matters' => function ($query) {
          $query->orderBy('created_at', 'desc');
      }, 'treats']);

      //$age = Carbon::parse($patient->dob)->age;
      //dd($patient);
      //$matters = Patient::paginate(10);
      return view('matter.index', compact('patient'));
  }

  public function create(Patient $patient)
  {
      $injuries = injury::get();

      return view('matter.create', compact('patient', 'injuries'));
  }

  public function store(Patient $patient, Request $request)
  {
      //dd($request->all());
      $data = request()->validate([
        'matter.injury_part' => 'required',
        'matter.injury_since' => '',
        'matter.remarks' => '',
        'injuries' => 'required',
        'injuries.*.injury_id' => 'required',
        'matter.comments' => '',
        'filename' => '',
        'filename.*' => 'image',
      ]);
      //dd($data['injuries']);
      //dd();

      if($data['matter']['injury_since']!='') {
        $dateTime = Carbon::parse($data['matter']['injury_since']);

        $data['matter']['injury_since'] = $dateTime->format('Y-m-d');
      }
      //dd($data['filename']);



      //dd($mfile);

      //dd($data);
      $matter = $patient->matters()->create($data['matter']);
      $matter->injuries()->createMany($data['injuries']);

      if($data['filename'])
      {
        foreach ($data['filename'] as $key => $image) {
          $name = $image->getClientOriginalName();
          $extensss = $image->getClientOriginalExtension();
          $newName = $matter->id.'_'.$key.'_'.Carbon::now()->timestamp.'.'.$extensss;

          //$image->move(public_path().'/image/', $newName);

          $newName = Storage::putFileAs(
              'matters', $image, $newName
          );

          $mfile[] = ['filename' => $newName];
        }

        $matter->images()->createMany($mfile);
      }

      switch(request('submit')) {
        case 'save':
          return redirect()->route('matter.index', ['patient' => $patient]);
        break;

        case 'new-treat':
          return redirect()->route('treat.create', ['patient' => $patient, 'matter' => $matter]);
        break;
      }

  }

  public function edit(Patient $patient, Matter $matter)
  {
      $injuries = injury::get();

      $dateTime = Carbon::parse($matter->injury_since);
      $matter->injury_since = $dateTime->format('m/d/Y');

      $matter_injuries = $matter->load('injuries');

      return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
  }

  public function update(Patient $patient, Matter $matter)
  {
      $data = request()->validate([
        'matter.injury_part' => 'required',
        'matter.injury_since' => '',
        'matter.remarks' => '',
        'injuries' => 'required',
        'injuries.*.injury_id' => 'required',
        'matter.comments' => '',
        'filename' => '',
        'filename.*' => 'image',
      ]);

      //dd($data['matter']['injury_since']);

      if($data['matter']['injury_since']!='') {
        $dateTime = Carbon::parse($data['matter']['injury_since']);

        $data['matter']['injury_since'] = $dateTime->format('Y-m-d');
      }

      //dd($data['matter']);

      //$matter->injuries->delete();
      MatterInjury::where('matter_id', $matter->id)->delete();

      $matter->update($data['matter']);
      $matter->injuries()->createMany($data['injuries']);

      if($data['filename'])
      {
        foreach ($data['filename'] as $key => $image) {
          $name = $image->getClientOriginalName();
          $extensss = $image->getClientOriginalExtension();
          $newName = $matter->id.'_'.$key.'_'.Carbon::now()->timestamp.'.'.$extensss;
          //$image->move(public_path().'/image/', $newName);
          //$newName = Storage::putFileAs(
              //'public', $image, $newName
          //);

          $newName = Storage::disk('public')->put('/', $image);
          $mfile[] = ['filename' => $newName];
        }

        $matter->images()->createMany($mfile);
      }

      //$matter->injuries()->sync([1,2,3]);

      switch(request('submit')) {
        case 'save':
          return redirect()->route('matter.index', ['patient' => $patient]);
        break;

        case 'new-treat':
          return redirect()->route('treat.create', ['patient' => $patient, 'matter' => $matter]);
        break;
      }

  }

}
