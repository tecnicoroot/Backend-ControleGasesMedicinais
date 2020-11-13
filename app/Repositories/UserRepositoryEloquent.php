<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\http\Request;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    private $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function get($id)
    {
        return $this->model->find($id);
    }

    public function store(Request $request)
    {
        return $this->model->create($request->all());
    }

    public function update($id, Request $request)
    {  
        return $this->model->find($id)->update($request->all());
    }
    public function updatePassword($id, Request $request)
    {  
        return $this->model->find($id)->update($request->all());
    }

    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }

    public function me()
    {
        return $this->model->me();
    }

    public function login(Request $request)
    {
        return $this->model->login($request);
    }

    public function logout()
    {
        return $this->model->logout();
    }

    public function refresh()
    {
        return $this->model->refresh();
    }
}