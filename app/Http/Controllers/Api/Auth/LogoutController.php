<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    
    /**
     * Logged out a user session
     *
     * @param JWTAuth $JWTAuth
     * @return mixed
     */
    public function logout(JWTAuth $JWTAuth)
    {
        $token = $JWTAuth->getToken();
        $JWTAuth->invalidate($token);
        
        return $this->responseWithSuccess(trans('auth.logout'));
    }
}
