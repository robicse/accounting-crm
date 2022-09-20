<?php

namespace App\Imports;

use App\Party;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Party|null
     */
    public function model(array $row)
    {
        //dd($row);
        return new Party([
            'type'     => $row[0],
            'name'     => $row[1],
            'phone'    => $row[2],
            'email'    => $row[3],
            'address'  => $row[4],
        ]);
    }
}
