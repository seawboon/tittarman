<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;
use App\Account;
use App\Branches;
use App\Country;
use App\State;
use App\Appointment;
use App\Macros\whereLike;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

use Session;

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

  public function treats(Patient $patient)
  {
      //$patients = Patient::get();
      //$patient = Patient::paginate(10);
      $patient->load('treats.branch');
      return view('patient.treats', compact('patient'));
  }

  public function search(Request $request)
  {

    //dd($patients);

    //$data = request();
      //$searchTerm = $request->search;
      //if(empty($searchTerm)) {
      //  $searchTerm = '';
      //}
      //$patients = Patient::with('accounts')->whereLike(['fullname', 'email', 'nric', 'id', 'contact', 'account'], $searchTerm)->paginate(10);
      //dd($request->all());
      $searchTerm = '';
      $searchAtt = 'id';
      if($request->filled('searchID') ) {
        $searchTerm = $request->searchID;
        $searchAtt = 'id';
      }

      if($request->filled('searchAccount') ) {
        $searchTerm = $request->searchAccount;
        $searchAtt = 'account';
        $account = Account::whereLike(['account_no'], $searchTerm)->get();
      }

      if($request->filled('searchName') ) {
        $searchTerm = $request->searchName;
        $searchAtt = 'fullname';
      }

      if($request->filled('searchNRIC') && $request->searchNRIC != null) {
        $searchTerm = $request->searchNRIC;
        $searchAtt = 'nric';
      }

      if($request->filled('searchEmail') && $request->searchEmail != null) {
        $searchTerm = $request->searchEmail;
        $searchAtt = 'email';
      }

      if($request->filled('searchContact') && $request->searchContact != null) {
        $searchTerm = $request->searchContact;
        $searchAtt = 'contact';
      }


      if($request->filled('searchAccount') ) {
        $pVar = [];
        foreach ($account as  $pp) {
          $pVar[] = $pp->patient_id;
        }
        $patients = Patient::with('accounts')->whereIn('id', $pVar)->paginate(10);
      } else {
        $patients = Patient::with('accounts')->whereLike([$searchAtt], $searchTerm)->paginate(10);
      }

      //


      //dd($patients);
      $searchTerms = $request->all();
      $searchTerms = Arr::except($searchTerms, ['_token','submit']);

      return view('patient.index', compact('patients', 'searchTerms'));
  }

  public function create(Request $request)
  {
      if(Session::get('myBranch')) {
        $appo['branch_id'] = session('myBranch')->id;
      } else {
        $appo['branch_id'] = null;
      }
      $appo['salutation'] = '';

      $appo['name'] = '';
      $appo['email'] = '';
      $appo['provider'] = '';
      $appo['contact'] = '';
      //dd($appo);
      if($request->input('appo')) {
        $appo = Appointment::find($request->input('appo'));
        $appo->state = 'checkin';
        $appo->save();
        $appo->toArray();
      }
      //dd($appo);
      $branches = array(
        'long' => Branches::pluck('name','id')->all(),
        'short' => Branches::pluck('short','id')->all()
      );

      $countries = Country::pluck('name', 'name')->all();
      $states = State::where('country_id', 111)->pluck('name', 'name')->all();
      return view('patient.create', compact('branches', 'countries', 'states', 'appo'));
  }

  public function edit($pid)
  {
      $patient = Patient::findOrFail($pid);
      $branches = array(
        'long' => Branches::pluck('name','id')->all(),
        'short' => Branches::pluck('short','id')->all()
      );
      $countries = Country::pluck('name', 'name')->all();
      $states = State::where('country_id', 111)->pluck('name', 'name')->all();

      $dateTime = Carbon::parse($patient->dob);
      //$patient->dob = $dateTime->format('d M Y');
      $patient->dob = $dateTime->format('d-m-Y');

      return view('patient.edit', compact('patient', 'branches', 'countries', 'states'));
  }

  public function update(Request $request, $pid)
  {
    //dd($patient);
      $request->validate([
        'branch_id' => 'required',
        'salutation' => 'required',
        'fullname' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'nric' => 'required',
        'email' => 'required|email',
        'provider' => 'required',
        'contact' => 'required',
        'occupation' => '',
        'address' => '',
        'address2' => '',
        'postcode' => '',
        'city' => '',
        'state' => '',
        'country' => '',
        'sensitive_skin' => 'required',
        'freegift' => '',
        'accounts' => '',
        'accounts.*.account_no' => '',
        'accounts.*.branch_id' => '',
      ]);

      if($request['freegift'] == null) {
        $request['freegift'] = 'no';
      }

      $patient = Patient::find($pid);


      $dateTime = Carbon::parse(request('dob'));
      $request['dob'] = $dateTime->format('Y-m-d');
      $request['phone'] = request('provider').request('contact');
      //dd($request);
      $patient->update($request->except('submit','accounts'));

      Account::where('patient_id', $pid)->delete();

      $patient->accounts()->createMany($request['accounts']);

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

  public function store(Request $request)
  {
      $data = request()->validate([
        'branch_id' => 'required',
        'salutation' => 'required',
        'fullname' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'nric' => 'required',
        'email' => 'required|email',
        'provider' => 'required',
        'contact' => 'required',
        'occupation' => '',
        'address' => '',
        'address2' => '',
        'postcode' => '',
        'city' => 'nullable',
        'state' => '',
        'country' => '',
        'sensitive_skin' => 'required',
        'accounts' => '',
        'accounts.*.account_no' => '',
        'accounts.*.branch_id' => '',
      ]);

      $dateTime = Carbon::parse(request('dob'));

      $data['dob'] = $dateTime->format('Y-m-d');
      $data['phone'] = request('provider').request('contact');

      $data['password'] = Hash::make('tittarman.com.my');

      $data['uuid'] = Uuid::uuid4()->toString();

      $filtered = array_except($data, ['accounts']);
      //$data['user_id'] = auth()->user()->id;
      /*$user = Patient::where('email', $data['email'])
      ->orWhere('fullname', $data['fullname'])
      ->orWhere('nric', $data['nric'])->first();*/
      $user = Patient::where('nric', $data['nric'])->first();

      if($user == null){
        $patient = Patient::create($filtered);
        $patient->accounts()->createMany($data['accounts']);
        if(!is_array($request->appo)) {
          $newAPPo = Appointment::find($request->appo);
          $newAPPo->patient_id = $patient->id;
          $newAPPo->update();
        }
        switch(request('submit')) {
          case 'save':
            return redirect()->route('matter.index', ['patient' => $patient]);
          break;

          case 'new-case':
            return redirect()->route('matter.create', ['patient' => $patient]);
          break;

          case 'new-checkin':
            return redirect()->route('checkin.create', ['patient' => $patient]);
          break;
        }

      } else {
        return redirect()->route('matter.index', ['patient' => $user]);
      }
      //$questionnaire = auth()->user()->questionnaires()->create($data);




  }

}
