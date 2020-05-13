<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Matter;
use App\injury;
use App\MatterInjury;

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
      ]);
      //dd($data['injuries']);

      if($data['matter']['injury_since']!='') {
        $dateTime = Carbon::parse(request($data['matter']['injury_since']));

        $data['matter']['injury_since'] = $dateTime->format('Y-m-d');
      }
      //dd($data);
      $matter = $patient->matters()->create($data['matter']);
      $matter->injuries()->createMany($data['injuries']);

      return redirect()->route('matter.index', ['patient' => $patient]);

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
      //$matter->injuries()->sync([1,2,3]);

      return redirect()->route('matter.edit', ['patient' => $patient, 'matter' => $matter]);

      //return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
  }

}
