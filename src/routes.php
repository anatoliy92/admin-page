<?php

/**
 * Route for news module
 */

Route::group(['namespace' => 'Avl\AdminPage\Controllers\Admin', 'middleware' => ['web', 'admin'], 'as' => 'adminpage::'], function () {

		// Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], function () {
		//
		// 	/* маршруты для работы с медиа */
		// 		Route::post('news-images',            'MediaController@newsImages');
		// 		Route::post('news-images/{id}',       'MediaController@imageUpdate');
		// 		Route::post('get-image-content/{id}', 'MediaController@getImageContent');
		// 		Route::post('/deleteMedia/{id}',      'MediaController@deleteMedia');
		// 		Route::get('{id}/media-sortable',     'MediaController@mediaSortable');
		// 		Route::post('/change-file-lang/{id}', 'MediaController@changeFileLang');
		// 	/* маршруты для работы с медиа */
		// });

		Route::resource('sections/{id}/page', 'PageController', ['as' => 'sections']);
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localizationRedirect']], function() {
	Route::group(['namespace' => 'Avl\AdminPage\Controllers\Site'], function() {
		Route::get('page/{alias}', 'PageController@index');
	});
});
