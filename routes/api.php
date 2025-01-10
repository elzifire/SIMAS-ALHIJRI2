<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
 

//modul posts 
Route::get('/post', [App\Http\Controllers\Api\PostController::class, 'index']);
Route::get('/post/{id?}', [App\Http\Controllers\Api\PostController::class, 'show']);
Route::get('/homepage/post', [App\Http\Controllers\Api\PostController::class, 'PostHomePage']);
Route::get('/post/category/{slug?}', [App\Http\Controllers\Api\PostController::class, 'PostCategory']);


//modul events
Route::get('/event', [App\Http\Controllers\Api\EventController::class, 'index']);
Route::get('/event/{slug?}', [App\Http\Controllers\Api\EventController::class, 'show']);
Route::get('/homepage/event', [App\Http\Controllers\Api\EventController::class, 'EventHomePage']);

//slider
Route::get('/slider', [App\Http\Controllers\Api\SliderController::class, 'index']);

//tags
Route::get('/tag', [App\Http\Controllers\Api\TagController::class, 'index']);
Route::get('/tag/{slug?}', [App\Http\Controllers\Api\TagController::class, 'show']);

//category
Route::get('/category', [App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::get('/category/{slug?}', [App\Http\Controllers\Api\CategoryController::class, 'show']);

//photo
// Route::get('/photo', [App\Http\Controllers\Api\PhotoController::class, 'index']);
Route::get('/photo', [App\Http\Controllers\Api\PhotoController::class, 'index']);

Route::get('/homepage/photo', [App\Http\Controllers\Api\PhotoController::class, 'PhotoHomepage']);

//video
Route::get('/video', [App\Http\Controllers\Api\VideoController::class, 'index']);
Route::get('/homepage/video', [App\Http\Controllers\Api\VideoController::class, 'VideoHomepage']);

//money
Route::get('/homepage/money', [\App\Http\Controllers\Api\MoneyController::class, 'MoneyHomePage']);
Route::get('/grapik', [\App\Http\Controllers\Api\MoneyController::class, 'grapik']);

// muadzin
Route::get('/muadzin', [App\Http\Controllers\Api\MuadzinController::class, 'index']);
Route::get('/homepage/muadzin', [App\Http\Controllers\Api\MuadzinController::class, 'MuadzinHomePage']);

// leader
Route::get('/leader', [App\Http\Controllers\Api\LeaderController::class, 'index']);
Route::get('/homepage/leader', [App\Http\Controllers\Api\LeaderController::class, 'LeaderHomePage']);

// management
Route::get('/management', [App\Http\Controllers\Api\ManagementController::class, 'index']);
Route::get('/homepage/management', [App\Http\Controllers\Api\ManagementController::class, 'LeaderHomePage']);

// visi
Route::get('/visi', [\App\Http\Controllers\Api\VisiContoller::class, 'index']);

// route for contact
Route::get('contact', [App\Http\Controllers\Api\ContactController::class, 'index']);

// route for service
Route::get('service', [App\Http\Controllers\Api\ServiceController::class, 'index']);

// mualaf
Route::post('mualaf', [App\Http\Controllers\Api\MualafController::class, 'store']);