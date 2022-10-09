<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selbstauskunft extends Model
{
    use HasFactory;
    use \App\Traits\Uuids;

    protected $fillable = [
        'test_id',
        'grund',
        'filename'
    ];


    public function test(){
        return $this->belongsTo(Test::class);
    }
}
