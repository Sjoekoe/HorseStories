<?php

Route::post('albums/{album}/add-picture', ['as' => 'album.picture.create', 'uses' => 'PictureController@create', 'middleware' => 'auth']);
Route::get('albums/{album}/remove-picture/{picture}', ['as' => 'album.picture.delete', 'uses' => 'PictureController@delete', 'middleware' => 'auth']);