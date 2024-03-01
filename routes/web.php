<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MoneyController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\MuadzinController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ContactController;


Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'ShowLoginForm']);

Auth::routes(['register' => false]);

Route::prefix('admin')->group(function () {

    Route::group(['middleware' => 'auth'], function(){

        //dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');

        //permissions
        Route::resource('/permission', \App\Http\Controllers\Admin\PermissionController::class, ['except' => ['show', 'create', 'edit', 'update', 'delete'] ,'as' => 'admin']);

        //roles
        Route::resource('/role', \App\Http\Controllers\Admin\RoleController::class, ['except' => ['show'] ,'as' => 'admin']);

        //users
        Route::resource('/user', \App\Http\Controllers\Admin\UserController::class, ['except' => ['show'] ,'as' => 'admin']);

        //tags
        Route::resource('/tag', \App\Http\Controllers\Admin\TagController::class, ['except' => 'show' ,'as' => 'admin']);

        //categories
        Route::resource('/category', \App\Http\Controllers\Admin\CategoryController::class, ['except' => 'show' ,'as' => 'admin']);

        //posts
        Route::resource('/post', \App\Http\Controllers\Admin\PostController::class, ['except' => 'show' ,'as' => 'admin']);

        //event
        Route::resource('/event', \App\Http\Controllers\Admin\EventController::class, ['except' => 'show' ,'as' => 'admin']);

        //leaders 
        Route::resource('/leader', \App\Http\Controllers\Admin\LeaderController::class, ['except' => 'show' ,'as' => 'admin']);

        //photo
        Route::resource('/photo', \App\Http\Controllers\Admin\PhotoController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        
        //video
        Route::resource('/video', \App\Http\Controllers\Admin\VideoController::class, ['except' => 'show' ,'as' => 'admin']);
    
        //slider
        Route::resource('/slider', \App\Http\Controllers\Admin\SliderController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);

        // money
        Route::resource('/money', \App\Http\Controllers\Admin\MoneyController::class, ['except' => 'show', 'as' => 'admin']);
        
        //muadzin 
        Route::resource('/muadzin', \App\Http\Controllers\Admin\MuadzinController::class, ['except' => 'show', 'as' => 'admin']);
        
        //management
        Route::resource('/management', \App\Http\Controllers\Admin\ManagementController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        
        // contact
        Route::resource('/contact', \App\Http\Controllers\Admin\ContactController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        
    });

});