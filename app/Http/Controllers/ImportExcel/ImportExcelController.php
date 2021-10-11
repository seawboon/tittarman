<?php

namespace App\Http\Controllers\ImportExcel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ImportVouchers;
use App\Imports\PatientsImport;
use App\Imports\PatientsExport;
use App\Imports\PatientPackageImport;
use App\Imports\PatientPackageImportCollection;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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

    public function exportPatient(Request $request)
    {
      $xlsname = 'patients_'.Carbon::now()->format('Ymd');
      return Excel::download(new PatientsExport, $xlsname.'.xlsx');
    }

    public function createPatientPackage()
    {
      return view('import_excel.patient-package');
    }

    public function storePatientPackage(Request $request)
    {
      $request->validate([
        'import_file' => 'required'
      ]);
      Excel::import(new PatientPackageImportCollection, request()->file('import_file'));
      return back()->with('success', 'Patients Package imported successfully.');
    }

}
