<?php

namespace App\Http\Controllers;

use App\Models\Rechnung;
use Illuminate\Http\Request;

class RechnungController extends Controller
{
    public function index(){
        $rechnungen = Rechnung::with('test')->orderBy('created_at', 'desc')->paginate(20);
        return view('rechnungen/index', ['rechnungen' => $rechnungen]);
    }

    public function show($id){
        $rechnung = Rechnung::find($id);
        return view('rechnungen/show', ['rechnung' => $rechnung]);
    }

    public function alles(){
        return view('rechnungen/alles');
    }

    public function dayrechnungen(Request $request){

        $rechnungen = Rechnung::whereDate('created_at', $request->date)->get();
        
        return view('rechnungen/dayrechnungenshow', ['rechnungen' => $rechnungen, 'date' => $request->date]);
    }

    public function rechnungdownload(Request $request){
        $rechnungen = Rechnung::whereDate('created_at', $request->date)->get();

        $zip_file = 'rechnungen/' . $request->date . '.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

      
       
        foreach ($rechnungen as $name => $file)
        {
            // We're skipping all subfolders
          

                // extracting filename with substr/strlen
                

                $zip->addFile($file->filename);
         
        }
        $zip->close();
        return response()->download($zip_file);

          
        return count($rechnungen);
    }
}

