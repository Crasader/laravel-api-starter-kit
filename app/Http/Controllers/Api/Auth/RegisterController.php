<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param JWTAuth         $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request, JWTAuth $JWTAuth)
    {
        $userRepository = new UserRepository();
        
        // Are we able to create the user?
        if (!$user = $userRepository->create($request->all())) {
            throw new HttpException(500);
        }
        
        // Create token for the user
        $token = $JWTAuth->fromUser($user);
        
        return $this->response([
            'status'     => 'success',
            'token'      => $token,
            'expires_in' => $JWTAuth->factory()
                                    ->getTTL() * 60
        ], 201);
    }
}
