<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function index(Request $r)
    {   

        $error = '';
        $tests = [];
        if(isset($r->fromDate)){
           
            if(!Carbon::now()->gte(date($r->fromDate . ' 00:00:00'))){
              
                $error = 'Start Date cannot be in the future';
            }
          
            if(!isset($r->toDate)){
                $error = 'Please select end Date';
            }

            $start = Carbon::createFromFormat('Y-m-d H:i:s', $r->fromDate . ' 00:00:00');

            if(isset($r->toDate)){
                $end = Carbon::createFromFormat('Y-m-d H:i:s', $r->toDate . ' 23:59:59');
                
                if($start->gt($end)){
                   $error = 'start date cannot be greater than end date';
                }
                
            }
        }

        if(isset($r->toDate) && !isset($r->fromDate)){
            $error = 'Please select start Date';
        }

        $today = Carbon::today();
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

        if(isset($r->fromDate) && isset($r->toDate)){
            $from = date($r->fromDate . ' 00:00:00');
            $to = date($r->toDate . ' 23:59:59');
            $tests = Test::where('teststelle', '=', Auth::user()->teststelle)->whereBetween(
                'created_at',
                [
                    $from,
                    $to
                ]
            )->get();
        } 

        if(!isset($r->fromDate) && !isset($r->toDate)){
            $today = Carbon::today();
            
            $from = date(Carbon::today() . ' 00:00:00');
            $to = date(Carbon::today() . ' 23:59:59');

            $tests = Test::where('teststelle', '=', Auth::user()->teststelle)->whereDate(
                'created_at',
                $today
            )->get();
                   
            $r->fromDate = $today->format('Y-m-d');
            $r->toDate = $today->format('Y-m-d');
        }
       
        $grund1 = 0;
        $grund2 = 0;
        $grund3 = 0;
        $grund4 = 0;
        $grund5= 0;
        $grund6 = 0;
        $grund7 = 0;
        $grund8 = 0;
        $grund9 = 0;
        $grund10 = 0;
        $grund11 = 0;
        $grund12 = 0;
        $grund13 = 0; 
        
        if($tests){
            foreach($tests as $test){
                if($test->price == 1){
                    $grund1++;
                }
                if($test->price == 2){
                    $grund2++;
                }
                if($test->price == 3){
                    $grund3++;
                }
                if($test->price == 4){
                    $grund4++;
                }
                if($test->price == 5){
                    $grund5++;
                }
                if($test->price == 6){
                    $grund6++;
                }
                if($test->price == 7){
                    $grund7++;
                }
                if($test->price == 8){
                    $grund8++;
                }
                if($test->price == 9){
                    $grund9++;
                }
                if($test->price == 10){
                    $grund10++;
                }
                if($test->price == 11){
                    $grund11++;
                }
                if($test->price == 12){
                    $grund12++;
                }
                if($test->price == 13){
                    $grund13++;
                }
            }
    
        }
    
        
        $total = $grund1 + $grund2 + $grund3 + $grund4 + $grund5 + $grund6 + $grund7 + $grund8 + $grund9 + $grund10 + $grund11 + $grund12 + $grund13;

        return view('stats/index', ['total' => $total, 'error' => $error ,'testsThisMonthfree' => count($testsThisMonthfree), 'testsThisMonthpaid' => count($testsThisMonthpaid),'testsThisMonthpaidten' => count($testsThisMonthpaidten), 'from' => $r->fromDate, 'to' => $r->toDate, 'grund1' => $grund1, 'grund2' => $grund2, 'grund3' => $grund3, 'grund4' => $grund4, 'grund5' => $grund5, 'grund6' => $grund6, 'grund7' => $grund7, 'grund8' => $grund8, 'grund9' => $grund9, 'grund10' => $grund10, 'grund11' => $grund11, 'grund12' => $grund12, 'grund13' => $grund13]);
    }
}
