<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\http\Request;

interface UserRepositoryInterface
{
    public function __construct(User $user);
    public function getAll();
    public function get($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
    public function me();
    public function login(Request $request);
    public function logout();
    public function refresh();
 }
