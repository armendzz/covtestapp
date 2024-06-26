<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    use \App\Traits\Uuids;

    protected $fillable = [
        'user_id',
        'kunde_id',
        'filename',
        'test_nr',
        'digital',
        'addresse',
        'ergebnis',
        'fn',
        'ln',
        'dob',
        'created_at',
        'updated_at',
        'salt',
        'laborid',
        'teststelle',
        'phone',
        'email',
        'hersteller',
    ];

    // get kunde of this test
    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }

    // get user of this test
    public function user(){
        return $this->belongsTo(User::class);
    }

}
