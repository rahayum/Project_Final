<?php
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\PelangganController;
use App\Http\Controllers\admin\PemesananController;
use App\Http\Controllers\admin\PembayaranController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

//group route untuk admin
Route::prefix('admin')->group(function(){
    //route untuk auth
    Route::group(['middleware' => 'auth'], function(){
            // buat route untuk dashboard
            Route::get('/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard.index');
            // buat route untuk data Pelanggan
            Route::resource('/Pelanggan', PelangganController::class, ['as' => 'admin']);
            // buat route untuk menu Pemesanan
            Route::resource('/Pemesanan', PemesananController::class, ['as' => 'admin']);
             // buat route untuk menu Pembayaran
             Route::resource('/Pembayaran', PembayaranController::class, ['as' => 'admin']);
            //route untuk menu data barang
            Route::resource('/barang', BarangController::class, ['as' => 'admin']);
            


    });
});