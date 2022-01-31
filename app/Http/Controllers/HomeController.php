<?php

namespace App\Http\Controllers;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard(){
        $testthismonth = Test::where('teststelle', '=', Auth::user()->teststelle)->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get();
        $testsheute = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->get();
        $positivheute = Test::where('teststelle', '=', Auth::user()->teststelle)->where('ergebnis', '=', '7' )->whereDate('created_at', Carbon::today())->get();
       
        return view('dashboard', ['testhute' => count($testsheute), 'thismonth' => count($testthismonth), 'positivheute' => count($positivheute)]);
    }
}
