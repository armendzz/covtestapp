<?php

namespace App\Http\Controllers;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard(){

        $today = Carbon::today();
        // $testthismonth = Test::where('teststelle', '=', Auth::user()->teststelle)->whereMonth('created_at', date('m'))
        // ->whereYear('created_at', date('Y'))
        // ->get();
        $testsheutefree = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->whereIn('price', ['1','2','3','4','5','10','11','12'])->get();
        $testsheutepaid = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->whereIn('price', ['6','7','8','9'])->get();
        $testsheutepaidten = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('price', '=', '13')->get();
        $positivheutefree = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('ergebnis', '=', '7' )->whereIn('price', ['1','2','3','4','5','10','11','12'])->get();
        $positivheutepaid = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('ergebnis', '=', '7' )->whereIn('price', ['6','7','8','9'])->get();
        $positivheutepaidten = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('ergebnis', '=', '7' )->where('price', '=', '13')->get();
    //     $testsThisMonthfree = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween('created_at',[
    //     $today->startOfMonth()->format('Y-m-d'),
    //     $today->endOfMonth()->format('Y-m-d')
    // ])->where('price', '=', 'free')->get();
    //     $testsThisMonthpaid = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween('created_at',[
    //     $today->startOfMonth()->format('Y-m-d'),
    //     $today->endOfMonth()->format('Y-m-d')
    // ])->where('price', '=', 'paid')->get();
    //     $testsThisMonthpaidten = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween('created_at',[
    //     $today->startOfMonth()->format('Y-m-d'),
    //     $today->endOfMonth()->format('Y-m-d')
    // ])->where('price', '=', '10')->get();

        return view('dashboard', ['testhute' => count($testsheutefree) + count($testsheutepaid) + count($testsheutepaidten), 'positivheutefree' => count($positivheutefree), 'positivheutepaid' => count($positivheutepaid), 'positivheutepaidten' => count($positivheutepaidten), 'testsheutefree' => count($testsheutefree), 'testsheutepaid' => count($testsheutepaid), 'testsheutepaidten' => count($testsheutepaidten)]);
    }

    public function import(){
        dd('asd');
    }
}
