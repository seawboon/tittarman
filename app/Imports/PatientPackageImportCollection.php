<?php

namespace App\Imports;

use App\Patient;
use App\PatientPackage;
use App\PatientVoucher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PatientPackageImportCollection implements ToCollection, WithHeadingRow
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

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {

            if ($row->filter()->isNotEmpty()) {
              $package['patient'] = intval($row['patient_id']);
              $package['package'] = intval($row['package_id']);
              $package['variant'] = intval($row['variant_id']);
              $package['date'] = Carbon::parse($row['bought_at'])->format('Y-m-d');
              $package['payment'] = intval($row['payment_id']);

              $imPackage = PatientPackage::create([
                'patient_id' => $package['patient'],
                'payment_id' => $package['payment'],
                'package_id' => $package['package'],
                'variant_id' => $package['variant'],
                'created_at' => $package['date']
              ]);

              $imPackage->patientVouchers()->create([
                'patient_package_id' => $imPackage->id,
                'patient_id' => $package['patient'],
                'voucher_type_id' => 1,
                'code' => 'FBA-Test-'.$imPackage->id,
                'expired_date' => Carbon::parse($row['bought_at'])->addMonths(3)->format('Y-m-d'),
                'state' => 'enable',
              ]);


            } //end filter
        }//end foreach
    }

}
