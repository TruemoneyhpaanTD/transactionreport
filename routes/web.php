<?php
use Illuminate\Http\Request;
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
    return redirect('login');
});

Route::get('login','LoginController@showLogin');
Route::post('login','LoginController@authenticate');
Route::post('logout', 'LoginController@logout');

// Route::get('/dashboard', 'HomeController@index');
// Route::get('/transaction', 'HomeController@transaction');
// Route::get('/dashboard_trans', 'HomeController@dashboard_trans');

// Show all agents
Route::get('/agent','AgentController@index');
Route::get('/transaction', 'AgentController@transaction');

// Route::get('/dashboard', 'TestController@index');
// Route::get('/transaction', 'TestController@transaction');

// Route::get('/agent/{export_excel}','AgentController@exportExcel');
// Route::get('/dashboard/{export_excel}','TestController@exportExcel');


// Route::get('/dashboard', 'HomeController@index');
// Route::get('/transaction', 'HomeController@transaction');
// Show Profile
Route::get('profile','ProfileController@getprofile');

//Transaction Chart
Route::get('chart','ChartController@index');

//Show Epin for CallCenter
Route::get('epin','EpinController@index');


