<?php

namespace App\Repositories;

use App\Models\Cars;
use Illuminate\http\Request;

interface CarRepositoryInterface
{
    public function __construct(Cars $cars);
    public function getAll();
    public function get($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}
