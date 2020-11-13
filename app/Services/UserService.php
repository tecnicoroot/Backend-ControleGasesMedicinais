<?php
namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Validations\ValidationUser;
use App\Models\Validations\ValidationUserEdit;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Validations\ValidationAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;



class UserService
{
    /**
    * @var \Tymon\JWTAuth\JWTAuth
    */
    protected $jwt;

    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository, JWTAuth $jwt)
    {
        $this->userRepository = $userRepository;
        $this->jwt = $jwt;
    }

    public function getAll(){

        try{
            $users = $this->userRepository->getAll();
            if(count($users) > 0){
                return response()->json($users, Response::HTTP_OK);
            }else{
                return response()->json([], Response::HTTP_OK);
            }
        }catch (QueryException $exception){
            return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function get($id){

        try{
            $user = $this->userRepository->get($id);
            //dd($user);
            if($user != []){
                return response()->json($user, Response::HTTP_OK);
            }else{
                return response()->json( null, Response::HTTP_OK);
            }
        }catch (QueryException $exception){
            return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function store(Request $request){

        $validator = Validator::make(
            $request->all(),
            ValidationUser::RULE_USER
        );
      
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $user = $this->userRepository->store($request);
                return response()->json($user, Response::HTTP_CREATED);
            }catch (QueryException $exception){
                return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }


    }

    public function update($id, Request $request){
        
        $validator = Validator::make(
            $request->all(),
            ValidationUserEdit::RULE_USER
        );
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                                
                $user = $this->userRepository->update($id, $request);
                return response()->json($user, Response::HTTP_OK);
            }catch (QueryException $exception){
                return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function updatePassword($id, Request $request){
        
        $validator = Validator::make(
            $request->all(),
            ValidationUserEdit::RULE_USER
        );
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                                
                $user = $this->userRepository->update($id, $request);
                return response()->json($user, Response::HTTP_OK);
            }catch (QueryException $exception){
                return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id){

        try{
            $user = $this->userRepository->destroy($id);
            return response()->json(null, Response::HTTP_OK);
        }catch (QueryException $exception){
            return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function login(Request $request)
    {          
        
        $validator = Validator::make(
            $request->all(),
            ValidationAuth::RULE_AUTH
        );
        
    if($validator->fails()){
         
        return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
    }else{
        try {
            
            //if (! $token = $this->jwt->guard($request->only('email', 'password'))) {
            if (! $token =  $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }


        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }
    }
        

        return response()->json(compact('token'));
}

     /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();

    }
}
