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
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\MuadzinController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EnterController;
use App\Http\Controllers\Admin\OutController;
use App\Models\Money_keluar;
use App\Models\Money_masuk;
use App\Http\Controllers\Admin\VisiController;





// Route::get('/test', [\App\Http\Controllers\Api\TestController::class, 'index']);


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
        
        Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
        //event
        Route::resource('/event', \App\Http\Controllers\Admin\EventController::class, ['except' => 'show' ,'as' => 'admin']);

        //leaders 
        Route::resource('/leader', \App\Http\Controllers\Admin\LeaderController::class, ['except' => 'show' ,'as' => 'admin']);

        //photo
        Route::resource('/photo', \App\Http\Controllers\Admin\PhotoController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);

        // categories_photo
        Route::resource('/category_photo', \App\Http\Controllers\Admin\CategoriesPhotoController::class, ['except' => 'show' ,'as' => 'admin']);
        
        //video
        Route::resource('/video', \App\Http\Controllers\Admin\VideoController::class, ['except' => 'show' ,'as' => 'admin']);

        // categories_video
        Route::resource('/category_video', \App\Http\Controllers\Admin\CategoryVideoController::class, ['except' => 'show' ,'as' => 'admin']);
    
        //slider
        Route::resource('/slider', \App\Http\Controllers\Admin\SliderController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);

        // money enter
        Route::resource('/enter', \App\Http\Controllers\Admin\EnterController::class, ['except' => 'show', 'as' => 'admin']);

        // money out
        Route::resource('/out',  OutController::class, ['except' => 'show' ,'as' => 'admin']);

        //muadzin 
        Route::resource('/muadzin', \App\Http\Controllers\Admin\MuadzinController::class, ['except' => 'show', 'as' => 'admin']);
        
        //management
        Route::resource('/management', \App\Http\Controllers\Admin\ManagementController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        
        // contact
        Route::resource('/contact', \App\Http\Controllers\Admin\ContactController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        
        // visi dan misi
        Route::resource('/visi', \App\Http\Controllers\Admin\VisiController::class, ['except' => 'show' ,'as' => 'admin']);

        // Service
        Route::resource('/service', \App\Http\Controllers\Admin\ServiceController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);

        // categories_photo
        Route::resource('/categories_photo', \App\Http\Controllers\Admin\CategoriesPhotoController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        

    });

});