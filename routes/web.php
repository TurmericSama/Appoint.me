<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect( "/login" );
});

Route::get('/dash', 'PagesController@Dash' );
Route::get('/appointments', 'PagesController@Events');
Route::get('/user','PagesController@User');
Route::get('/login', 'PagesController@Login');
Route::post('/login', 'PagesController@LoginPost');
Route::get('/appointments/add', 'PagesController@Add');

Route::get('/signup', 'PagesController@SignUp');
Route::post( "/signup", "PagesController@SignUpPost" );

Route::get('/logout', 'PagesController@Logout');