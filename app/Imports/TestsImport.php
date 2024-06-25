<?php

namespace App\Imports;

use App\Models\Kunde;
use App\Models\Test;
use DateTime;
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
            $p->phone = $row['customer_phone'];
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
                $p2->phone = $row['customer_phone'];
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

            if($row['3_person'] == 'on'){
                $p3->start = $row['start_date_time'];
                $p3->email = $row['customer_email'];
                $p3->phone = $row['customer_phone'];
                $p3->name = $row['person_3_name'];
                $p3->nachname = $row['person_3_nachname'];
                $p3->strasse = $row['person_3_strasse'];
                $p3->hausnummer = $row['person_3_hausnummer'];
                $p3->postleitzahl = $row['person_3_postleitzahl'];
                $p3->stadt = $row['person_3_stadt'];
                $p3->geburtsdatum_ttmmjjjj = $row['person_3_geburtsdatum_ttmmjjjj'];
                $p3->personalausweisnummer_optional = $row['person_3_personalausweisnummer_optional'];
                array_push($alltests, $p3);
            }

            if($row['4_person'] == 'on'){
                $p4->start = $row['start_date_time'];
                $p4->email = $row['customer_email'];
                $p4->phone = $row['customer_phone'];
                $p4->name = $row['person_4_name'];
                $p4->nachname = $row['person_4_nachname'];
                $p4->strasse = $row['person_4_strasse'];
                $p4->hausnummer = $row['person_4_hausnummer'];
                $p4->postleitzahl = $row['person_4_postleitzahl'];
                $p4->stadt = $row['person_4_stadt'];
                $p4->geburtsdatum_ttmmjjjj = $row['person_4_geburtsdatum_ttmmjjjj'];
                $p4->personalausweisnummer_optional = $row['person_4_personalausweisnummer_optional'];
                array_push($alltests, $p4);
            }

            if($row['5_person'] == 'on'){
                $p5->start = $row['start_date_time'];
                $p5->email = $row['customer_email'];
                $p5->phone = $row['customer_phone'];
                $p5->name = $row['person_5_name'];
                $p5->nachname = $row['person_5_nachname'];
                $p5->strasse = $row['person_5_strasse'];
                $p5->hausnummer = $row['person_5_hausnummer'];
                $p5->postleitzahl = $row['person_5_postleitzahl'];
                $p5->stadt = $row['person_5_stadt'];
                $p5->geburtsdatum_ttmmjjjj = $row['person_5_geburtsdatum_ttmmjjjj'];
                $p5->personalausweisnummer_optional = $row['person_5_personalausweisnummer_optional'];
                array_push($alltests, $p5);
            }

        }

        foreach ($alltests as $t) {
            $this->createTest($t);
        }

    }

    public function createTest($data)  {

        $client = Kunde::Create([
            'fn' => ucfirst($data->name),
            'ln' => ucfirst($data->nachname),
            'addresse' => ucfirst($data->strasse . ' ' . $data->hausnummer . ', ' . $data->postleitzahl . ' ' . $data->stadt),
            'dob' => date('Y-m-d', strtotime(str_replace('-', '/', $data->geburtsdatum_ttmmjjjj))),
            'email' => $data->email,
            'phone' => $data->phone,
            'idnumber' => '',
            'notice' => '',
        ]);

        $created_at = DateTime::createFromFormat('d M, Y, H:i', $data->start);



        $testdata = [
            'fn' => $client->fn,
            'ln' => $client->ln,
            'dob' => $client->dob,
            'laborid' => '11111',
            'teststelle' => '11111',
            'hersteller' => 'oberhausen11111',
            'salt' => strtoupper(bin2hex(random_bytes(16))),
            'addresse' => $client->addresse,
            'kunde_id' => $client->id,
            'price' => 1,
            'user_id' => 10,
            'digital' => '0',
            'test_nr' => '1',
            'created_at' => $created_at->format('Y-m-d H:i:s')
        ];


        // Create test and send user to dashboard
        Test::Create($testdata);

    }
}
