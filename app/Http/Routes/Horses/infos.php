<?php

Route::get('horses/{horse_slug}/info', ['as' => 'horse.info', 'uses' => 'InfoController@index']);
