<?php

namespace App\Http\Controllers;

use App\Models\Kunde;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KundeController extends Controller
{
    
	// public function armend(){

	// $kunden = Kunde::where('fn', 'like', 'mul%')->orWhere('ln', 'like', 'mul%')->get();
	// return $kunden;

	// }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kunden = Kunde::with('tests')->paginate(20);

        return view('kunde/index', ['kunden' => $kunden]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kunde/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'ln' => ['required', 'string', 'max:255'],
            'fn' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['nullable', 'string', 'email'],
            'addresse' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'idnumber' => ['nullable', 'string'],
            'notice' => ['nullable', 'string'],
        ])->validate();

        // Check if kunde alerdy is in database
        $checkifexist = Kunde::where('dob', '=', $request->dob)->where('ln', '=', $request->ln)->where('fn', '=', $request->fn)->get();

        if (count($checkifexist) > 0) {
            session()->flash('info', 'Kunde existiert bereits.');
            return view('kunde/create', ['kunde' => $checkifexist[0]]);
        } else {
            // add to database kunde if not exist
            $client = Kunde::Create([
                'fn' => ucfirst($request->fn),
                'ln' => ucfirst($request->ln),
                'addresse' => ucfirst($request->addresse),
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'idnumber' => $request->idnumber,
                'notice' => $request->notice,
            ]);

            return redirect('kunde/' . $client->id);
        }
    }


    public function import(Request $request)
    {

        
      
        $Essen_Alle_Daten = $json['Essen_Alle_Daten'];
     
            // foreach($Essen_Alle_Daten as $kunde){

            
            //         $gebjahr = explode('/',$kunde['Geburtsdatum']);

            //         if(count($gebjahr) == 3){
            //             if(strlen($gebjahr[1]) == 1){
               
            //                 $gebjahr[1] = '0'.$gebjahr[1];
            //             }
            //             if(strlen($gebjahr[0]) == 1){
                         
            //                 $gebjahr[0] = '0'.$gebjahr[0];
            //             }
            //             if($gebjahr[2][0] == 0 || $gebjahr[2][0] == 1){
            //                 $gebjahr[2] = '20' . $gebjahr[2];
                                                
            //                 $kunde['Geburtsdatum'] = $gebjahr[1] . '-'. $gebjahr[0] .'-'. $gebjahr[2];
            //             } else {
            //                 $gebjahr[2] = '19' . $gebjahr[2];
                        
            //                 $kunde['Geburtsdatum'] = $gebjahr[1] . '-'. $gebjahr[0] .'-'. $gebjahr[2];
                        
                         
            //             }

            //         }

            //         $gebjahr = explode('.',$kunde['Geburtsdatum']);
                    
            //         if(count($gebjahr) == 3){
            //             if(strlen($gebjahr[1]) == 1){
               
            //                 $gebjahr[1] = '0'.$gebjahr[1];
            //             }
            //             if(strlen($gebjahr[0]) == 1){
                         
            //                 $gebjahr[0] = '0'.$gebjahr[0];
            //             }
            //             if($gebjahr[2][0] == 0 || $gebjahr[2][0] == 1){
            //                 $gebjahr[2] = '20' . $gebjahr[2];
                                                
            //                 $kunde['Geburtsdatum'] = $gebjahr[1] . '-'. $gebjahr[0] .'-'. $gebjahr[2];
            //             } else {
            //                 $gebjahr[2] = '19' . $gebjahr[2];
                        
            //                 $kunde['Geburtsdatum'] = $gebjahr[1] . '-'. $gebjahr[0] .'-'. $gebjahr[2];
                        
                         
            //             }

            //         }
             
           
            //   if(strlen($kunde['Geburtsdatum']) != 10){
             
            //     $kunde['Geburtsdatum'] = '01-01-1990';

            //   }

          
            //     // $client = Kunde::Create([
            //     //     'fn' => ucfirst($kunde['Vorname']),
            //     //     'ln' => ucfirst($kunde['Nachname']),
            //     //     'addresse' => ucfirst($kunde['Straße'] . ' ' . $kunde['Hausnummer'] . ' ' . $kunde['PLZ']. ' ' .$kunde['Stadt']),
            //     //     'dob' => date('Y-m-d H:i:s', strtotime($kunde['Geburtsdatum'])),
            //     //     'email' => $kunde['Email'],
            //     //     'phone' => '',
            //     //     'idnumber' => $kunde['Personalnr'],
            //     //     'notice' => '',
            //     // ]);
            // }

            var_dump(count($Essen_Alle_Daten)); 
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kunde = Kunde::find($id);
        return view('kunde/show', ['kunde' => $kunde]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kunde = Kunde::find($id);

        return view('kunde/edit', ['kunde' => $kunde]);

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
        
        Validator::make($request->all(), [
            'ln' => ['required', 'string', 'max:255'],
            'fn' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['nullable', 'string', 'email'],
            'addresse' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'idnumber' => ['nullable', 'string'],
            'notice' => ['nullable', 'string'],
        ])->validate();


        $kunde = Kunde::find($id);
        
        $data = [
             'fn' => ucfirst($request->fn),
             'ln' => ucfirst($request->ln),
             'addresse' => ucfirst($request->addresse),
             'dob' => $request->dob,
             'email' => $request->email,
             'phone' => $request->phone,
             'idnumber' => $request->idnumber,
             'notice' => $request->notice,
        ];

        $kunde->update($data);
        
        session()->flash('success', 'Client erfolgreich bearbeitet.');
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
        $kunde = Kunde::find($id);

        $testsInWarteZeit = Test::where('kunde_id', '=', $kunde->id)->where('ergebnis', '=', NULL)->get();
        
        foreach($testsInWarteZeit as $test){
            $test->delete();
        }

        $kunde->delete();
        return redirect('/dashboard');
    }
}
