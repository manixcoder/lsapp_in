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

Route::get('/home', function () {  
	return view('home');
});
Route::get('/', function () {  
	return view('home');
});
//Auth::routes();
Auth::routes(['verify' => true]);
Route::get('/validate-user', 'HomeController@checkUserRole')->middleware('verified');

Route::get('/terms', 'StaticPageManagement\StaticPageController@siteTerms');
Route::get('/privacy', 'StaticPageManagement\StaticPageController@sitePolicy');

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/profile', 'UserManagement\UserManagementController@profile');

Route::get('/transactions', 'UserManagement\UserManagementController@transactions');
Route::post('/charge', 'UserManagement\UserManagementController@charge');

Route::get('/settings', 'UserManagement\UserManagementController@settings');
Route::get('/my-questions', 'UserManagement\UserManagementController@myQuestions');
Route::get('/question-detail/{id}', 'UserManagement\UserManagementController@questionDetail');
Route::post('/edit-profile', 'UserManagement\UserManagementController@editProfile');


Route::get('/export_excel', 'UserManagement\ExprtExcelController@index');
Route::get('/export_excel/excel', 'UserManagement\ExprtExcelController@excel')->name('export_excel.excel');

Route::get('/get-chat/{id}', 'UserManagement\ChatController@getChat');
Route::post('/sendMessage', 'UserManagement\ChatController@sendMessage');
Route::post('/acceptQuestion', 'UserManagement\ChatController@acceptQuestion');
Route::get('/change-password', 'UserManagement\UserManagementController@changePassword');
Route::post('/savePassword', 'UserManagement\UserManagementController@savePassword');

Route::post('/rateExpert', 'UserManagement\ExpertRatingController@rateExpert');
Route::post('/exportTip', 'UserManagement\ExpertRatingController@exportTip');
Route::post('/mark-as-complete', 'UserManagement\UserManagementController@markAsComplete');

Route::post('/ask_question', 'UserManagement\UserManagementController@askQuestion');
Route::get('/userDecline/{id}', 'UserManagement\UserManagementController@userDecline');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
	Route::get('/', 'UserManagement\UserManagementController@index');
	Route::get('/stripeAccountCreate', 'UserManagement\UserManagementController@stripeAccountCreate');
	Route::get('/payoutRequest', 'Stripe\StripeController@payoutRequest');
	Route::get('/stripeUpdate', 'UserManagement\UserManagementController@stripeUpdate');
	Route::get('/chat/{id}', 'UserManagement\UserManagementController@showMessages');
});

Route::get('/{username}', 'UserManagement\UserProfileController@profile'); 
