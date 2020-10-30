<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAll(){

        return response()->json("Deu certo", Response::HTTP_OK);

    }

    //
}
