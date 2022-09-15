<?php

Route::group(['namespace' => 'Botble\Documents\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'documents', 'as' => 'documents.'], function () {
            Route::resource('', 'DocumentsController')->parameters(['' => 'documents']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'DocumentsController@deletes',
                'permission' => 'documents.destroy',
            ]);
        });
    });

});
