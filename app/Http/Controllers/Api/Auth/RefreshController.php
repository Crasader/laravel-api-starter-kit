<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\JWTAuth;

class RefreshController extends Controller
{
    /**
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(JWTAuth $JWTAuth)
    {
        $JWTAuth->getToken();
        $token = $JWTAuth->refresh();
        
        return response()->json([
            'status'     => 'success',
            'token'      => $token,
            'expires_in' => $JWTAuth->factory()
                                    ->getTTL() * 60
        ]);
    }
}
