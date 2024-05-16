<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Vision Data
    Route::post('vision-datas/media', 'VisionDataApiController@storeMedia')->name('vision-datas.storeMedia');
    Route::apiResource('vision-datas', 'VisionDataApiController');
});
