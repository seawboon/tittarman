<?php

namespace App\Http\Controllers\ImportExcel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ImportVouchers;
use App\Imports\PatientsImport;
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

    public function create()
    {
      return view('import_excel.patient');
    }

    public function importPatient(Request $request)
    {
      $request->validate([
        'import_file' => 'required'
      ]);
      Excel::import(new PatientsImport, request()->file('import_file'));
      return back()->with('success', 'Patients imported successfully.');

    }

}
