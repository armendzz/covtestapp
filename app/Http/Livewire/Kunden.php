<?php

namespace App\Http\Livewire;
use App\Models\Kunde;
use Livewire\Component;

class Kunden extends Component
{
    public $term = "";
    
    public function render()
    {
        // check if input is large as 3 chars then send query to db, to avoid too much result
        if(strlen($this->term) >= 3){
		// check only for vorname and nachname
	
		//$this->term = rtrim($this->term, " ");
            $kunden = Kunde::where('fn', 'like', $this->term .'%')->orWhere('ln', 'like', $this->term .'%')->get();
                $data = [
                    'kunden' => $kunden,
                        ];
                return view('livewire.kunden',[ 'kunden' => $kunden ]);
            } else {
                return view('livewire.kunden');
            }
        
    }
}
