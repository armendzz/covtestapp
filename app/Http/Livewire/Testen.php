<?php

namespace App\Http\Livewire;
use App\Models\Test;
use Livewire\Component;

class Testen extends Component
{
    public $term = "";

    public function render()
    {
        if (strlen($this->term) >= 3) {
            $tests = Test::whereNotNull('ergebnis')->where('fn', 'like', $this->term . '%')->orWhere('ln', 'like', $this->term . '%')->orderBy('created_at', 'desc')->get();
            return view('livewire.testen', ['tests' => $tests]);
        } else {
            return view('livewire.testen');
        }

    }
}
