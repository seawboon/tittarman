<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\VoucherType;

class VoucherTypeController extends Controller
{
  public function index()
  {
      $VocherTypes = VoucherType::paginate(10);
      return view('VoucherType.index', compact('VocherTypes'));
  }

  public function create()
  {
      return view('VoucherType.create');
  }

  public function store()
  {
      $data = request()->validate([
        'name' => 'required',
        'short' => 'required',
        'prefix' => '',
        'status' => 'required',
      ]);

      $VoucherType = VoucherType::create($data);
      switch(request('submit')) {
        case 'save':
          return redirect()->route('vouchertypes.index');
        break;

        case 'new':
          return redirect()->route('vouchertypes.create');
        break;
      }

  }

  public function edit(VoucherType $vouchertype)
  {
      return view('VoucherType.edit', compact('vouchertype'));
  }

  public function update(VoucherType $vouchertype)
  {
      $data = request()->validate([
        'name' => 'required',
        'short' => 'required',
        'prefix' => '',
        'status' => 'required',
      ]);

      $vouchertype->update($data);

      switch(request('submit')) {
        case 'save':
          return redirect()->route('vouchertypes.index');
        break;

        case 'new':
          return redirect()->route('vouchertypes.create');
        break;
      }

  }
}
