<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Branches;
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
      return view('patient.create', compact('branches'));
  }

  public function edit($pid)
  {
    //dd($patient);
      $patient = Patient::findOrFail($pid);
      $branches = Branches::pluck('name','id')->all();

      $dateTime = Carbon::parse($patient->dob);
      $patient->dob = $dateTime->format('m/d/Y');

      return view('patient.edit', compact('patient', 'branches'));
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
      $patient->update($request->all());

      return redirect()->route('patient.edit', ['pid' => $pid]);
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
        'contact' => '',
        'occupation' => '',
        'address' => '',
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
        return redirect()->route('matter.index', ['patient' => $patient]);
      } else {
        return redirect()->route('matter.index', ['patient' => $user]);
      }
      //$questionnaire = auth()->user()->questionnaires()->create($data);




  }

}
