<?php

namespace App\Imports;

use App\Patient;
use Maatwebsite\Excel\Concerns\ToModel;

class PatientsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $sal = $row[0];
        if($row[0] == 'Ms') {
          $sal = 'Miss';
        }

        $fullname = $row[1];
        if($fullname == '')
        {
          $fullname = 'xxx';
        }

        $gender = $row[7];
        if($gender == '')
        {
          $gender = 'xxx';
        }

        if($gender == 'Male')
        {
          $gender = 'male';
        }

        if($gender == 'Female')
        {
          $gender = 'female';
        }

        $dob = $row[3];
        if($dob == '0000-00-00')
        {
          $dob = '1912-12-12';
        }

        $nric = $row[2];
        $nric = str_replace('-', '', $nric);

        $provider = '';
        $contactnumber = '';
        $contact =$row[5];
        if($contact != '') {
          $contact = explode('-',$contact);
          $provider = $contact[0];
          $contactnumber = $contact[1];
        }

        return new Patient([
            'salutation' => $sal,
            'fullname' => $fullname,
            'nric' => $nric,
            'dob' => $dob,
            'email' => @$row[4],
            'provider' => $provider,
            'contact' => $contactnumber,
            'occupation' => @$row[6],
            'gender' => $gender,
            'address' => @$row[8],
            'branch_id' => 2,
            'sensitive_skin' => 'no'
        ]);
    }
}
