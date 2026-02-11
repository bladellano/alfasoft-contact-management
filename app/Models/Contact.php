<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'country_code',
        'number',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
