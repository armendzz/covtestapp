<?php

namespace App\Imports;

use App\Models\Test;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TestsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     // foreach($row as $r){
    //     //     dd($r);
    //     // }


    //     // dd($row);

    //     // return new Test([
    //     //     //
    //     // ]);
    // }


    public function collection(Collection $rows)
    {
        $alltests = [];


        foreach ($rows as $row)
        {

           dd($row);
        }
    }
}
