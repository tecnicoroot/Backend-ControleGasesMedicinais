<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;


class AuthController extends Controller
{

    private $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        //$this->middleware('auth');
    }

    public function getAll(){
       
        return $this->userService->getAll();

    }

    public function get($id){

        return $this->userService->get($id);

    }

    public function store(Request $request){

        return $this->userService->store($request);

    }

    public function update($id, Request $request){
        
        return $this->userService->update($id, $request);

    }

    public function destroy($id){

        return $this->userService->destroy($id);

    }

    public function login(Request $request)
    {
        return $this->userService->login($request);
    }
    public function logout()
    {
        return  $this->userService->logout();
    }
}
