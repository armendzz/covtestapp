<?php

namespace App\Http\Controllers;

use App\Models\Kunde;
use App\Models\Test;
use App\Models\Rechnung;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\Selbstauskunft;
use Mail;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::with('user')->whereNotNull('ergebnis')->orderBy('created_at', 'desc')->paginate(20);

        return view('tests/index', ['tests' => $tests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // get kunde to create test with kunden data
        $kunde = Kunde::find($request->kundeid);

        // get how much tests are today stored
        $testsheute = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->get();
        // set variable to store test-nr for today
        $testnr = count($testsheute) + 1;

        $testdata = [
            'fn' => $kunde->fn,
            'ln' => $kunde->ln,
            'dob' => $kunde->dob,
            'laborid' => Auth::user()->laborid,
            'teststelle' => Auth::user()->teststelle,
            'hersteller' => Auth::user()->hersteller,
            'salt' => strtoupper(bin2hex(random_bytes(16))),
            'addresse' => $kunde->addresse,
            'kunde_id' => $kunde->id,
            'price' => $request->price,
            'user_id' => Auth::user()->id,
            'digital' => $request->digital,
            'test_nr' => $testnr,
        ];

        // Set email to test if kunde has email entry
        if (isset($kunde->email)) {
            $testdata['email'] = $kunde->email;
        }

        // Set phone to test if kunde has phone entry
        if (isset($kunde->phone)) {
            $testdata['phone'] = $kunde->phone;
        }

        // Create test and send user to dashboard
        $test = Test::Create($testdata);

        if ($test->price == "6" || $test->price == "7" ||  $test->price == "8" || $test->price == "9" || $request->price == '13') {
            $rechnung = new Rechnung;

            $rechnungDb = Rechnung::whereDate('created_at', Carbon::today())->get();
            $rechnungNrHeute = count($rechnungDb) + 1;

            if ($rechnungNrHeute < 10) {
                $rechnungNrHeutee = "00$rechnungNrHeute";
            } else if ($rechnungNrHeute < 100) {
                $rechnungNrHeutee = "0$rechnungNrHeute";
            } else if ($rechnungNrHeute < 1000) {
                $rechnungNrHeutee = "$rechnungNrHeute";
            }

            $rechnung->test_id = $test->id;
            $rechnung->rechung_nr = Carbon::now()->format('y') . Carbon::now()->format('m') . Carbon::now()->format('d') . $rechnungNrHeutee;


            $foldername = 'rechnungen/' . date("Y/m/d");

            if (!file_exists($foldername)) {
                mkdir($foldername, 0777, true);
            }

            $filename = $foldername . '/' . $rechnung->rechung_nr  . '.pdf';


            $rechnung->filename = $filename;
            $rechnung->save();

            $pdf = new Fpdi();
            if ($test->price == "6" || $test->price == "7" ||  $test->price == "8" || $test->price == "9") {
                $pageCount = $pdf->setSourceFile('rechnung.pdf');
            }
            if ($request->price == '13') {
                $pageCount = $pdf->setSourceFile('rechnung10.pdf');
            }
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

            $pdf->addPage();
            $pdf->useTemplate($pageId, 0, 0, 210, 297);
            $pdf->SetFont('Helvetica');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFontSize(11);
            $pdf->SetXY(10, 30);




            $name = $test->ln . ', ' . $test->fn;
            $name = iconv('UTF-8', 'windows-1252', $name);
            $pdf->setY(25.5);
            $pdf->cell(13.5);
            $pdf->Cell(60, 6, $name, 0, 0, 'L');
            $pdf->Ln();
            $pdf->setY(30.5);
            $pdf->cell(13.5);
            $address = iconv('UTF-8', 'windows-1252', $test->addresse);
            $pdf->Cell(124, 6, $address, 0, 0, 'L');
            $pdf->Ln();


            $pdf->setY(93.4);
            $pdf->cell(41.4);
            $pdf->Cell(99.8, 6, $rechnung->rechung_nr, 0, 0, 'L');
            $pdf->Ln();
            if ($test->digital == 0) {
                $pdf->setY(210);
                $pdf->cell(14);
                $pdf->Cell(99.8, 6, "Stempel", 0, 0, 'L');
                $pdf->Ln();
            }

            $pdf->setY(210);
            $pdf->cell(154);
            $pdf->Cell(99.8, 6, "Unterschrift", 0, 0, 'L');
            $pdf->Ln();

        $pdf->setY(93.4);
        $pdf->cell(117.5);
        $pdf->Cell(99.8, 6, date("d.m.Y"), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Image('signature/'.Auth::user()->id.'.png',160,195,-300);
       
        $pdf->Output('F', $filename);

            $pdf->Output('F', $filename);
        }


        if($request->sign != ''){
            $selbstauskunft = new Selbstauskunft;

            $selbstauskunft->test_id = $test->id;
            $selbstauskunft->grund = $request->price;
    
    
            $foldername = 'selbstauskunft/' . date("Y/m/d");
    
            if (!file_exists($foldername)) {
                mkdir($foldername, 0777, true);
            }
    
            $name = $test->ln . ', ' . $test->fn;
    
            $filename = $foldername . '/' . date("d.m.Y  -  H-i-s ") . $name . '.pdf';
    
    
            $selbstauskunft->filename = $filename;
            $selbstauskunft->save();
    
    
            $pdf = new Fpdi();
    
            $pageCount = $pdf->setSourceFile('selbstauskunft.pdf');
    
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
    
            $pdf->addPage();
            $pdf->useTemplate($pageId, 0, 0, 210, 297);
            $pdf->SetFont('Helvetica');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFontSize(11);
            $pdf->SetXY(10, 30);
    
    
    
    
            $name = $test->ln . ', ' . $test->fn;
            $name = iconv('UTF-8', 'windows-1252', $name);
            $pdf->setY(29);
            $pdf->cell(44);
            $pdf->Cell(60, 6, $name, 0, 0, 'L');
            $pdf->Ln();
    
            $anschrift = $test->addresse;
            $anschrift = iconv('UTF-8', 'windows-1252', $anschrift);
            $pdf->setY(36);
            $pdf->cell(44);
            $pdf->Cell(60, 6, $anschrift, 0, 0, 'L');
            $pdf->Ln();
    
    
            $dob = $test->dob;
            $dob = iconv('UTF-8', 'windows-1252', $dob);
            $pdf->setY(43);
            $pdf->cell(44);
            $pdf->Cell(60, 6, $dob, 0, 0, 'L');
            $pdf->Ln();
    
    
            if ($request->price == '1') {
                $pdf->setY(60);
                $pdf->cell(16);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
            if ($request->price == '2') {
                $pdf->setY(68.5);
                $pdf->cell(16);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
            if ($request->price == '3') {
                $pdf->setY(80.35);
                $pdf->cell(16);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
            if ($request->price == '4') {
                $pdf->setY(92.5);
                $pdf->cell(16);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
            if ($request->price == '5') {
                $pdf->setY(104.8);
                $pdf->cell(16);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
    
            // xhasha
            if ($test->price == "6" || $test->price == "7" ||  $test->price == "8") {
                $pdf->setY(137.2);
                $pdf->cell(15.7);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
    
                $pdf->setY(173.5);
                $pdf->cell(25.6);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
    
            if ($test->price == "6") {
                $pdf->setY(145.3);
                $pdf->cell(25.6);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
            if ($test->price == "7") {
                $pdf->setY(153.4);
                $pdf->cell(25.6);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
            if ($test->price == "8") {
                $pdf->setY(161.6);
                $pdf->cell(25.6);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
    
    
    
            // shtata
            if ($test->price == "9") {
    
                $pdf->setY(182);
                $pdf->cell(15.7);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
    
                $pdf->setY(193.8);
                $pdf->cell(25.6);
                $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
                $pdf->Ln();
            }
    
    
            if ($test->price == "10") {
            $pdf->setY(205.4);
            $pdf->cell(15.3);
            $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
            }
    
            if ($test->price == "11") {
            $pdf->setY(225.5);
            $pdf->cell(15.3);
            $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
            }
    
            if ($test->price == "12") {
            $pdf->setY(237.4);
            $pdf->cell(15.3);
            $pdf->Cell(99.8, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
            }
    
            $ortUndDatum = env('STATION_ORT') . ', ' . date("d.m.Y");
            $ortUndDatum = iconv('UTF-8', 'windows-1252', $ortUndDatum);
            $pdf->setY(260);
            $pdf->cell(15.4);
            $pdf->Cell(99.8, 6, $ortUndDatum, 0, 0, 'L');
            $pdf->Ln();
    
            $pdf->Image($request->sign, 113, 250, -300, 0, "PNG");
    
    
            $pdf->Output('F', $filename);
        }

       

    
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $test = Test::find($id);
        $kunde = Kunde::find($test->kunde_id);

        if (isset($kunde)) {
            if ($test->fn != $kunde->fn || $test->ln != $kunde->ln || $test->addresse != $kunde->addresse || $test->dob != $kunde->dob || $test->email != $kunde->email || $test->phone != $kunde->phone) {
                return view('tests/show', ['test' => $test, 'update' => true]);
            }
        }
        // check if any data is updated in kunde table


        return view('tests/show', ['test' => $test]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        $kunde = Kunde::find($test->kunde_id);


        $data = [
            'fn' => $kunde->fn,
            'ln' => $kunde->ln,
            'addresse' => $kunde->addresse,
            'dob' => $kunde->dob,
        ];

        // Set email to test if kunde has email entry
        if (isset($kunde->email)) {
            $data['email'] = $kunde->email;
        }

        // Set phone to test if kunde has phone entry
        if (isset($kunde->phone)) {
            $data['phone'] = $kunde->phone;
        }

        $test->update($data);

        unlink($test->filename);

        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile('testtemplate.pdf');
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

        $pdf->addPage();
        $pdf->useTemplate($pageId, 0, 0, 210, 297);
        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFontSize(10);
        $pdf->SetXY(10, 30);

        $pdf->SetFontSize(13);
        $pdf->setY(7);
        $pdf->cell(0.7);
        $pdf->Cell(174, 6, 'Test-Nr: ' . $test->test_nr, 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(56);
        $pdf->cell(82);
        $pdf->Cell(97, 12, '', 1, 0, 'L');
        $pdf->Ln();
        $pdf->setY(52.4);
        $pdf->cell(82);
        $zentrumname = iconv('UTF-8', 'windows-1252', env('APP_NAME'));
        $pdf->Cell(97, 12, $zentrumname, 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(56);
        $pdf->cell(82);
        $address = iconv('UTF-8', 'windows-1252', Auth::user()->addresse);

        $pdf->Cell(97, 12, $address, 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(60);
        $pdf->cell(82);
        $teststellen = iconv('UTF-8', 'windows-1252', Auth::user()->teststelle);

        $pdf->Cell(97, 12, 'Teststellen-Nr ' . $teststellen, 0, 0, 'L');
        $pdf->Ln();
        $name = $test->ln . ', ' . $test->fn;
        $name = iconv('UTF-8', 'windows-1252', $name);
        $pdf->setY(71.5);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, $name, 1, 0, 'L');
        $pdf->Ln();
        $pdf->setY(79.5);
        $pdf->cell(62.7);
        $address = iconv('UTF-8', 'windows-1252', $test->addresse);
        $pdf->Cell(124, 6, $address, 1, 0, 'L');
        $pdf->Ln();
        $pdf->setY(87.5);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, date("d.m.Y", strtotime($test->dob)), 1, 0, 'L');
        $pdf->Ln();
        //id number
        $pdf->setY(95.4);
        $pdf->cell(81);
        $pdf->Cell(105.8, 6, $test->kunde->idnumber, 1, 0, 'L');
        $pdf->Ln();

        //tel
        $pdf->SetFontSize(11);
        $pdf->setY(103.4);
        $pdf->cell(14.1);
        $pdf->Cell(105.8, 6, 'Tel:', 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetFontSize(10);
        $pdf->setY(103.4);
        $pdf->cell(22.7);
        $pdf->Cell(35, 6, $test->phone, 1, 0, 'L');
        $pdf->Ln();
        //email
        $pdf->SetFontSize(11);
        $pdf->setY(103.4);
        $pdf->cell(62);
        $pdf->Cell(105.8, 6, 'E-Mail:', 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetFontSize(10);
        $pdf->setY(103.4);
        $pdf->cell(81);
        $pdf->Cell(105.8, 6, $test->email, 1, 0, 'L');
        $pdf->Ln();


        $pdf->setY(118);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, 'COVID-19 Antigen Rapid Test', 1, 0, 'L');
        $pdf->Ln();

        $pdf->setY(126);
        $pdf->cell(62.7);
        $hersteller = iconv('UTF-8', 'windows-1252', $test->hersteller);
        $pdf->Cell(124, 6, $hersteller, 1, 0, 'L');
        $pdf->Ln();

        $pdf->setY(134);
        $pdf->cell(87);
        $pdf->Cell(99.8, 6, date("d.m.Y  -  H:i", strtotime($test->created_at)), 1, 0, 'L');
        $pdf->Ln();

        $pdf->setY(142);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, Auth::user()->name, 1, 0, 'L');
        $pdf->Ln();

        $pdf->setY(163.5);
        $pdf->cell(41.5);
        $pdf->SetFontSize(20);
        $pdf->Cell(5, 6, 'X', 0, 0, 'L');
        $pdf->Ln();

        if ($test->ergebnis == 7) {
            //if positiv
            $pdf->setY(181);
            $pdf->cell(58);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
        } else if ($test->ergebnis == 6) {
            //if negativ
            $pdf->setY(181);
            $pdf->cell(122.7);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
        } else if ($test->ergebnis == 8) {
            // if ungultig
            $pdf->setY(181);
            $pdf->cell(133);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'Ungultig', 0, 0, 'L');
            $pdf->Ln();
        }
        if ($test->digital == '1') {
            $pdf->SetFontSize(10);
            $pdf->setY(200);
            $pdf->cell(45);
            $pdf->Cell(99.8, 6, "Dieses Schreiben wurde maschinell erstellt", 0, 0, 'L');
            $pdf->Ln();
            $pdf->setY(204);
            $pdf->cell(45);
            $pdf->Cell(99.8, 6, iconv('UTF-8', 'windows-1252', "und ist ohne Stempel gültig"), 0, 0, 'L');
            $pdf->Ln();
        }

        $pdf->SetFontSize(15);
        $pdf->setY(204);
        $pdf->cell(15);
        $pdf->Cell(99.8, 6, date("d.m.Y"), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Image('signature/' . Auth::user()->id . '.png', 130, 195, -300);

        if ($test->price == "6" || $test->price == "7" ||  $test->price == "8" || $test->price == "9" || $test->price == '13') {
            $pdf->setSourceFile($test->rechnung->filename);
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->AddPage();

            $pdf->useTemplate($pageId, 0, 0, 210, 297);
        }


        $pdf->Output('F', $test->filename);



        session()->flash('success', 'Test is erfolgreich Aktualisiert.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::find($id);
        if (isset($test->filename) && file_exists($test->filename)) {

            unlink($test->filename);
        }

        if (isset($test->rechnung->filename) && file_exists($test->rechnung->filename)) {
            unlink($test->rechnung->filename);
        }

        if (isset($test->price) && $test->price == '13' || $test->price == '13') {
            $test->rechnung->delete();
        }

        if(isset($test->selbstauskunft)){
            $test->selbstauskunft->delete();
            if(file_exists($test->selbstauskunft->filename)){
                unlink($test->selbstauskunft->filename);
            }
         
            
        }
      
        $test->delete();
        return redirect('/dashboard');
    }

    public function inWarteZeit()
    {

        // Get all tests without ergebniss
        $tests = Test::whereNull('ergebnis')->with('kunde')->orderBy('created_at', 'asc')->get();
        return view('tests/inwartezeit', ['tests' => $tests]);
    }

    public function testErgebnis(Request $request, $id)
    {

        // Get test to update result
        $test = Test::find($id);

        // Get month, name, date and time to create a unique filename for PDF 
        $month = 'testen/' . date("m-Y");
        $name = $test->ln . ', ' . $test->fn;
        $emailnamekunde = $test->ln . ', ' . $test->fn;

        
        $filename = $month . '/' . date("d.m.Y  -  H-i-s ") . $name . '.pdf';
   
        $data = [
            'ergebnis' => $request->ergebnis,
            'filename' => $filename,
        ];

        // check if folder for this month exists, every month create new folder
        if (!file_exists($month)) {
            mkdir($month, 0777, true);
        }

        $test->update($data);

        // Get test with result to fill pdf
        $test = Test::where('id', '=', $id)->with('kunde')->first();
        $testnr = $test->test_nr;

        // Start PDF filling

        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile('testtemplate.pdf');
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

        $pdf->addPage();
        $pdf->useTemplate($pageId, 0, 0, 210, 297);
        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFontSize(10);
        $pdf->SetXY(10, 30);

        // $pdf->SetFontSize(13);
        // $pdf->setY(7);
        // $pdf->cell(0.7);
        // $pdf->Cell(174, 6, 'Test-Nr: '. $testnr, 0, 0, 'R');
        // $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(56);
        $pdf->cell(82);
        $pdf->Cell(97, 12, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(52.4);
        $pdf->cell(82);
        $zentrumname = iconv('UTF-8', 'windows-1252', env('APP_NAME'));
        $pdf->Cell(97, 12, $zentrumname, 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(56);
        $pdf->cell(82);
        $address = iconv('UTF-8', 'windows-1252', Auth::user()->addresse);

        $pdf->Cell(97, 12, $address, 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(60);
        $pdf->cell(82);
        $teststelle = iconv('UTF-8', 'windows-1252', Auth::user()->teststelle);

        $pdf->Cell(97, 12, 'Teststellen-Nr ' . $teststelle, 0, 0, 'L');
        $pdf->Ln();
        $name = iconv('UTF-8', 'windows-1252', $name);
        $pdf->setY(73);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, $name, 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(80.5);
        $pdf->cell(62.7);
        $address = iconv('UTF-8', 'windows-1252', $test->addresse);
        $pdf->Cell(124, 6, $address, 0, 0, 'L');
        $pdf->Ln();
        $pdf->setY(88);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, date("d.m.Y", strtotime($test->dob)), 0, 0, 'L');
        $pdf->Ln();
        //id number
        $pdf->setY(95.8);
        $pdf->cell(80);
        $pdf->Cell(105.8, 6, $test->kunde->idnumber, 0, 0, 'L');
        $pdf->Ln();

        //tel
        $pdf->SetFontSize(11);
        $pdf->setY(103.4);
        $pdf->cell(14.1);
        $pdf->Cell(105.8, 6, 'Tel:', 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetFontSize(10);
        $pdf->setY(103.4);
        $pdf->cell(22.7);
        $pdf->Cell(35, 6, $test->phone, 1, 0, 'L');
        $pdf->Ln();
        //email
        $pdf->SetFontSize(11);
        $pdf->setY(103.4);
        $pdf->cell(62);
        $pdf->Cell(105.8, 6, 'E-Mail:', 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetFontSize(10);
        $pdf->setY(103.4);
        $pdf->cell(78.5);
        $pdf->Cell(99, 6, $test->email, 1, 0, 'L');
        $pdf->Ln();


        $pdf->setY(118);
        $pdf->cell(62.7);
        $pdf->Cell(124, 6, 'COVID-19 Antigen Rapid Test', 0, 0, 'L');
        $pdf->Ln();

        $pdf->setY(126);
        $pdf->cell(62.7);
        $hersteller = iconv('UTF-8', 'windows-1252', $test->hersteller);
        $pdf->Cell(124, 6, $hersteller, 0, 0, 'L');
        $pdf->Ln();

        $pdf->setY(134);
        $pdf->cell(87);
        $pdf->Cell(99.8, 6, date("d.m.Y  -  H:i", strtotime($test->created_at)), 0, 0, 'L');
        $pdf->Ln();

        $pdf->setY(142);
        $pdf->cell(62.7);
        $username = iconv('UTF-8', 'windows-1252', Auth::user()->name);
        $pdf->Cell(124, 6, $username, 0, 0, 'L');
        $pdf->Ln();

        if ($test->price == "1" || $test->price == "2" || $test->price == "3" || $test->price == "4" || $test->price == "5" || $test->price == "10" || $test->price == "11" ||  $test->price == "6" || $test->price == "7" ||  $test->price == "8" || $test->price == "9" || $test->price == "12") {
            $pdf->setY(163);
            $pdf->cell(45);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
        }


        if ($test->price == "13") {
            $pdf->setY(163);
            $pdf->cell(168);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
        }


        if ($test->ergebnis == 7) {
            //if positiv
            $pdf->setY(182);
            $pdf->cell(58);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
        } else if ($test->ergebnis == 6) {
            //if negativ
            $pdf->setY(182);
            $pdf->cell(122.7);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'X', 0, 0, 'L');
            $pdf->Ln();
        } else if ($test->ergebnis == 8) {
            // if ungultig
            $pdf->setY(182);
            $pdf->cell(133);
            $pdf->SetFontSize(20);
            $pdf->Cell(5, 6, 'Ungultig', 0, 0, 'L');
            $pdf->Ln();
        }
        if ($test->digital == '1') {
            $pdf->SetFontSize(10);
            $pdf->setY(200);
            $pdf->cell(45);
            $pdf->Cell(99.8, 6, "Dieses Schreiben wurde maschinell erstellt", 0, 0, 'L');
            $pdf->Ln();
            $pdf->setY(204);
            $pdf->cell(45);
            $pdf->Cell(99.8, 6, iconv('UTF-8', 'windows-1252', "und ist ohne Stempel gültig"), 0, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Ln();
        $pdf->Image('signature/' . Auth::user()->id . '.png', 130, 195, -300);

        $pdf->SetFontSize(15);
        $pdf->setY(204);
        $pdf->cell(15);
        $pdf->Cell(99.8, 6, date("d.m.Y"), 0, 0, 'L');


        $pdf->useTemplate($pageId, 0, 0, 210, 297);
       }
       


        if ($test->price == "6" || $test->price == "7" ||  $test->price == "8" || $test->price == "9" || $test->price == '13') {
            $pdf->setSourceFile($test->rechnung->filename);
            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
            $pdf->AddPage();

            $pdf->useTemplate($pageId, 0, 0, 210, 297);
        }

        $pdf->Output('F',  $filename);
        // PDF Filling END 


        // if kunde want result per email
        if ($test->digital == '1') {
            $to_name = $emailnamekunde;
            $to_email = $test->kunde->email;
            $data = array();

            Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email, $filename) {
                $message->to($to_email, $to_name)
                    ->subject('Bescheinigung')->attach($filename, [
                        'as' => date("d.m.Y") . ' Testergebnis.pdf',
                        'mime' => 'application/pdf',
                    ]);
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        }

        // return test
        return redirect('tests/' . $test->id);
    }

    public function emailErneutSenden($id)
    {
        $test = Test::with('kunde')->find($id);
        $emailnameclient = $test->ln . ', ' . $test->fn;
        $filename = $test->filename;

        $to_name = $emailnameclient;

        // if email is changed get the new one
        $to_email = $test->kunde->email;
        $data = array();

        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email, $filename) {
            $message->to($to_email, $to_name)
                ->subject('Bescheinigung')->attach($filename, [
                    'as' => date("d.m.Y") . ' Testergebnis.pdf',
                    'mime' => 'application/pdf',
                ]);
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        return redirect('dashboard');
    }

    public function positive()
    {
        $positivheute = Test::where('teststelle', '=', Auth::user()->teststelle)->where('ergebnis', '=', '7')->whereDate('created_at', Carbon::today())->get();
        return view('tests/positive', ['positiveheute' => $positivheute]);
    }

    public function positiveForm($id)
    {

        $test = Test::where('id', '=', $id)->with('kunde')->get();

        // return $test;
        return view('tests/positiveform', ['test' => $test]);
    }

    public function positiveFormPrepare($id, Request $request)
    {

        $test = Test::where('id', '=', $id)->with('kunde')->with('user')->get();

        // Get month, name, date and time to create a unique filename for PDF 
        $month = 'positivetesten/' . date("m-Y");
        $name = $test[0]->ln . ', ' . $test[0]->fn;

        $filename = $month . '/' . date("d.m.Y  -  H-i-s ") . $name . '.pdf';

        if (!file_exists($month)) {
            mkdir($month, 0777, true);
        }
        // return $test;
        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile('positivtemplate.pdf');
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

        $pdf->addPage();
        $pdf->useTemplate($pageId, 0, 0, 210, 297);
        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFontSize(10);
        $pdf->SetXY(10, 30);

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(3);
        $pdf->Cell(0, 102, $request->gtel, 0, 0, 'L');
        $pdf->Ln();

        $gname = iconv('UTF-8', 'windows-1252', $request->gname);
        $pdf->SetFontSize(12);
        $pdf->setY(7);
        $pdf->cell(3);
        $pdf->Cell(0, 126, $gname, 0, 0, 'L');
        $pdf->Ln();

        $gstrasse = iconv('UTF-8', 'windows-1252', $request->gstrasse);
        $pdf->SetFontSize(12);
        $pdf->setY(7);
        $pdf->cell(3);
        $pdf->Cell(0, 149, $gstrasse, 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(12);
        $pdf->setY(7);
        $pdf->cell(3);
        $pdf->Cell(0, 172, $request->gplz, 0, 0, 'L');
        $pdf->Ln();

        $gcity = iconv('UTF-8', 'windows-1252', $request->gcity);
        $pdf->SetFontSize(12);
        $pdf->setY(7);
        $pdf->cell(22);
        $pdf->Cell(0, 172, $gcity, 0, 0, 'L');
        $pdf->Ln();

        $zentrumname = iconv('UTF-8', 'windows-1252', env('APP_NAME'));
        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(91.5);
        $pdf->Cell(0, 103, $zentrumname, 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(91.5);
        $pdf->Cell(0, 123, $test[0]->user->teststelle, 0, 0, 'L');
        $pdf->Ln();

        $zentrumstr = iconv('UTF-8', 'windows-1252', env('STATION_STR'));
        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(91.5);
        $pdf->Cell(0, 141, $zentrumstr, 0, 0, 'L');
        $pdf->Ln();

        $zentrumplz = iconv('UTF-8', 'windows-1252', env('STATION_PLZ'));
        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(91.5);
        $pdf->Cell(0, 158, $zentrumplz, 0, 0, 'L');
        $pdf->Ln();

        $zentrumplz = iconv('UTF-8', 'windows-1252', env('STATION_ORT'));
        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(113);
        $pdf->Cell(0, 158, $zentrumplz, 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(91.5);
        $pdf->Cell(0, 174, $test[0]->user->name, 0, 0, 'L');
        $pdf->Ln();


        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(133.5);
        $pdf->Cell(0, 174, env('STATION_TEL'), 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(97.5);
        $pdf->Cell(0, 191, env('MAIL_FROM_ADDRESS'), 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(164.5);
        $pdf->Cell(0, 193, Carbon::now()->format('d'), 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(171.5);
        $pdf->Cell(0, 193, Carbon::now()->format('m'), 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(177.5);
        $pdf->Cell(0, 193, Carbon::now()->format('Y'), 0, 0, 'L');
        $pdf->Ln();

        $kundename = iconv('UTF-8', 'windows-1252', $test[0]->ln . ', ' . $test[0]->fn);
        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(27);
        $pdf->Cell(0, 213, $kundename, 0, 0, 'L');
        $pdf->Ln();

        if ($request->gender == '1') {
            $pdf->SetFontSize(10.1);
            $pdf->setY(7);
            $pdf->cell(92.1);
            $pdf->Cell(0, 215.4, 'x', 0, 0, 'L');
            $pdf->Ln();
        }

        if ($request->gender == '2') {
            $pdf->SetFontSize(10.1);
            $pdf->setY(7);
            $pdf->cell(111.1);
            $pdf->Cell(0, 215.4, 'x', 0, 0, 'L');
            $pdf->Ln();
        }


        if ($request->gender == '3') {
            $pdf->SetFontSize(10.1);
            $pdf->setY(7);
            $pdf->cell(129.9);
            $pdf->Cell(0, 215.4, 'x', 0, 0, 'L');
            $pdf->Ln();
        }

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(164.5);
        $pdf->Cell(0, 214, substr($test[0]->dob, 8, 2), 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(170.5);
        $pdf->Cell(0, 214, substr($test[0]->dob, 5, 2), 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(9);
        $pdf->setY(7);
        $pdf->cell(176.5);
        $pdf->Cell(0, 214, substr($test[0]->dob, 0, 4), 0, 0, 'L');
        $pdf->Ln();

        $kundenstr = iconv('UTF-8', 'windows-1252', $test[0]->addresse);
        $pdf->SetFontSize(10);
        $pdf->setY(7);
        $pdf->cell(35);
        $pdf->Cell(0, 235, $kundenstr, 0, 0, 'L');
        $pdf->Ln();

        $kundenstr = iconv('UTF-8', 'windows-1252', $test[0]->phone);
        $pdf->SetFontSize(10);
        $pdf->setY(16);
        $pdf->cell(24);
        $pdf->Cell(0, 255, $kundenstr, 0, 0, 'L');
        $pdf->Ln();

        $kundenstr = iconv('UTF-8', 'windows-1252', $test[0]->email);
        $pdf->SetFontSize(10);
        $pdf->setY(141.5);
        $pdf->cell(14);
        $pdf->Cell(0, 20, $kundenstr, 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(166);
        $pdf->cell(4);
        $pdf->Cell(0, 20, 'X', 0, 0, 'L');
        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->setY(179);
        $pdf->cell(30);
        $pdf->Cell(99.8, 6, date("d.m.Y", strtotime($test[0]->created_at)), 0, 0, 'L');
        $pdf->Ln();

        $kundenstr = iconv('UTF-8', 'windows-1252', $test[0]->hersteller) . ' (Covid-19 Antigen Rapid-Test)';
        $pdf->SetFontSize(10);
        $pdf->setY(178);
        $pdf->cell(52);
        $pdf->Cell(0, 20, $kundenstr, 0, 0, 'L');
        $pdf->Ln();

        // $pdf->SetFontSize(10);
        // $pdf->setY(205);
        // $pdf->cell(10);
        // $pdf->Cell(0, 20, 'X', 0, 0, 'L');
        // $pdf->Ln();

        // $kundenstr = iconv('UTF-8', 'windows-1252', 'das Gesundheitsamt');
        // $pdf->SetFontSize(10);
        // $pdf->setY(204);
        // $pdf->cell(96);
        // $pdf->Cell(0, 20, $kundenstr, 0, 0, 'L');
        // $pdf->Ln();

        if (Auth::user()->teststelle == '36137') {
            $pcrradioja = date("d.m.Y");
        } else {
            $pcrradioja = $request['pcrja'];
        }

        if (Auth::user()->teststelle == '36137') {
            $pcrradionein = iconv('UTF-8', 'windows-1252', 'das Gesundheitsamt');
        } else {
            $pcrradionein = $request['pcrnein'];
        }

        if ($request['pcrradio'] == 'ja') {
            $pdf->SetFontSize(10);
            $pdf->setY(199.5);
            $pdf->cell(10);
            $pdf->Cell(0, 20, 'X', 0, 0, 'L');
            $pdf->Ln();

            $pdf->SetFontSize(10);
            $pdf->setY(198);
            $pdf->cell(40);
            $pcr =  iconv('UTF-8', 'windows-1252', $pcrradioja);
            $pdf->Cell(0, 20, $pcr, 0, 0, 'L');
            $pdf->Ln();
        }

        if ($request['pcrradio'] == 'nein') {

            $pdf->SetFontSize(10);
            $pdf->setY(205);
            $pdf->cell(10);
            $pdf->Cell(0, 20, 'X', 0, 0, 'L');
            $pdf->Ln();

            $kundenstr = iconv('UTF-8', 'windows-1252', $pcrradionein);
            $pdf->SetFontSize(10);
            $pdf->setY(204);
            $pdf->cell(96);
            $pdf->Cell(0, 20, $kundenstr, 0, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Output('F', $filename);

        return view('tests/positivepresending', ['test' => $test[0], 'filename' => $filename, 'gname' => $request->gname, 'gemail' => $request->gemail]);
    }

    public function positiveFormSend(Request $req, $id)
    {
        $test = Test::find($id);

        Test::where('id', $id)->update(array('ghaanmeldung' => '1'));

        $filename = $req->filename;
        $to_name = $req->gname;
        $to_email = $req->gemail;
        $data = array();

        Mail::send('emails.positive', $data, function ($message) use ($to_name, $to_email, $filename) {
            $message->to($to_email, $to_name)
                ->subject('Positivmeldung')->attach($filename, [
                    'as' => date("d.m.Y") . ' Positivmeldung.pdf',
                    'mime' => 'application/pdf',
                ]);
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        return redirect('/positive');
    }

    public function infoMailPositiv(Request $req, $id)
    {
        $test = Test::find($id);

        Test::where('id', $id)->update(array('kundeinformieren' => '1'));

        $to_name = $test->fn . ' ' . $test->ln;
        $to_email = $test->email;
        $data = array();

        Mail::send('emails.infopositive', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Positivmeldung Informationen');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

        return redirect('/positive');
    }
}
