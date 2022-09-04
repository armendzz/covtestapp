<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunde extends Model
{
    use HasFactory;
    use \App\Traits\Uuids;
    
    protected $fillable = [
        'fn',
        'ln',
        'addresse',
        'dob',
        'idnumber',
        'email',
        'phone',
        'notice'
    ];

    // get all tests that belongs to kunde
    public function tests(){
        return $this->hasMany(Test::class);
    }
}
