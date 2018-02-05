<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Logged out a user session
     *
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        Auth::guard()
            ->logout();
        
        $request->session()
                ->invalidate();
        
        return $this->responseWithSuccess(trans('auth.logout'));
    }
}
