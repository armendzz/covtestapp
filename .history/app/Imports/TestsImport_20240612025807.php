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

            $p2 = new stdClass;
            $p3 = new stdClass;
            $p4 = new stdClass;
            $p5 = new stdClass;

            $p->start = $row['start_date_time'];
            $p->email = $row['customer_email'];
            $p->name = $row['name'];
            $p->nachname = $row['nachname'];
            $p->strasse = $row['strasse'];
            $p->hausnummer = $row['hausnummer'];
            $p->postleitzahl = $row['postleitzahl'];
            $p->stadt = $row['stadt'];
            $p->geburtsdatum_ttmmjjjj = $row['geburtsdatum_ttmmjjjj'];
            $p->personalausweisnummer_optional = $row['personalausweisnummer_optional'];
            array_push($alltests, $p);

            if($row['2_person'] == 'on'){
                $p2->start = $row['start_date_time'];
                $p2->email = $row['customer_email'];
                $p2->name = $row['person_2_name'];
                $p2->nachname = $row['person_2_nachname'];
                $p2->strasse = $row['person_2_strasse'];
                $p2->hausnummer = $row['person_2_hausnummer'];
                $p2->postleitzahl = $row['person_2_postleitzahl'];
                $p2->stadt = $row['person_2_stadt'];
                $p2->geburtsdatum_ttmmjjjj = $row['person_2_geburtsdatum_ttmmjjjj'];
                $p2->personalausweisnummer_optional = $row['person_2_personalausweisnummer_optional'];
                array_push($alltests, $p2);
            }


            dd($row);
        }

        dd($alltests);
    }
}
