<?php

namespace App\Models;

class ValidationUser
{
    const RULE_USER = [
        'name' => 'required | max: 80',
        'email' => 'required|email',
        'password'	=> 'required|confirmed',
		'password_confirmation' => 'required',

    ];
}