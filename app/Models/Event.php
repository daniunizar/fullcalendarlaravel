<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    static $rules=[
        'title'=>'required',
        'start'=>'required',
        'end'=>'required'
    ];

    protected $fillable=['title', 'start', 'end'];
}
