<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//search
Route::get(Str::slug(trans('main.search')), 'SearchController@byQuery');
Route::get('typeahead/{query}', array('uses' => 'SearchController@typeAhead', 'as'   => 'typeahead'));
Route::get('typeahead-actor/{query}', array('uses' => 'SearchController@castTypeAhead', 'as'   => 'typeahead-cast'));

//homepage and footer
Route::get('/', array('uses' => 'HomeController@index', 'as' => 'home'));
Route::get(Str::slug(trans('main.privacyUrl')), array('uses' => 'HomeController@privacy', 'as' => 'privacy'));
Route::get(Str::slug(trans('main.tosUrl')), array('uses' => 'HomeController@tos', 'as' => 'tos'));
Route::get(Str::slug(trans('main.contactUrl')), array('uses' => 'HomeController@contact', 'as' => 'contact'));
Route::post(Str::slug(trans('main.contactUrl')), array('uses' => 'HomeController@submitContact', 'as' => 'submit.contact'));

//news 
Route::resource(Str::slug(trans('main.news')), 'NewsController');
Route::post('news/external', array('uses' => 'NewsController@updateFromExternal', 'as' => 'news.ext'));

//movies/series 
Route::resource(Str::slug(trans('main.series')), 'SeriesController');
Route::resource(Str::slug(trans('main.movies')), 'MoviesController');

//edit cast
Route::get(Str::slug(trans('main.movies')) . '/{id}/edit-cast', 'TitleController@editCast');
Route::get(Str::slug(trans('main.series')) . '/{id}/edit-cast', 'TitleController@editCast');

//edit images
Route::get(Str::slug(trans('main.movies')) . '/{id}/edit-images', 'TitleController@editImages');
Route::get(Str::slug(trans('main.series')) . '/{id}/edit-images', 'TitleController@editImages');

//seasons/episodes
Route::resource(Str::slug(trans('main.series')) . '.seasons', 'SeriesSeasonsController', array('except' => array('index', 'edit')));
Route::resource(Str::slug(trans('main.series')) . '/{seriesid}/seasons/{seasonid}/episodes', 'SeasonsEpisodesController');

//reviews
Route::resource(Str::slug(trans('main.series')) . '.reviews', 'ReviewController', array('only' => array('store', 'destroy')));
Route::resource(Str::slug(trans('main.movies')) . '.reviews', 'ReviewController', array('only' => array('store', 'destroy')));
Route::post(Str::slug(trans('main.series')) . '/{title}/reviews', 'ReviewController@store');
Route::post(Str::slug(trans('main.movies')) . '/{title}/reviews', 'ReviewController@store');

//people
Route::resource(Str::slug(trans('main.people')), 'ActorController');
Route::get('people/{id}/edit-filmography', array('uses' => 'ActorController@editFilmo', 'as' => 'people.editFilmo'));
Route::post('people/unlink', array('uses' => 'ActorController@unlinkTitle', 'as' => 'people.unlink'));
Route::post('people/knownFor', array('uses' => 'ActorController@knownFor', 'as' => 'people.knownFor'));

//users
Route::resource(Str::slug(trans('main.users')), 'UserController', array('except' => array('index')));
Route::get(Str::slug(trans('main.users')) . '/{id}/favorites', array('uses' => 'UserController@showFavorites', 'as' => 'favorites'));
Route::get(Str::slug(trans('main.users')) . '/{id}/reviews', array('uses' => 'UserController@showReviews', 'as' => 'reviews'));
Route::get(Str::slug(trans('main.users')) . '/{id}/settings', array('uses' => 'UserController@edit', 'as' => 'settings'));
Route::get(Str::slug(trans('main.users')) . '/{id}/friends', array('uses' => 'UserController@showFriends', 'as' => 'friends'));
Route::post(Str::slug(trans('main.users')) . '/makeMini', array('uses' => 'UserController@miniProfile', 'as' => 'users.mini-profile'));
Route::get(Str::slug(trans('main.users')) . '/{username}/ban','UserController@ban');
Route::get(Str::slug(trans('main.users')) . '/{username}/unban', 'UserController@unban');
Route::get(Str::slug(trans('main.users')) . '/{username}/suspend', 'UserController@suspend');
Route::post(Str::slug(trans('main.users')) . '/{username}/assignGroup', 'UserController@assignToGroup');
Route::get(Str::slug(trans('main.users')) . '/{username}/change-password', array('uses' => 'UserController@changePassword', 'as' => 'changePass'));
Route::post(Str::slug(trans('main.users')) . '/{username}/change-password', array('uses' => 'UserController@storeNewPass', 'as' => 'users.storeNewPass'));
Route::post(Str::slug(trans('main.users')) . '/{username}/avatar', array('uses' => 'UserController@avatar', 'as' => 'users.avatar'));
Route::post(Str::slug(trans('main.users')) . '/{username}/bg', array('uses' => 'UserController@background', 'as' => 'users.bg'));
Route::get('UserController@search', 'UserController@search');

