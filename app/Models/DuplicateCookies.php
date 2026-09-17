<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuplicateCookies extends Model
{
    protected $table = 'entry_duplicate_cookies';

    public $timestamps = false;

    protected $fillable = [
        'dupl_user',
        'dupli_usr_val',
        'current_usr',
        'entry_date',
    ];

    protected $casts = [
        'id'          => 'integer',
        'current_usr' => 'integer',
        'entry_date'  => 'datetime',
    ];
}