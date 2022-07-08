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
        $testthismonth = Test::where('teststelle', '=', Auth::user()->teststelle)->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get();
        $testsheutefree = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('price', '=', 'free')->get();
        $testsheutepaid = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('price', '=', 'paid')->get();
        $testsheutepaidten = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate('created_at', Carbon::today())->where('price', '=', '10')->get();
        $positivheutefree = Test::where('teststelle', '=', Auth::user()->teststelle)->where('ergebnis', '=', '7' )->whereDate('created_at', Carbon::today())->where('price', '=', 'free')->get();
        $positivheutepaid = Test::where('teststelle', '=', Auth::user()->teststelle)->where('ergebnis', '=', '7' )->whereDate('created_at', Carbon::today())->where('price', '=', 'paid')->get();
        $positivheutepaidten = Test::where('teststelle', '=', Auth::user()->teststelle)->where('ergebnis', '=', '7' )->whereDate('created_at', Carbon::today())->where('price', '=', '10')->get();
        $testsThisMonthfree = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween('created_at',[
        $today->startOfMonth()->format('Y-m-d'),
        $today->endOfMonth()->format('Y-m-d')
    ])->where('price', '=', 'free')->get();
        $testsThisMonthpaid = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween('created_at',[
        $today->startOfMonth()->format('Y-m-d'),
        $today->endOfMonth()->format('Y-m-d')
    ])->where('price', '=', 'paid')->get();
        $testsThisMonthpaidten = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween('created_at',[
        $today->startOfMonth()->format('Y-m-d'),
        $today->endOfMonth()->format('Y-m-d')
    ])->where('price', '=', '10')->get();

        return view('dashboard', ['testhute' => count($testsheutefree) + count($testsheutepaid) + count($testsheutepaidten), 'thismonth' => count($testthismonth), 'positivheutefree' => count($positivheutefree), 'positivheutepaid' => count($positivheutepaid), 'positivheutepaidten' => count($positivheutepaidten), 'testsheutefree' => count($testsheutefree), 'testsheutepaid' => count($testsheutepaid), 'testsheutepaidten' => count($testsheutepaidten), 'testsThisMonthfree' => count($testsThisMonthfree), 'testsThisMonthpaid' => count($testsThisMonthpaid), 'testsThisMonthpaidten' => count($testsThisMonthpaidten)]);
    }
}
