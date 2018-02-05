<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {
    
    Route::post('register')
         ->uses('RegisterController@register')
         ->name('auth.register');
    
    Route::post('login')
         ->uses('LoginController@login')
         ->name('auth.login');
    
    Route::post('recover')
         ->uses('ForgotPasswordController@sendResetEmail')
         ->name('auth.recover');
    
    Route::post('reset')
         ->uses('ResetPasswordController@resetPassword')
         ->name('auth.reset');
    
});