<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Patient;
use App\Matter;
use App\injury;
use App\MatterInjury;
use App\Images;
use App\InjuryPart;
use App\MatterInjuryPart;
use Image;
use File;

class MatterController extends Controller
{

  public function index(Patient $patient)
  {
      //$patient = Patient::with('matters')->get();
      //$patient->load('matters');

      /*$patient->load(['matters' => function ($query) {
          $query->orderBy('created_at', 'desc');
      }, 'treats']);*/
      $patient->load('matters.parts.part', 'treats.payment');

      //$age = Carbon::parse($patient->dob)->age;
      //dd($patient);
      //$matters = Patient::paginate(10);
      return view('matter.index', compact('patient'));
  }

  public function create(Patient $patient, Request $request)
  {
      $injuries = injury::get();
      $injuryparts = InjuryPart::where('status','yes')->get();
      //return view('matter.create', compact('patient', 'injuries', 'injuryparts', 'olds'));
      return view('matter.create', compact('patient', 'injuries', 'injuryparts'));
  }

  public function store(Patient $patient, Request $request)
  {
      //dd($request->all());
      $data = request()->validate([
        'injury_parts' => 'required',
        'injury_parts.*.injury_part_id' => 'required',
        'matter.injury_since' => '',
        'matter.notes' => '',
        'matter.remarks' => '',
        'matter.other' => '',
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
      $matter = $patient->matters()->firstOrCreate($data['matter']);
      $matter->injuries()->createMany($data['injuries']);
      $matter->parts()->createMany($data['injury_parts']);

      if(isset($data['filename']))
      {
        foreach ($data['filename'] as $key => $image) {

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
      $injuryparts = InjuryPart::where('status','yes')->get();
      $dateTime = Carbon::parse($matter->injury_since);
      $matter->injury_since = $dateTime->format('d M Y');
      $matter->load('treats.masters.master');
      $matter_injuries = $matter->load('injuries');
      $parts = $matter->load('parts');

      return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries', 'injuryparts', 'parts'));
  }

  public function update(Patient $patient, Matter $matter)
  {
      $data = request()->validate([
        'injury_parts' => 'required',
        'injury_parts.*.injury_part_id' => 'required',
        'matter.injury_since' => '',
        'matter.notes' => '',
        'matter.remarks' => '',
        'matter.other' => '',
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
      MatterInjuryPart::where('matter_id', $matter->id)->delete();

      $matter->update($data['matter']);
      $matter->injuries()->createMany($data['injuries']);
      $matter->parts()->createMany($data['injury_parts']);

      if(isset($data['filename']))
      {
        foreach ($data['filename'] as $key => $image) {

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
