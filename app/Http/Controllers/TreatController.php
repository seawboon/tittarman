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
use App\Product;
use App\TreatProduct;
use App\Images;
use Image;
use File;

class TreatController extends Controller
{
    private $days = [
      '2' => '2 Days',
      '3' => '3 Days',
      '7' => '1 Week',
      '14' => '2 Weeks',
      '21' => '3 Weeks',
      '28' => '4 Weeks',
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
        $products = Product::where('status', 'yes')->get();
        $users = User::pluck('name','id')->all();
        $branches = Branches::pluck('name','id')->all();
        $days = $this->days;

        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();

        return view('treat.create', compact('patient', 'matter', 'age', 'users', 'ii', 'branches', 'products', 'days'));
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
          'product.*' => '',
          'filename' => '',
          'filename.*' => 'image',
        ]);

        $data['treat']['product_amount'] = $data['treat']['total'] - $data['treat']['fee'];
        //dd($data['treat']);

        $data['treat']['patient_id'] = $patient->id;

        //dd($data['treat']['treat_date']);

        $treat = $matter->treats()->create($data['treat']);

        $treat->products()->createMany($data['product']);
        //$matter->injuries()->createMany($data['injuries']); ≈

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

          $treat->images()->createMany($mfile);
        }


        switch(request('submit')) {
          case 'save':
            return redirect()->route('matter.edit', ['patient' => $patient, 'matter' => $matter]);
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
        $branches = Branches::pluck('name','id')->all();
        $products = Product::where('status', 'yes')->get();
        $ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();
        $days = $this->days;

        $treat->load('products');

        return view('treat.edit', compact('patient', 'matter', 'treat', 'age', 'users', 'ii', 'branches', 'products', 'days'));
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
          'product.*' => '',
          'filename' => '',
          'filename.*' => 'image',
        ]);

        TreatProduct::where('treat_id', $treat->id)->delete();

        $treat->update($data['treat']);
        $treat->products()->createMany($data['product']);

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

          $treat->images()->createMany($mfile);
        }


        switch(request('submit')) {
          case 'save':
            return redirect()->route('matter.edit', ['patient' => $patient, 'matter' => $matter]);
          break;

          case 'new-appointment':
            return redirect()->route('appointments.create', ['patient' => $patient, 'matter' => $matter]);
          break;
        }



        //return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
    }

}