//login/logout 
Route::get(Str::slug(trans('main.login')), 'SessionController@create');
Route::get(Str::slug(trans('main.logout')), 'SessionController@logOut');
Route::get(Str::slug(trans('main.register')), 'UserController@create');
Route::resource('sessions', 'SessionController');
Route::get('forgot-password', 'UserController@requestPassReset');
Route::post('forgot-password', 'UserController@sendPasswordReset');
Route::get('reset-password/{code}', 'UserController@resetPassword');
Route::get('activate/{id}/{code}', 'UserController@activate');


//dashboard
Route::controller('dashboard', 'DashboardController');

//lists(watchlist/favorites)
Route::controller('lists', 'ListsController');


//installation
Route::group(array('prefix' => 'install', 'before' => 'installed'), function()
{
    Route::get('/', 'InstallController@install');
    Route::post('create-schema',
    	array('uses' => 'InstallController@createSchema', 'as' => 'install.schema'));

    Route::get('create-admin', 'InstallController@createAdmin');
    Route::post('store-admin',
    	array('uses' => 'InstallController@storeAdmin', 'as' => 'install.admin'));

    Route::get('create-data', 'InstallController@createData');
    Route::post('store-data',
    	array('uses' => 'InstallController@storeData', 'as' => 'install.data'));
});

//updates
Route::get('update', 'UpdateController@update');
Route::post('update-schema',array('uses' => 'UpdateController@updateSchema', 'as' => 'update.schema'));

//internal
Route::group(array('prefix' => 'private'), function()
{
    Route::post('add-cast', 'TitleController@storeCast');
    Route::post('destroy-relation', 'TitleController@destroyCast');
    Route::post('edit-cast', 'TitleController@editCastInfo');
    Route::post('attach-image', 'TitleController@attachImage');
    Route::post('detach-image', 'TitleController@detachImage');
    Route::post('upload-image', 'TitleController@uploadImage');
    Route::post('update-reviews', 'TitleController@updateReviews');
    Route::post('scrape-fully', array('uses' => 'TitleController@scrapeFully', 'as' => 'titles.scrapeFully'));
    Route::post('update-playing', array('uses' => 'TitleController@updatePlaying', 'as' => 'titles.updatePlaying'));
});

//groups
Route::get('GroupController@clear', array('before' => 'is.admin','uses' => 'GroupController@clear'));
Route::resource('groups', 'GroupController', array('only' => array('store', 'destroy')));

Route::get('social/{provider?}', array("as" => "hybridauth", 'uses' => 'SessionController@social'));
Route::post('social/twitter/email', 'SessionController@twitterEmail');


Route::post('/links/report',        'LinkController@report');
Route::get('/links/detail/{id}',    'LinkController@getDetail');

Route::group(array('before' => 'logged_in'), function() {
    // Links
    Route::post('/links/add',               'LinkController@add');
    Route::get('/getCaptcha',               'CaptchaController@getCaptcha');

    // Friends
    Route::get('/users/friends/delete/{id}',    'FriendshipController@delete');
    Route::get('/users/friends/send/{id}',      'FriendshipController@send');
    Route::get('/users/friends/accept/{id}',    'FriendshipController@accept');
    Route::get('/users/friends/deny/{id}',      'FriendshipController@deny');
});


