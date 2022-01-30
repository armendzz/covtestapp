<?php

namespace App\Http\Controllers;
use App\Models\Kunde;
use App\Models\Test;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
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
            'user_id' => Auth::user()->id,
            'digital' => $request->digital,
            'test_nr' => $testnr,
        ];

        // Set email to test if kunde has email entry
        if(isset($kunde->email)){
            $testdata['email'] = $kunde->email;
        }

        // Set phone to test if kunde has phone entry
        if(isset($kunde->phone)){
            $testdata['phone'] = $kunde->phone;
        }

        // Create test and send user to dashboard
        $test = Test::Create($testdata);

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
        
        // check if any data is updated in kunde table
        if($test->fn != $kunde->fn || $test->ln != $kunde->ln || $test->addresse != $kunde->addresse || $test->dob != $kunde->dob || $test->email != $kunde->email || $test->phone != $kunde->phone ){
            return view('tests/show', ['test' => $test, 'update' => true]);
        }

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
        if(isset($kunde->email)){
            $data['email'] = $kunde->email;
        }

        // Set phone to test if kunde has phone entry
        if(isset($kunde->phone)){
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
        $pdf->Cell(174, 6, 'Test-Nr: '. $test->test_nr, 0, 0, 'R');
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

        $pdf->Cell(97, 12, 'Teststellen-Nr '.$teststellen, 0, 0, 'L');
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
        if($test->digital == '1'){
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
        $pdf->Image('signature/'.Auth::user()->id.'.png',130,195,-300);
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
        $test->delete();
        return redirect('/dashboard');
    }

    public function inWarteZeit(){

        // Get all tests without ergebniss
        $tests = Test::whereNull('ergebnis')->with('kunde')->orderBy('created_at', 'asc')->get();
        return view('tests/inwartezeit', ['tests' => $tests]);
    }

    public function testErgebnis(Request $request, $id){

        // Get test to update result
        $test = Test::find($id);
        
        // Get month, name, date and time to create a unique filename for PDF 
        $month = 'testen/' . date("m-Y");
        $name = $test->ln . ', ' . $test->fn;
        $emailnamekunde = $test->ln . ', ' . $test->fn;
        $filename = $month . '/' . date("d.m.Y  -  H:i:s ") . $name . '.pdf';

        // Set result and filename to update data in database
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

        $pdf->SetFontSize(13);
        $pdf->setY(7);
        $pdf->cell(0.7);
        $pdf->Cell(174, 6, 'Test-Nr: '. $testnr, 0, 0, 'R');
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
        $teststelle = iconv('UTF-8', 'windows-1252', Auth::user()->teststelle);

        $pdf->Cell(97, 12, 'Teststellen-Nr '.$teststelle, 0, 0, 'L');
        $pdf->Ln();
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
        if($test->digital == '1'){
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
        $pdf->Image('signature/'.Auth::user()->id.'.png',130,195,-300);

        $pdf->SetFontSize(15);
        $pdf->setY(204);
        $pdf->cell(15);
        $pdf->Cell(99.8, 6, date("d.m.Y"), 0, 0, 'L');
        $pdf->Output('F', $filename);
        // PDF Filling END 


        // if kunde want result per email
         if($test->digital == '1'){
            $to_name = $emailnamekunde;
            $to_email = $test->kunde->email;
            $data = array('name'=>'Ogbonna Vitalis(sender_name)', 'body' => 'A test mail');
          
            Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $filename) {
            $message->to($to_email, $to_name)
            ->subject('Bescheinigung')->attach($filename, [
                'as' => date("d.m.Y") . ' Testergebnis.pdf',
                'mime' => 'application/pdf',
           ]);
            $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
            });
        }
        
        // return test
        return redirect('tests/'.$test->id);

    }
}
