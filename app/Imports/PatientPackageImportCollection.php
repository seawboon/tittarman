<?php

namespace App\Imports;

use App\Patient;
use App\Package;
use App\PackageVariant;
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

              $findVariant = PackageVariant::where('sku',$row['variant_sku'])->first();

              $package['patient'] = intval($row['patient_id']);
              $package['package'] = $findVariant->package_id;
              $package['variant'] = $findVariant->id;
              $package['date'] = Carbon::parse($row['bought_at'])->format('Y-m-d');
              $package['payment'] = intval($row['payment_id']);

              $imPackage = PatientPackage::create([
                'patient_id' => $package['patient'],
                'payment_id' => $package['payment'],
                'package_id' => $package['package'],
                'variant_id' => $package['variant'],
                'created_at' => $package['date']
              ]);

              $rawVouchers = array(
                'fba' => $row['fba'],
                'gs' => $row['gs'],
                'md' => $row['md'],
                'cmco' => $row['cmco']
              );

              foreach ($rawVouchers as $key => $rawVoucher) {
                if(!empty($rawVoucher)) {
                  switch ($key) {
                      case 'fba':
                          $type = 1;
                          break;
                      case 'gs':
                          $type = 2;
                          break;
                      case 'md':
                          $type = 3;
                          break;
                      case 'cmco':
                          $type = 4;
                          break;
                  }

                  $this->storeCode($type, $rawVoucher, $imPackage, $findVariant, $package, $row);

                }

              }

              /*if(!empty($row['fba'])) {
                $type = 1;
                $this->storeCode($type, $row['fba'], $imPackage, $findVariant, $package, $row);
              }

              if(!empty($row['gs'])) {
                $type = 2;
                $this->storeCode($type, $row['gs'], $imPackage, $findVariant, $package, $row);
              }

              if(!empty($row['md'])) {
                $type = 3;
                $this->storeCode($type, $row['gs'], $imPackage, $findVariant, $package, $row);
              }

              if(!empty($row['cmco'])) {
                $type = 4;
                $this->storeCode($type, $row['gs'], $imPackage, $findVariant, $package, $row);
              }*/


            } //end filter
        }//end foreach
    }

    public function storeCode($type, $rawCodes, $imPackage, $findVariant, $package, $row) {
        $raw = str_replace(' ', '', $rawCodes);
        $codes = explode(',', $raw);

        foreach ($codes as $code) {
          $imPackage->patientVouchers()->create([
            'patient_package_id' => $imPackage->id,
            'patient_id' => $package['patient'],
            'variant_id' => $imPackage->variant_id,
            'voucher_type_id' => $type,
            'code' => $code,
            'expired_date' => Carbon::parse($row['bought_at'])->addMonths($findVariant->expiry)->format('Y-m-d'),
            'state' => 'enable',
          ]);
        }

    }

}
