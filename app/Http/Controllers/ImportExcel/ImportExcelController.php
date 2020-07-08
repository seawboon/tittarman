<?php

namespace App\Http\Controllers\ImportExcel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ImportVouchers;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function index()
    {
      return view('import_excel.index');
    }

    public function import(Request $request)
    {
      $request->validate([
        'import_file' => 'required'
      ]);
      Excel::import(new ImportVouchers, request()->file('import_file'));
      return back()->with('success', 'Vouchers imported successfully.');

    }
}
