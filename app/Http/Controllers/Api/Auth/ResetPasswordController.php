<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request, JWTAuth $JWTAuth)
    {
        $userRepository = new UserRepository();
        
        $response = $this->broker()
                         ->reset(
                             $this->credentials($request), function ($user, $password) {
                             $this->reset($user, $password);
                         }
                         );
        
        if ($response !== Password::PASSWORD_RESET) {
            throw new HttpException(500);
        }
        
        // Grab the user
        $user = $userRepository->findByColumnsFirst(['email' => $request->get('email')]);
        
        return $this->response([
            'status' => 'success',
            'token'  => $JWTAuth->fromUser($user)
        ]);
    }
    
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
    
    /**
     * Get the password reset credentials from the request.
     *
     * @param  ResetPasswordRequest $request
     * @return array
     */
    protected function credentials(ResetPasswordRequest $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
    
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string                                      $password
     * @return void
     */
    protected function reset($user, $password)
    {
        $user->password = $password;
        $user->setRememberToken(Str::random(60));
        $user->save();
    }
}
