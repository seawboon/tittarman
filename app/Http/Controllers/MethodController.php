<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PaymentMethod;

class MethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::paginate(10);
        return view('method.index', compact('methods'));
    }

    public function create()
    {
        return view('method.create');
    }

    public function store()
    {
        $data = request()->validate([
          'name' => 'required',
          'status' => 'required',
        ]);

        $method = PaymentMethod::create($data);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('methods.index');
          break;

          case 'new':
            return redirect()->route('methods.create');
          break;
        }

    }

    public function edit(PaymentMethod $method)
    {
        return view('method.edit', compact('method'));
    }

    public function update(PaymentMethod $method)
    {
        $data = request()->validate([
          'name' => 'required',
          'status' => 'required',
        ]);

        $method->update($data);

        switch(request('submit')) {
          case 'save':
            return redirect()->route('methods.index');
          break;

          case 'new':
            return redirect()->route('methods.create');
          break;
        }

    }

}
