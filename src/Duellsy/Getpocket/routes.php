<?php


Route::get('pocket/connect', 'PocketController@connect');
Route::get('pocket/receiveToken', 'PocketController@receiveToken');
Route::get('pocket/return', 'PocketController@return');
