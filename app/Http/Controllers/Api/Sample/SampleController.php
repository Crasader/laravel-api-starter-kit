<?php

namespace App\Http\Controllers\Api\Sample;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');  // Put middleware in route if needed.
    }
    
    public function me()
    {
        return $this->response([
            'status' => 'success',
            'user'   => Auth::user()
        ]);
    }
}
