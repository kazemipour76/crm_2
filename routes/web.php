<?php
Route::get('category-tree-view', ['uses' => 'CategoryController@manageCategory']);
Route::post('add-category', ['as' => 'add.category', 'uses' => 'CategoryController@addCategory']);
//Route::get('test',function () {
//  $test=new \App\Models\CMS\Menu()  ;
//  $test->getTree();
//});
Route::get('test', function () {
//
//$test = \App\Models\CRM\PreInvoice::find(2);
//$test->totalPrice();
//dd($test->totalPrice());

//    $test = \App\Models\CRM\PreInvoice::find(3)
//        ->details()
//        ->selectRaw('pre_invoice_id ,SUM(count*unit_price) as total_price')
//        ->groupBy('pre_invoice_id')
//        ->first()->total_price;
//dd($test);
});

//Route::get('tree', function () {
//    $tree = \App\Models\CMS\Menu::getTree();
//    return response()->json($tree);
//
//});Route::get('/', function () {
//dd('dddddd'
//);
//});


Route::get('collect', function () {
    $arr = collect([
        ['id' => 1, 'name' => 'ali', 'age' => 25],
        ['id' => 3, 'name' => 'reza', 'age' => 45],
        ['id' => 2, 'name' => 'hasan', 'age' => 40],
    ]);

//    $ret = $arr->where('id', 2)->pluck('id')->toArray();
    $ret = $arr->where('age', '>', 30)->pluck('name', 'id')->toArray();
    dd($ret);
});


//Route::get('test', '\App\Http\Controllers\Backend\CMS\MenuController@index');

Route::get('sadmin/login', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'loginPage'])->name('login');
Route::post('sadmin/login', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'login']);
Route::get('sadmin/logout', [\App\Http\Controllers\Backend\Auth\AuthController::class, 'logout']);

use App\Models\CRM\Customer;
use App\Utilities\Routers;
use Illuminate\Database\Eloquent\Model;

Route::group([
    'middleware' => 'auth',
    'prefix' => \App\Utilities\Url::getAdminPrefix()
], function () {


    Route::group(['prefix' => 'crm'], function () {
        Routers::crud('customer', \App\Http\Controllers\Backend\CRM\CustomerController::class);
        Route::get('customer/{id}/invoicesList', [\App\Http\Controllers\Backend\CRM\CustomerController::class,'invoicesList']);
        Route::get('customer/{id}/preInvoicesList', [\App\Http\Controllers\Backend\CRM\CustomerController::class,'preInvoicesList']);
        Routers::crud('preInvoice', \App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceController::class);
        Routers::crud('invoice', \App\Http\Controllers\Backend\CRM\Invoice\InvoiceController::class);
        Routers::crud('preInvoiceDetail', \App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceDetailController::class);
        Route::get('preInvoice/{id}/conversion', [\App\Http\Controllers\Backend\CRM\Invoice\InvoiceController::class,'conversion']);
        Route::get('preInvoiceDetail/{id}/create', [\App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceDetailController::class, 'create']);
        Route::post('preInvoiceDetail/{id}/create', [\App\Http\Controllers\Backend\CRM\PreInvoice\PreInvoiceDetailController::class, 'store']);
        Route::get('preInvoice/{id}/pdf', [\App\Http\Controllers\Backend\CRM\PreInvoice\PdfController::class, 'create']);
    });

    Route::group(['prefix' => 'auth'], function () {
        Routers::crud('user', \App\Http\Controllers\Backend\Auth\UserController::class);
        Routers::crud('group', \App\Http\Controllers\Backend\Auth\GroupController::class);
    });

    Route::group(['prefix' => 'library'], function () {
        Routers::crud('library', \App\Http\Controllers\Backend\Library\LibraryController::class, [
            'create' => false
        ]);
        Route::get('library/gallery', [\App\Http\Controllers\Backend\Library\LibraryController::class, 'gallery']);
        Route::get('library/create', [\App\Http\Controllers\Backend\Library\LibraryController::class, 'create']);
        Route::post('library/create', [\App\Http\Controllers\Backend\Library\LibraryController::class, 'store'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    });

    Route::group(['prefix' => 'cms'], function () {
        Routers::crud('menu', \App\Http\Controllers\Backend\CMS\MenuController::class);
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('/{section}', [\App\Http\Controllers\Backend\Setting\SettingController::class, 'edit']);
        Route::post('/{section}', [\App\Http\Controllers\Backend\Setting\SettingController::class, 'update']);
    });


    Route::group(['prefix' => '/dash'], function () {
        Route::get('/', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'index']);
    });

    Route::get('/', function () {
        return redirect(\App\Utilities\Url::admin('dash'));
    });
});




