<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', function () {
    return view('auth.login');
})->name('admin.login');

//  for admin registration below comment uncomment karvi and above auth.login ne comment karvi
// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();

// Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'usersession']], function () {

    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin');
    Route::get('/profile/{id}', [App\Http\Controllers\AdminController::class, 'profiledit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\AdminController::class, 'profileUpdate'])->name('profile.update');

    Route::get("admin/form", [App\Http\Controllers\AdminSamplesController::class, 'index'])->name('admin.form.index');
    Route::get('admin/form/create', [App\Http\Controllers\AdminSamplesController::class, 'create'])->name('admin.form.create');
    Route::post('admin/form/store', [App\Http\Controllers\AdminSamplesController::class, 'store'])->name('admin.form.store');
    Route::get('admin/flight/edit/{id}', [App\Http\Controllers\AdminSamplesController::class, 'edit'])->name('admin.flight.edit');
    Route::patch('admin/flight/update/{id}', [App\Http\Controllers\AdminSamplesController::class, 'update'])->name('admin.flight.update');
    Route::get('admin/flight/destroy/{id}', [App\Http\Controllers\AdminSamplesController::class, 'destroy'])->name('admin.flight.destroy');

    // Route::get("admin/list", [App\Http\Controllers\AdminController::class, 'index'])->name('admin.list.index');
    // Route::get("admin/list/exportdata/{date}", [App\Http\Controllers\AdminController::class, 'exportData'])->name('admin.list.exportdata');

    Route::get("admin/hotel", [App\Http\Controllers\AdminHotelController::class, 'index'])->name('admin.hotel.index');
    Route::get('admin/hotel/create', [App\Http\Controllers\AdminHotelController::class, 'create'])->name('admin.hotel.create');
    Route::post('admin/hotel/store', [App\Http\Controllers\AdminHotelController::class, 'store'])->name('admin.hotel.store');
    Route::get('admin/hotel/edit/{id}', [App\Http\Controllers\AdminHotelController::class, 'edit'])->name('admin.hotel.edit');
    Route::patch('admin/hotel/update/{id}', [App\Http\Controllers\AdminHotelController::class, 'update'])->name('admin.hotel.update');
    Route::get('admin/hotel/destroy/{id}', [App\Http\Controllers\AdminHotelController::class, 'destroy'])->name('admin.hotel.destroy');


    Route::get("admin/setting", [App\Http\Controllers\AdminSettingController::class, 'index'])->name('admin.setting.index');
    Route::get('admin/setting/create', [App\Http\Controllers\AdminSettingController::class, 'create'])->name('admin.setting.create');
    Route::post('admin/setting/store', [App\Http\Controllers\AdminSettingController::class, 'store'])->name('admin.setting.store');
    Route::get('admin/setting/edit/{id}', [App\Http\Controllers\AdminSettingController::class, 'edit'])->name('admin.setting.edit');
    Route::patch('admin/setting/update/{id}', [App\Http\Controllers\AdminSettingController::class, 'update'])->name('admin.setting.update');
    Route::get('admin/setting/destroy/{id}', [App\Http\Controllers\AdminSettingController::class, 'destroy'])->name('admin.setting.destroy');
    Route::get("admin/hotel/active/{id}", [App\Http\Controllers\AdminSettingController::class, 'hotelActive'])->name('admin.hotel.active');

    // Route::get("admin/one_hotel_list", [App\Http\Controllers\AdminController::class, 'indexOneHotel'])->name('admin.list.onehotel');

    Route::get("admin/category", [App\Http\Controllers\AdminCategoryController::class, 'index'])->name('admin.category.index');
    Route::get('admin/category/create', [App\Http\Controllers\AdminCategoryController::class, 'create'])->name('admin.category.create');
    Route::post('admin/category/store', [App\Http\Controllers\AdminCategoryController::class, 'store'])->name('admin.category.store');
    Route::get('admin/category/edit/{id}', [App\Http\Controllers\AdminCategoryController::class, 'edit'])->name('admin.category.edit');
    Route::patch('admin/category/update/{id}', [App\Http\Controllers\AdminCategoryController::class, 'update'])->name('admin.category.update');
    Route::get('admin/category/destroy/{id}', [App\Http\Controllers\AdminCategoryController::class, 'destroy'])->name('admin.category.destroy');

    Route::get("admin/room", [App\Http\Controllers\AdminRoomController::class, 'index'])->name('admin.room.index');
    Route::get('admin/room/create', [App\Http\Controllers\AdminRoomController::class, 'create'])->name('admin.room.create');
    Route::post('admin/room/store', [App\Http\Controllers\AdminRoomController::class, 'store'])->name('admin.room.store');
    Route::get('admin/room/edit/{id}', [App\Http\Controllers\AdminRoomController::class, 'edit'])->name('admin.room.edit');
    Route::patch('admin/room/update/{id}', [App\Http\Controllers\AdminRoomController::class, 'update'])->name('admin.room.update');
    Route::get('admin/room/destroy/{id}', [App\Http\Controllers\AdminRoomController::class, 'destroy'])->name('admin.room.destroy');

    Route::get("admin/extra", [App\Http\Controllers\AdminExtraServiceController::class, 'index'])->name('admin.extra.index');
    Route::get('admin/extra/create', [App\Http\Controllers\AdminExtraServiceController::class, 'create'])->name('admin.extra.create');
    Route::post('admin/extra/store', [App\Http\Controllers\AdminExtraServiceController::class, 'store'])->name('admin.extra.store');
    Route::get('admin/extra/edit/{id}', [App\Http\Controllers\AdminExtraServiceController::class, 'edit'])->name('admin.extra.edit');
    Route::patch('admin/extra/update/{id}', [App\Http\Controllers\AdminExtraServiceController::class, 'update'])->name('admin.extra.update');
    Route::get('admin/extra/destroy/{id}', [App\Http\Controllers\AdminExtraServiceController::class, 'destroy'])->name('admin.extra.destroy');


    // bill hotel
    Route::get("admin/invoice", [App\Http\Controllers\AdminInvoiceController::class, 'index'])->name('admin.invoice.index');
    Route::get('admin/invoice/create', [App\Http\Controllers\AdminInvoiceController::class, 'create'])->name('admin.invoice.create');
    Route::post('admin/invoice/store', [App\Http\Controllers\AdminInvoiceController::class, 'store'])->name('admin.invoice.store');
    Route::get('admin/invoice/edit/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'edit'])->name('admin.invoice.edit');
    Route::patch('admin/invoice/update/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'update'])->name('admin.invoice.update');
    Route::get('admin/invoice/destroy/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'destroy'])->name('admin.invoice.destroy');

    Route::get('admin/get-detail', [App\Http\Controllers\AdminInvoiceController::class, 'getDetail'])->name('admin.get-hotel-detail');

    Route::get('admin/get-room-detail', [App\Http\Controllers\AdminInvoiceController::class, 'getRoomDetail'])->name('admin.get-room-detail');
    Route::get('admin/get-extra-detail', [App\Http\Controllers\AdminInvoiceController::class, 'getExtraDetail'])->name('admin.get-extra-detail');

    Route::post('admin/invoice/storedata', [App\Http\Controllers\AdminInvoiceController::class, 'storeInvoiceData'])->name('admin.invoice.storedata');
    Route::get('admin/invoice/editdata/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'editInvoiceData'])->name('admin.invoice.editdata');
    Route::patch('admin/invoice/updatedata/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'updateInvoiceData'])->name('admin.invoice.updatedata');
    Route::get('admin/invoice/destroyinvoicedata/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'destroyInvoiceData'])->name('admin.invoicedata.destroy');

    Route::get('admin/invoice/createpdf/{id}', [App\Http\Controllers\AdminInvoiceController::class, 'createPDF'])->name('admin.invoice.pdf');
    Route::post('admin/invoice/add-discount', [App\Http\Controllers\AdminInvoiceController::class, 'addDiscount'])->name('admin.invoice.add-discount');

    Route::get('admin/export', [App\Http\Controllers\AdminInvoiceController::class, 'export'])->name('admin.invoice.export');

    // Route::get("admin/image-page", [App\Http\Controllers\AdminSamplesController::class, 'imagePage'])->name('admin.image-page.index');
    // Route::patch("admin/form/image-upload/{id}", [App\Http\Controllers\AdminSamplesController::class, 'imageUpload'])->name('admin.image-upload.index');

    Route::get("admin/users", [App\Http\Controllers\AdminUsersController::class, 'index'])->name('admin.invoice.index');
    Route::get('admin/users/create', [App\Http\Controllers\AdminUsersController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users/store', [App\Http\Controllers\AdminUsersController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/edit/{id}', [App\Http\Controllers\AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::patch('admin/users/update/{id}', [App\Http\Controllers\AdminUsersController::class, 'update'])->name('admin.users.update');
    Route::get('admin/users/destroy/{id}', [App\Http\Controllers\AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::get("admin/users/active/{id}", [App\Http\Controllers\AdminUsersController::class, 'userActive'])->name('admin.users.active');
});

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
