<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\AppointmentSource;

class SourceController extends Controller
{
    public function index()
    {
        $sources = AppointmentSource::paginate(10);
        return view('source.index', compact('sources'));
    }

    public function create()
    {
        return view('source.create');
    }

    public function store()
    {
        $data = request()->validate([
          'name' => 'required',
          'status' => 'required',
        ]);

        $source = AppointmentSource::create($data);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('sources.index');
          break;

          case 'new':
            return redirect()->route('sources.create');
          break;
        }

    }

    public function edit(AppointmentSource $source)
    {
        return view('source.edit', compact('source'));
    }

    public function update(AppointmentSource $source)
    {
        $data = request()->validate([
          'name' => 'required',
          'status' => 'required',
        ]);

        $source->update($data);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('sources.index');
          break;

          case 'new':
            return redirect()->route('sources.create');
          break;
        }

    }

}
