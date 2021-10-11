<?php

namespace App\Imports;

use App\Voucher;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportVouchers implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Voucher([
            'code' => @$row[0]
        ]);
    }
}
