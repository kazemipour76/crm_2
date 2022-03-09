<?php
use App\Utilities\Routers;

Route::get('/',function (){
   return response()->redirectTo('auth/login');
});
Route::get('auth/login', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'loginPage'])->name('login');
Route::post('auth/login', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'login']);
Route::get('auth/register', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'registerPage']);
Route::post('auth/register', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'register']);
Route::get('auth/logout', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'logout']);

Route::group([
    'middleware' =>[ 'auth','check_user'],
    'prefix' => \App\Utilities\Url::getAdminPrefix()
], function () {


    Route::group(['prefix' => 'crm'], function () {
        Routers::crud('customer', \App\Http\Controllers\Backend\CRM\CustomerController::class);
        Routers::crud('preInvoice', \App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceController::class);
        Routers::crud('invoice', \App\Http\Controllers\Backend\CRM\Invoice\InvoiceController::class);
        Routers::crud('preInvoiceDetail', \App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceDetailController::class);
        Routers::crud('invoiceDetail', \App\Http\Controllers\Backend\CRM\Invoice\InvoiceDetailController::class);
        Route::get('preInvoice/{id}/conversion', [\App\Http\Controllers\Backend\CRM\Invoice\InvoiceController::class, 'conversion']);
        Route::get('preInvoiceDetail/{id}/create', [\App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceDetailController::class, 'create']);
        Route::get('invoiceDetail/{id}/create', [\App\Http\Controllers\Backend\CRM\Invoice\InvoiceDetailController::class, 'create']);
        Route::post('preInvoiceDetail/{id}/create', [\App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceDetailController::class, 'store']);
        Route::post('invoiceDetail/{id}/create', [\App\Http\Controllers\Backend\CRM\Invoice\InvoiceDetailController::class, 'store']);
        Route::get('preInvoice/{id}/pdf', [\App\Http\Controllers\Backend\CRM\PreInvoice\PdfController::class, 'create']);
        Route::get('invoice/{id}/pdf', [\App\Http\Controllers\Backend\CRM\Invoice\PdfController::class, 'create']);
        Route::get('chartReports', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class ,'chart']);
    });
    Route::group(['prefix' => 'auth','middleware' => ['check_admin']], function () {
        Routers::crud('user', \App\Http\Controllers\Backend\Auth\UserController::class);
        Route::get('user/image', [\App\Http\Controllers\Backend\Auth\UserController::class, 'image'])
            ->withoutMiddleware(\App\Http\Middleware\CheckAdmin::class);;
        Route::post('user/image', [\App\Http\Controllers\Backend\Auth\UserController::class, 'saveImage'])
            ->withoutMiddleware(\App\Http\Middleware\CheckAdmin::class);;
        Route::get('user/image/deleteImage', [\App\Http\Controllers\Backend\Auth\UserController::class, 'deleteImage'])
            ->withoutMiddleware(\App\Http\Middleware\CheckAdmin::class);;
        Route::get('user/userInformation', [\App\Http\Controllers\Backend\Auth\UserController::class, 'editInformation'])
            ->withoutMiddleware(\App\Http\Middleware\CheckAdmin::class);;
        Route::post('user/userInformation', [\App\Http\Controllers\Backend\Auth\UserController::class, 'updateInformation'])
            ->withoutMiddleware(\App\Http\Middleware\CheckAdmin::class);;
        Route::get('user/{id}/block', [\App\Http\Controllers\Backend\Auth\UserController::class, 'blockUser']);
        Route::get('user/{id}/permissions', [\App\Http\Controllers\Backend\Auth\UserController::class, 'userPermissions']);
        Route::post('user/{id}/permissions', [\App\Http\Controllers\Backend\Auth\UserController::class, 'userPermissionsChange']);
        Route::get('admin/detailUser/{id}/show', [\App\Http\Controllers\Backend\CRM\Admin\AdminController::class ,'index']);

    });

    Route::group(['prefix' => '/dash'], function () {
        Route::get('/', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'index'])
            ->withoutMiddleware(\App\Http\Middleware\CheckUser::class);
    });

});




