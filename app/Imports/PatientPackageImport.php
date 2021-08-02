<?php

namespace App\Imports;

use App\Patient;
use App\PatientPackage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PatientPackageImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    /*public function startRow(): int
    {
        return 2;
    }*/

    public function model(array $row)
    {
        $package=[];
        $package['patient'] = intval($row['patient_id']);
        $package['package'] = intval($row['package_id']);
        $package['variant'] = intval($row['variant_id']);
        $package['date'] = Carbon::parse($row['bought_at'])->format('Y-m-d');
        $package['payment'] = intval($row['payment_id']);

        if($package['patient']!=0) {
          return new PatientPackage([
              'patient_id' => $package['patient'],
              'payment_id' => $package['payment'],
              'package_id' => $package['package'],
              'variant_id' => $package['variant'],
              'created_at' => $package['date']
          ]);
        }
    }
}
