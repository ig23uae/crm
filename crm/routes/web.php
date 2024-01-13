<?php

use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController1;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Admin\AdminController;

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

//Ссылки админа
//Route::get('/cars', [CarController1::class, 'cars'])->name('cars');
Route::get('/cars/filter', [CarController1::class, 'cars_filter'])->name('cars_filter');
//Route::get('/sales', [CarController1::class, 'sales'])->name('sales');
Route::get('/clients', [CarController1::class, 'clients'])->name('clients');


Route::get('/edit_car', [CarController1::class, 'edit_car'])->name('edit_car');
Route::get('/edit_car/handler', [CarController1::class, 'edit_car_handler'])->name('edit_car_handler');
Route::get('/get-car', [CarController1::class, 'getCar'])->name('getCar');
Route::get('/get-car-models', [CarController1::class, 'getCarModels'])->name('getCarModels');

Route::get('/create_client', [CarController1::class, 'create_client'])->name('create_client');
Route::post('/create_client/client_handler', [CarController1::class, 'client_handler'])->name('client_handler');
Route::post('/add_car/add_handler' , [CarController1::class, 'car_handler'])->name('add_handler');
//Route::get('/create_sale', [CarController1::class, 'create_sale'])->name('create_sale');
Route::post('/create_sale/add' , [CarController1::class, 'sale_handler'])->name('sale_handler');
Route::get('/create_sale/add_handler/GetCarID', [CarController1::class, 'GetCarID'])->name('GetCarID');
//Route::get('sales/edit/{sale_id}', [CarController1::class, 'edit_sale'])->name('edit_sale');
//Route::get('sales/edit/', [CarController1::class, 'edit_sale'])->name('edit_sale');
Route::post('/sales/edit/handler', [CarController1::class, 'edit_sale_handler'])->name('edit_sale_handler');


//Ссылки продавца

//Ссылки клиентов


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['role:admin'])->prefix('admin_panel')->group(function (){
    Route::get('/', [AdminController::class, 'index'])->name('admin_index');
    Route::get('/cars/show/{id}/delete_doc', [CarController::class, 'delete_doc'])->name('delete_doc');
    Route::get('/cars/show/{id}/delete_image', [CarController::class, 'delete_image'])->name('delete_image');
    Route::delete('/cars/delete/{car_id}', [CarController::class, 'destroy'])->name('delete_car');
});
Route::middleware('auth')->group(function () {
    Route::get('/', [CarController::class, 'index'])->name('panel');
    Route::get('/cars/add_car', [CarController::class, 'create'])->name('add_car');
    Route::post('/cars/cars_store', [CarController::class, 'store'])->name('cars_store');
    Route::get('/cars/show/{car_id}', [CarController::class, 'show'])->name('car');
    Route::get('/cars/edit_car/{car_id}', [CarController::class, 'edit'])->name('edit_car');
    Route::patch('/cars/edit_car/{car_id}/update', [CarController::class, 'update'])->name('update_car');
    Route::get('/cars/{status}', [CarController::class, 'index'])->name('cars_index');
    Route::get('sales/create_sale/add_handler/GetCarID', [CarController1::class, 'GetCarID'])->name('GetCarID');
    Route::get('/sales/create/', [SalesController::class, 'create'])->name('create_sale');
    Route::post('/sales/store/', [SalesController::class, 'store'])->name('sale_store');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/clients', [CarController::class, 'clients'])->name('clients');
});
