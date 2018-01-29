<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    use ApiResponseTrait, AuthenticatesUsers;
    
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth      $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only([
            'email',
            'password'
        ]);
        
        try {
            
            if (!$token = $JWTAuth->attempt($credentials)) {
                
                // To many login attempts error
                if ($this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);
                    
                    return $this->responseWithError(trans('auth.throttle'), 401);
                }
                
                // If the login attempt was unsuccessful we will increment the number of attempts
                $this->incrementLoginAttempts($request);
                
                return $this->responseWithError(trans('auth.failed'), 401);
                
            }
            
        } catch (JWTException $e) {
            
            throw new HttpException(500);
            
        }
        
        return response()->json([
            'status'     => 'success',
            'token'      => $token,
            'expires_in' => $JWTAuth->factory()
                                    ->getTTL() * 60
        ]);
    }
}
