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
//testing bat dito id lang         anung id ayan id hindi sya customer_id ganun sira HAHAHAHHAHAHAHGHAHAHAHHAHAHAHAHAHHAHAHA HAHTHAABHAEHAHAAbtasdahsd
//yawa ka syempre HAHAHAAHHAHAH kasi default id tawag pag url boset ka ag GASGASGGASG malamang lalagay mo sa url customer_id boset ka HAHAHHAHA
//default yan a nakhah dhefault na yan bawal palitan baket di nakalagay dito si ano customer/edit ganun hay nako 
//Kasi nga yung CRUD OR Resource AY IISA pinagsamang CREATE SHOW/READ UPDATE DELETE yan kaya no need na siya tawagin ahhh okokk
//kaya nakahiwalay yung restore at forceDelete kasi di naman kasama yan sa CRUD duh getsfgets anu pa tanongwaka naa sure wala na?uu HASHAHSHA ill
//just leave some notes ay save mo ay nvm notes muna ako then save github^^