<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\BranchController;
use App\Admin\Controllers\CarController;
use App\Admin\Controllers\CardDetailController;
use App\Admin\Controllers\BookingController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->resource('bookings', BookingController::class);
    $router->resource('branches', BranchController::class);

    $router->resource('car', CarController::class);
    $router->resource('card-details', CardDetailController::class);
    $router->get('/', function () {
        return redirect()->route('admin.car.index');
    });
    // $router->get('/', 'HomeController@index')->name('home');

});

