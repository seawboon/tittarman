<?php

namespace App\Imports;

use App\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

//class PatientsExport implements FromCollection
class PatientsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Patient::all();
    }

    /*public function query()
    {
        return Patient::all();
    }*/

    public function headings(): array
    {
        return array_keys($this->collection()->first()->toArray());
    }
}
