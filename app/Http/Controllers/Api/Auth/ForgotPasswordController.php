<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ForgotPasswordController extends Controller
{
    /**
     * Send password reset link to email
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetEmail(ForgotPasswordRequest $request)
    {
        $userRepository = new UserRepository();
        
        if (!$user = $userRepository->findByColumnsFirst([
            'email' => $request->get('email')
        ])) {
            return $this->responseNotFound();
        }
        
        $broker          = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink($request->only('email'));
        
        if ($sendingResponse !== Password::RESET_LINK_SENT) {
            throw new HttpException(500);
        }
        
        return $this->responseWithSuccess('Email confirmation has been sent.');
    }
    
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function getPasswordBroker()
    {
        return Password::broker();
    }
}
