<?php

namespace App\Models;

class ValidationAuth
{
    const RULE_AUTH = [
        'email' => 'required|email',
        'password'	=> 'required',
    ];
}