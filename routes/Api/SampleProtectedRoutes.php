<?php

Route::group([
    'prefix'    => 'sample',
    'namespace' => 'Sample'
], function () {
    
    Route::get('me')
         ->uses('SampleController@me')
         ->name('sample.me');
    
});