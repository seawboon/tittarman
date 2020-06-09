<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Branches;
use App\Country;
use App\State;
use App\Macros\whereLike;

class PatientController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }


  public function index()
  {
      //$patients = Patient::get();
      $patients = Patient::paginate(10);
      return view('patient.index', compact('patients'));
  }

  public function search(Request $request)
  {
      //$data = request();
      $searchTerm = $request->search;
      if(empty($searchTerm)) {
        $searchTerm = '';
      }
      //$patients = Patient::whereLike(['fullname', 'email', 'nric'], $searchTerm)->get();
      $patients = Patient::whereLike(['fullname', 'email', 'nric'], $searchTerm)->paginate(10);
      return view('patient.index', compact('patients', 'searchTerm'));
  }

  public function create()
  {
      $branches = Branches::pluck('name','id')->all();
      $countries = Country::pluck('name', 'name')->all();
      $states = State::where('country_id', 111)->pluck('name', 'name')->all();
      return view('patient.create', compact('branches', 'countries', 'states'));
  }

  public function edit($pid)
  {
    //dd($patient);
      $patient = Patient::findOrFail($pid);
      $branches = Branches::pluck('name','id')->all();
      $countries = Country::pluck('name', 'name')->all();
      $states = State::where('country_id', 111)->pluck('name', 'name')->all();

      $dateTime = Carbon::parse($patient->dob);
      $patient->dob = $dateTime->format('d M Y');

      return view('patient.edit', compact('patient', 'branches', 'countries', 'states'));
  }

  public function update(Request $request, $pid)
  {
    //dd($patient);
      $request->validate([
        'branch_id' => 'required',
        'fullname' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'nric' => 'required',
        'sensitive_skin' => 'required',
      ]);

      $patient = Patient::find($pid);


      $dateTime = Carbon::parse(request('dob'));
      $request['dob'] = $dateTime->format('Y-m-d');
      //dd($request);
      $patient->update($request->except('submit'));

      switch($request->submit) {
        case 'save':
          return redirect()->route('patient.edit', ['pid' => $patient]);
        break;

        case 'new-case':
          return redirect()->route('matter.create', ['patient' => $patient]);
        break;
      }
      //return redirect()->route('patient.edit', ['pid' => $pid]);
  }

  public function store()
  {
      $data = request()->validate([
        'branch_id' => 'required',
        'salutation' => '',
        'fullname' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'nric' => 'required',
        'email' => '',
        'provider' => '',
        'contact' => '',
        'occupation' => '',
        'address' => '',
        'address2' => '',
        'postcode' => '',
        'state' => '',
        'country' => '',
        'sensitive_skin' => 'required',
      ]);

      $dateTime = Carbon::parse(request('dob'));

      $data['dob'] = $dateTime->format('Y-m-d');

      //$data['user_id'] = auth()->user()->id;
      $user = Patient::where('email', $data['email'])
      ->orWhere('fullname', $data['fullname'])
      ->orWhere('nric', $data['nric'])->first();

      if($user == null){
        $patient = Patient::create($data);
        switch(request('submit')) {
          case 'save':
            return redirect()->route('matter.index', ['patient' => $patient]);
          break;

          case 'new-case':
            return redirect()->route('matter.create', ['patient' => $patient]);
          break;
        }

      } else {
        return redirect()->route('matter.index', ['patient' => $user]);
      }
      //$questionnaire = auth()->user()->questionnaires()->create($data);




  }

}
