<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {
    
    Route::post('login')
         ->uses('LoginController@login')
         ->name('auth.login');
});