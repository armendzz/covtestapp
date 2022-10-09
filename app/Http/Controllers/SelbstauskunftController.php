<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Selbstauskunft;

class SelbstauskunftController extends Controller
{
    public function index(){
        $selbstauskunft = Selbstauskunft::with('test')->orderBy('created_at', 'desc')->paginate(20);
        return view('selbstauskunft/index', ['selbstauskunft' => $selbstauskunft]);
    }

    public function show($id){
        $selbstauskunft = Selbstauskunft::find($id);
        return view('selbstauskunft/show', ['selbstauskunft' => $selbstauskunft]);
    }
}
