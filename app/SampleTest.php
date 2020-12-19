<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleTest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
