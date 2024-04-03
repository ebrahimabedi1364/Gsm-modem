<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\SMSController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\RoleController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\DataLoggerController;
use App\Http\Controllers\Panel\PermissionController;
use App\Http\Controllers\Panel\ModemSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::namespace('Auth')->group(function () {


    Route::get('/', [LoginController::class, 'loginForm'])->name('auth.login');
    Route::post('/post-login', [LoginController::class, 'postLogin'])->name('auth.login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');


});

Route::prefix('panel')->namespace('Panel')->group(function () {
    Route::get('/', [HomeController::class , 'index'])->name('app.index');

    Route::get('/update', [HomeController::class , 'update'])->name('app.update');

    //dataLogger
    Route::prefix('dataLogger')->group(function () {

        Route::get('/', [DataLoggerController::class , 'index'])->name('app.data-logger.index');
        Route::get('/create', [DataLoggerController::class, 'create'])->name('app.data-logger.create');
        Route::post('/store', [DataLoggerController::class, 'store'])->name('app.data-logger.store');
        Route::get('/edit/{device}', [DataLoggerController::class, 'edit'])->name('app.data-logger.edit');
        Route::put('/update/{device}', [DataLoggerController::class, 'update'])->name('app.data-logger.update');
        Route::delete('/destroy/{device}', [DataLoggerController::class, 'destroy'])->name('app.data-logger.destroy');
        Route::get('/status/{device}', [DataLoggerController::class, 'status'])->name('app.data-logger.status');
        

    });
    Route::prefix('messages')->group(function () {

        Route::get('/send-box', [SMSController::class , 'sendBox'])->name('app.Message.send-box');
        Route::get('/recieve-box', [SMSController::class , 'recieveBox'])->name('app.Message.recieve-box');
        Route::get('/send-message', [SMSController::class, 'sendMessage'])->name('admin.Message.send-message');
        Route::get('/delete-message', [SMSController::class, 'deleteMessage'])->name('admin.Message.delete-message');

    });

    

    Route::prefix('modem-setting')->group(function () {

        Route::get('/', [ModemSettingController::class , 'index'])->name('app.setting.index');
        Route::get('/edit/{setting}', [ModemSettingController::class, 'edit'])->name('admin.setting.edit');
        Route::get('/update/{setting}', [ModemSettingController::class, 'update'])->name('admin.setting.update');

    });

    Route::prefix('user')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('app.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('app.user.create');
        Route::post('/store', [UserController::class, 'store'])->name('app.user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('app.user.edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('app.user.update');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('app.user.destroy');
        Route::get('/status/{user}', [UserController::class, 'status'])->name('app.user.status');
        Route::get('/activation/{user}', [UserController::class, 'activation'])->name('app.user.activation');
        Route::get('/reset-password/{user}', [UserController::class, 'resetPassword'])->name('app.user.reset-password');
        Route::put('/reset-password/{user}/post', [UserController::class, 'postResetPassword'])->name('app.user.reset-password.post');
        // Route::get('/roles/{admin}', [UserController::class, 'roles'])->name('admin.user.admin-user.roles');
        // Route::post('/roles/{admin}/store', [UserController::class, 'rolesStore'])->name('admin.user.admin-user.roles.store');
        // Route::get('/permissions/{admin}', [UserController::class, 'permissions'])->name('admin.user.admin-user.permissions');
        // Route::post('/permissions/{admin}/store', [UserController::class, 'permissionStore'])->name('admin.user.admin-user.permission.store');

    });

    //role
    // Route::prefix('role')->group(function () {

    //     Route::get('/', [RoleController::class, 'index'])->name('admin.user.role.index');
    //     Route::get('/create', [RoleController::class, 'create'])->name('admin.user.role.create');
    //     Route::post('/store', [RoleController::class, 'store'])->name('admin.user.role.store');
    //     Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('admin.user.role.edit');
    //     Route::put('/update/{role}', [RoleController::class, 'update'])->name('admin.user.role.update');
    //     Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('admin.user.role.destroy');
    //     Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('admin.user.role.permission-form');
    //     Route::post('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('admin.user.role.permission-update');
    // });

    //permission
    // Route::prefix('permission')->group(function () {

    //     Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index');
    //     Route::get('/create', [PermissionController::class, 'create'])->name('admin.user.permission.create');
    //     Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store');
    //     Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit');
    //     Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('admin.user.permission.update');
    //     Route::delete('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy');
    // });



});

// Route::get('/', function () {
//     return view('welcome');
// });
