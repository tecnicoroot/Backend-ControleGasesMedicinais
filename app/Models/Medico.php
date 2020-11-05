<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $fillable = [
        'crm','nome','telefone','celular','fax','email',
    ];
}
