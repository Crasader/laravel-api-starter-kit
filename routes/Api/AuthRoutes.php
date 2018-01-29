<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {
    
    Route::post('login')
         ->uses('LoginController@login')
         ->name('auth.login');
    
    Route::post('register')
         ->uses('RegisterController@register')
         ->name('auth.register');
});