<?php

namespace App\Imports;

use App\Models\Test;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use stdClass;

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
            $p = new stdClass;
            $p1 = new stdClass;
            $p2 = new stdClass;
            $p3 = new stdClass;
            $p4 = new stdClass;

            $p->start = $row['start_date_time'];

            array_push($alltests, $p);
            dd($row);
        }

        dd($alltests);
    }
}
