<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerExtraController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\ReportController;

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
    return view('welcome');
});

// Route::get('/admin/receipt', function () {
//     return view('admin.receipt');
// });
// Route::get('../public/template_admin/material-dashboard.css', function() {
//     return View::response('css', ['backgroundColor' => '#fff'])->header('Content-Type', 'text/css')->name('css');
// });
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin',                    [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/company-info',       [AdminController::class, 'show_company_info'])->name('company-info');
    Route::get('/admin/profile-info',       [AdminController::class, 'show_profile_info'])->name('profile-info');
    Route::get('/admin/customer',           [CustomerController::class, 'index']);
    Route::post('/admin/save_customer',     [CustomerController::class, 'store'])->name('save_customer');
    Route::post('/admin/edit_customer',     [CustomerController::class, 'edit_customer'])->name('edit_customer');
    Route::post('/admin/save_address_customer',     [CustomerController::class, 'store_address'])->name('save_address_customer');
    Route::post('/admin/delete_customer',   [CustomerController::class, 'destroy'])->name('delete_customer');
    Route::post('/show_contact_person/',    [CustomerController::class,'show_contact_person'])->name('show_contact_person');
    Route::post('/admin/find_company_byId/',[CustomerController::class, 'find_company_byId'])->name('find_company_byId');
    Route::post('/show_customer/',          [CustomerController::class,'show_customer'])->name('show_customer');

    Route::get('/admin/supplier',           [SupplierController::class, 'index']);
    Route::post('/admin/save_supplier',     [SupplierController::class, 'store'])->name('save_supplier');
    Route::post('/admin/delete_supplier',   [SupplierController::class, 'destroy'])->name('delete_supplier');

    Route::get('/admin/courier',            [CourierController::class, 'index']);
    Route::post('/admin/save_courier',      [CourierController::class, 'store'])->name('save_courier');
    Route::post('/admin/delete_courier',    [CourierController::class, 'destroy'])->name('delete_courier');

    Route::get('/admin/product',            [ProductController::class, 'index']);
    Route::post('/admin/save_product',      [ProductController::class, 'store'])->name('save_product');
    Route::post('/admin/update_product',    [ProductController::class, 'update'])->name('update_product');
    Route::post('/admin/delete_product',    [ProductController::class, 'destroy'])->name('delete_product');
    Route::post('/admin/find_product_byId/',[ProductController::class, 'find_product_byId'])->name('find_product_byId');

    Route::get('/admin/create_order',       [OrderController::class, 'create_order']);
    Route::post('/admin/show_product',      [OrderController::class, 'show_product'])->name('show_product');
    Route::post('/admin/save_order',        [OrderController::class, 'store'])->name('save_order');
    Route::get('/admin/list_orders',        [OrderController::class, 'list_orders'])->name('list_orders');
    Route::post('/admin/find_order_byId',   [OrderController::class, 'find_byId'])->name('find_order_byId');
    Route::post('/admin/delete_order',      [OrderController::class, 'destroy'])->name('delete_order');
    Route::post('/admin/update_date',       [OrderController::class, 'update_date'])->name('update_date');
    Route::post('/admin/process_order',     [OrderController::class, 'process_order'])->name('process_order');
    Route::get('/admin/receipt/{id}',       [OrderController::class, 'show_receipt'])->name('show_receipt');
    Route::get('/admin/surat_jalan/{id}',   [OrderController::class, 'show_suratjalan'])->name('show_suratjalan');

    Route::get('/admin/report',             [ReportController::class, 'index']);

    Route::get('/admin/create_po',          [OrderController::class, 'create_po']);
    Route::get('/admin/list_po',            [OrderController::class, 'list_po']);

    Route::post('/admin/get_data_order',     [ReportController::class, 'get_data_order'])->name('get_data_order');
});

Route::get('/', function () {
    if (Auth::check()) {
        //if have dashboard goes to dashboard
        return redirect()->route('admin');
    } else {
        return redirect()->route('login');
    }
});
      
Route::group(['prefix' => 'order', 'middleware' => 'auth'], function () {
    //Add Form
    Route::get('/', 'OrderController@create_order')
            ->name('create_order')
            ->middleware('can:add-order');
    //Add
    Route::post('/', 'OrderController@list_orders')
            ->name('list_orders')
            ->middleware('can:browser-order');
    //List
    Route::get('/list', 'OrderController@create_po')
        ->name('create_po')
        ->middleware('can:add-po');
    //Edit
    Route::post('/edit/', 'OrderController@list_po')
            ->name('list_po')
            ->middleware('can:browser-po');
}); 