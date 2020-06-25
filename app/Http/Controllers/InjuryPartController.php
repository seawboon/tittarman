<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\InjuryPart;


class InjuryPartController extends Controller
{
  public function index()
  {
      $injuryparts = InjuryPart::paginate(10);
      return view('injuryparts.index', compact('injuryparts'));
  }

  public function create()
  {
      return view('injuryparts.create');
  }

  public function store()
  {
      $data = request()->validate([
        'name' => 'required',
        'status' => 'required',
      ]);

      $injurypart = InjuryPart::create($data);
      switch(request('submit')) {
        case 'save':
          return redirect()->route('injuryparts.index');
        break;

        case 'new':
          return redirect()->route('injuryparts.create');
        break;
      }

  }

  public function edit(InjuryPart $injurypart)
  {
      return view('injuryparts.edit', compact('injurypart'));
  }

  public function update(InjuryPart $injurypart )
  {
      $data = request()->validate([
        'name' => 'required',
        'status' => 'required',
      ]);

      $injurypart->update($data);

      switch(request('submit')) {
        case 'save':
          return redirect()->route('injuryparts.index');
        break;

        case 'new':
          return redirect()->route('injuryparts.create');
        break;
      }

  }
}
