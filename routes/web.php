<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\LocalesController;
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
    return view('index');
});
/**
 * locales result
 */
Route::get('/locales', function (Request $request, LocalesController $controller) {
    if (!$request->ajax()) {
        throw new Exception(trans('default.Cannot load locales'));
    }

    return $controller->fetch($request);
})->name('locales');

Route::resource('user', "\App\Http\Controllers\User\UserController", [ 'only' => [ 'update', 'destroy' ] ]);

Route::group(['prefix' => 'user'], function (Router $router) {


    $router->post('register', function (Request $request, UserController $ctrl) {
        return $ctrl->register($request);
    })->name('user.register');

    $router->post('logout', function (Request $request, UserController $ctrl) {
        return $ctrl->logout($request);
    })->name('user.logout');

    $router->post('login', function (Request $request, UserController $ctrl) {
        return $ctrl->login($request);
    })->name('user.login');

    $router->post('check', function (Request $request, UserController $ctrl) {
        return $ctrl->checkAuth($request);
    })->name('user.check');

    $router->post('grid', function (Request $request, UserController $ctrl) {
        return $ctrl->grid($request);
    })->name('user.grid');
});