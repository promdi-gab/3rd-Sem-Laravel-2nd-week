<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
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

Route::get('/album','AlbumController@index');

Route::get('/album/create','AlbumController@create')->name('album.create'); // option1

Route::post('/album/store',['uses' => 'AlbumController@store','as' => 'album.store']); //option2
Route::get('/album/edit/{id}','AlbumController@edit')->name('album.edit');

Route::post('/album/update{id}',['uses' => 'AlbumController@update','as' => 'album.update']); 

Route::get('/album/delete/{id}',['uses' => 'AlbumController@delete','as' => 'album.delete']);

Route::resource('customer', 'CustomerController');

//Route::resource("customer", CustomerController::class); //this

Route::get('/customer/restore/{id}',['uses' => 'CustomerController@restore','as' => 'customer.restore']);

Route::get("/customer/forceDelete/{id}", ["uses" => "CustomerController@forceDelete", "as" => "customer.forceDelete",]);

// default id 
//Kasi nga yung CRUD OR Resource AY IISA pinagsamang CREATE SHOW/READ UPDATE DELETE yan kaya no need na siya tawagin
//kaya nakahiwalay yung restore at forceDelete kasi di kasama yan sa CRUD 

Route::resource('customer', 'CustomerController');
Route::resource('album', 'AlbumController');
Route::resource('artist', 'ArtistController');
Route::resource('listener', 'ListenerController');

