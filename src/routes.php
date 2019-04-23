<?php

/**
 * Route for news module
 */

Route::group(['namespace' => 'Avl\AdminPage\Controllers\Admin', 'middleware' => ['web', 'admin'], 'as' => 'adminpage::'], function () {

		Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], function () {
			/* маршруты для работы с медиа */
				Route::post('page-images',       'MediaController@pageImages');
				Route::post('page-files',        'MediaController@pageFiles');
			/* маршруты для работы с медиа */
		});

		Route::resource('sections/{id}/page', 'PageController', ['as' => 'sections']);
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localizationRedirect']], function() {
	Route::group(['namespace' => 'Avl\AdminPage\Controllers\Site'], function() {
		Route::get('page/{alias}', 'PageController@index');
	});
});
