<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rechnung extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'rechung_nr',
        'filename'
    ];

    public function test(){
        return $this->belongsTo(Test::class);
    }
}
