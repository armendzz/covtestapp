<?php

namespace App\Http\Controllers;

use App\Models\Kunde;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KundeController extends Controller
{

    public function importdata(Request $request){

        $client = Kunde::Create([
            'fn' => ucfirst($request->vorname),
             'ln' => ucfirst($request->nachname),
             'addresse' => ucfirst($request->anschrift),
             'dob' => $request->birthday,
             'email' => $request->email,
             'phone' => $request->phone,
             'idnumber' => $request->idnumber,
        ]);

        return 'ok';
    }

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
            ]);

            return redirect('kunde/' . $client->id);
        }
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
        $kunde->delete();
        return redirect('/dashboard');
    }
}
