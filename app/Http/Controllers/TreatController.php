<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Matter;
use App\injury;
use App\MatterInjury;
use App\Treat;
use App\User;

class TreatController extends Controller
{

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

        $users = User::pluck('name','id')->all();

        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();

        return view('treat.create', compact('patient', 'matter', 'age', 'users', 'ii'));
    }

    public function store(Patient $patient, Matter $matter)
    {
        //dd($request->all());
        $data = request()->validate([
          'treat.treat_date' => 'required',
          'treat.treatment' => 'required',
          'treat.user_id' => 'required',
          'treat.remarks' => '',
        ]);
        //dd($data['treat']);

        $data['treat']['patient_id'] = $patient->id;

        //dd($data['treat']['treat_date']);
        //dd($data);
        $treat = $matter->treats()->create($data['treat']);
        //$matter->injuries()->createMany($data['injuries']);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('treat.index', ['patient' => $patient, 'matter' => $matter]);
          break;

          case 'new-treat':
            return redirect()->route('treat.create', ['patient' => $patient, 'matter' => $matter]);
          break;
        }

    }

    public function edit(Patient $patient, Matter $matter, Treat $treat)
    {
        $age = Carbon::parse($patient->dob)->age;
        $users = User::pluck('name','id')->all();
        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();
        return view('treat.edit', compact('patient', 'matter', 'treat', 'age', 'users', 'ii'));
    }

    public function update(Patient $patient, Matter $matter, Treat $treat)
    {
        $data = request()->validate([
          'treat.treat_date' => 'required',
          'treat.treatment' => 'required',
          'treat.remarks' => '',
        ]);

        $treat->update($data['treat']);

        return redirect()->route('treat.index', ['patient' => $patient, 'matter' => $matter, 'treat' => $treat]);

        //return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
    }

}
