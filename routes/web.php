<?php
use Illuminate\Support\Facades\Route;

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
/**  webhook */

Auth::routes();

Route::post('/webhook', 'App\Http\Controllers\TelegramBotController@webHook')->name('webHook');
Route::get('/', function () {
    return redirect('/login');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/telegram/users', 'App\Http\Controllers\BotUsersController@users')->name('telegram.users');
Route::post('/telegram/users/filter', 'App\Http\Controllers\BotUsersController@filter')->name('telegram.users.filter');
Route::get('/telegram/video/get/{id}', 'App\Http\Controllers\VideosController@getVideo')->name('telegram.video.get');



Route::get('/admin/users', 'App\Http\Controllers\AdminController@users')->name('admin.users');
Route::get('/admin/created', 'App\Http\Controllers\VideosController@getVideo')->name('admin.created');




Route::get('/telegram/roles', 'App\Http\Controllers\BotUsersController@roles')->name('telegram.roles');
Route::get('/videos', 'App\Http\Controllers\VideosController@videos')->name('videos.all');
Route::get('/stats', 'App\Http\Controllers\HomeController@stats')->name('main.stats');
Route::post('/telegram/roles/edit', 'App\Http\Controllers\ApiController@editRole')->name('role.edit');
Route::post('/telegram/roles/remove', 'App\Http\Controllers\ApiController@removeRole')->name('role.remove');
Route::post('/telegram/video/status', 'App\Http\Controllers\VideosController@status')->name('video.status');
Route::post('/telegram/video/remove', 'App\Http\Controllers\VideosController@remove')->name('video.remove');
Route::post('/telegram/users/status', 'App\Http\Controllers\BotUsersController@status')->name('users.status');
