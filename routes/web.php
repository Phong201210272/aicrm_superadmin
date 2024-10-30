<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\CheckInventoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Staff\ClientController as StaffClientController;
use App\Http\Controllers\Staff\OrderController as StaffOrderController;
use App\Http\Controllers\Staff\ProductController as StaffProductController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\DailyReportController;
use App\Http\Controllers\Admin\DebtClientController;
use App\Http\Controllers\Admin\DebtNccController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\importCouponController;
use App\Http\Controllers\Admin\ImportProductController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReportdebtController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Client\SignUpController;
use App\Http\Controllers\Staff\CheckInventoryController as staffcheckController;
use App\Http\Controllers\Staff\WareHomeController;
use App\Http\Controllers\SuperAdmin\StoreController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Models\Categories;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TransferController as AdminTransferController;
use App\Http\Controllers\Admin\ZaloController as AdminZaloController;
use App\Http\Controllers\Admin\ZnsMessageController as AdminZnsMessageController;
use App\Http\Controllers\SuperAdmin\CampaignController;
use App\Http\Controllers\SuperAdmin\TransactionController as SuperAdminTransactionController;
use App\Http\Controllers\SuperAdmin\TransferController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ZnsMessageController;
use App\Http\Controllers\SuperAdmin\ZaloController;
use App\Http\Controllers\SuperAdminController as ControllersSuperAdminController;
use App\Http\Middleware\CheckAccountLogin;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\CheckLoginSuperAdmin;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

// Route::get('', [CategorieController::class, 'index']);
Route::post('/check-account', [SignUpController::class, 'checkAccount'])->name('check.account');

// Route::get('/check-phone-exists', [SignUpController::class, 'checkPhoneExists'])->name('check-phone-exists');
// Route::get('/check-email-exists', [SignUpController::class, 'checkEmailExists'])->name('check-email-exists');
Route::get('/dang-ky', [SignUpController::class, 'index'])->name('register.index');
Route::post('/register_account', [SignUpController::class, 'store'])->name('register.signup');
// Route::get('/{username}', function ($username) {
//     return view('auth.login', compact('username'));
// })->name('formlogin');
Route::get('/', function () {
    return view('auth.login');
})->name('formlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/{username}/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify_otp_confirm');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::post('/payment-notify', [PaymentController::class, 'paymentNotify'])->name('payment.notify');
});
Route::get('forget-password', function () {
    return view('auth.forget-password');
})->name('forget-password');

Route::get('/product', function () {
    return view('Themes.pages.product.index');
})->name('product');
// Route::get('/category',function(){
//         return view('Themes.pages.category.index');
//         })->name('category');
Route::get('/employee', function () {
    return view('Themes.pages.employee.index');
})->name('employee');

// Route::middleware(CheckLogin::class)->prefix('admin')->name('admin.')->group(function ($username) {
//     // Route::middleware(CheckAccountLogin::class)->prefix('{username}')->name('{username}.')->group(function () {
//     Route::prefix('transfer')->name('transfer.')->group(function () {
//         Route::get('', [AdminTransferController::class, 'index'])->name('index');
//     });
//     Route::prefix('transaction')->name('transaction.')->group(function () {
//         Route::get('/update-notification/{id}', [TransactionController::class, 'updateNotification'])->name('updateNotification');
//         Route::get('', [TransactionController::class, 'index'])->name('index');
//         Route::get('search', [TransactionController::class, 'search'])->name('search');
//         Route::get('payment', [TransactionController::class, 'payment'])->name('payment');
//         Route::post('store', [TransactionController::class, 'store'])->name('store');
//         Route::get('export/{id}', [TransactionController::class, 'exportPDF'])->name('export');
//         Route::get('generateQR', [TransactionController::class, 'generateQrCode'])->name('generate');
//     });
//     Route::prefix('campaign')->name('campaign.')->group(function () {
//         Route::get('add', [AdminCampaignController::class, 'add'])->name('add');
//         Route::get('', [AdminCampaignController::class, 'index'])->name('index');
//         Route::get('fetch', [AdminCampaignController::class, 'fetch'])->name('fetch');
//         Route::post('store', [AdminCampaignController::class, 'store'])->name('store');
//         Route::get('detail/{id}', [AdminCampaignController::class, 'edit'])->name('detail');
//         Route::post('update/{id}', [AdminCampaignController::class, 'update'])->name('update');
//         Route::delete('delete/{id}', [AdminCampaignController::class, 'delete'])->name('delete');
//         Route::post('update-status/{id}', [AdminCampaignController::class, 'updateStatus'])->name('updateStatus');
//     });
//     Route::prefix('zalo')->name('zalo.')->group(function () {
//         Route::get('zns', [AdminZaloController::class, 'index'])->name('zns');
//         Route::get('/get-active-oa-name', [AdminZaloController::class, 'getActiveOaName'])->name('getActiveOaName');
//         Route::post('/update-oa-status/{oaId}', [AdminZaloController::class, 'updateOaStatus'])->name('updateOaStatus');
//         Route::post('/refresh-access-token', [AdminZaloController::class, 'refreshAccessToken'])->name('refreshAccessToken');
//     });
//     Route::prefix('message')->name('message.')->group(function () {
//         Route::get('', [AdminZnsMessageController::class, 'znsMessage'])->name('znsMessage');
//         Route::get('/quota', [AdminZnsMessageController::class, 'znsQuota'])->name('znsQuota');
//         Route::get('template', [AdminZnsMessageController::class, 'templateIndex'])->name('znsTemplate');
//         Route::get('refresh', [AdminZnsMessageController::class, 'refreshTemplates'])->name('znsTemplateRefresh');
//         Route::get('detail', [AdminZnsMessageController::class, 'getTemplateDetail'])->name('znsTemplateDetail');
//         Route::get('test', [AdminZnsMessageController::class, 'test'])->name('test');
//     });
//     Route::get('/detail/{id}', [AdminController::class, 'getAdminInfor'])->name('detail');
//     Route::post('/update/{id}', [AdminController::class, 'updateAdminInfor'])->name('update');
//     Route::post('/changePassword', [AdminController::class, 'changePassword'])->name('changePassword');
//     Route::post('logout', [AdminController::class, 'logout'])->name('logout');

//     Route::prefix('store')->name('store.')->group(function () {
//         Route::get('/index', [AdminStoreController::class, 'index'])->name('index');
//         Route::get('/detail/{id}', [AdminStoreController::class, 'detail'])->name('detail');
//         Route::get('/findByPhone', [AdminStoreController::class, 'findByPhone'])->name('findByPhone');
//         Route::get('/delete/{id}', [AdminStoreController::class, 'delete'])->name('delete');
//         Route::post('/store', [AdminStoreController::class, 'store'])->name('store');
//     });
//     Route::post('logout', [AuthController::class, 'logout'])->name('logout');
//     // });
// })->middleware('checkRole:1');

Route::get('super-dang-nhap', [SuperAdminController::class, 'loginForm'])->name('super.dang.nhap');
Route::post('super-dang-nhap', [SuperAdminController::class, 'login'])->name('super.login.submit');
Route::middleware(CheckLoginSuperAdmin::class)->prefix('super-admin')->name('super.')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('', [SuperAdminUserController::class, 'index'])->name('index');
        Route::get('search', [SuperAdminUserController::class, 'search'])->name('search');
        Route::post('store', [SuperAdminUserController::class, 'store'])->name('store');
        Route::get('detail/{id}', [SuperAdminUserController::class, 'detail'])->name('detail');
        Route::get('/edit' , [SuperAdminUserController::class , 'edit'])->name('edit');
        Route::post('/update' , [SuperAdminUserController::class , 'update'])->name('update');
        Route::delete('/delete', [SuperAdminUserController::class, 'delete'])->name('delete');
    });
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('', [SuperAdminTransactionController::class, 'index'])->name('index');
        Route::get('search', [SuperAdminTransactionController::class, 'search'])->name('search');
        Route::put('confirm/{id}', [SuperAdminTransactionController::class, 'confirmTransaction'])->name('confirm');
        Route::put('reject/{id}', [SuperAdminTransactionController::class, 'rejectTransaction'])->name('reject');
        Route::get('update-notification/{id}', [SuperAdminTransactionController::class, 'updateNotification'])->name('updateNotification');
    });
    Route::prefix('transfer')->name('transfer.')->group(function () {
        Route::get('', [TransferController::class, 'index'])->name('index');
        Route::get('list', [TransferController::class, 'list'])->name('list');
        Route::get('search', [TransferController::class, 'search'])->name('search');
        Route::post('store/{id}', [TransferController::class, 'store'])->name('store');
    });
    // Route::prefix('campaign')->name('campaign.')->group(function () {
    //     Route::get('add', [CampaignController::class, 'add'])->name('add');
    //     Route::get('', [CampaignController::class, 'index'])->name('index');
    //     Route::get('fetch', [CampaignController::class, 'fetch'])->name('fetch');
    //     Route::post('store', [CampaignController::class, 'store'])->name('store');
    //     Route::get('detail/{id}', [CampaignController::class, 'edit'])->name('detail');
    //     Route::post('update/{id}', [CampaignController::class, 'update'])->name('update');
    //     Route::delete('delete/{id}', [CampaignController::class, 'delete'])->name('delete');
    //     Route::post('update-status/{id}', [CampaignController::class, 'updateStatus'])->name('updateStatus');
    // });
    Route::prefix('zalo')->name('zalo.')->group(function () {
        Route::post('store', [ZaloController::class, 'store'])->name('store');
        Route::get('zns', [ZaloController::class, 'index'])->name('zns');
        Route::get('/get-active-oa-name', [ZaloController::class, 'getActiveOaName'])->name('getActiveOaName');
        Route::post('/update-oa-status/{oaId}', [ZaloController::class, 'updateOaStatus'])->name('updateOaStatus');
        Route::post('/refresh-access-token', [ZaloController::class, 'refreshAccessToken'])->name('refreshAccessToken');
    });
    Route::prefix('message')->name('message.')->group(function () {
        Route::get('', [ZnsMessageController::class, 'znsMessage'])->name('znsMessage');
        Route::get('/quota', [ZnsMessageController::class, 'znsQuota'])->name('znsQuota');
        Route::get('template', [ZnsMessageController::class, 'templateIndex'])->name('znsTemplate');
        Route::get('refresh', [ZnsMessageController::class, 'refreshTemplates'])->name('znsTemplateRefresh');
        Route::get('detail', [ZnsMessageController::class, 'getTemplateDetail'])->name('znsTemplateDetail');
        Route::get('test', [ZnsMessageController::class, 'test'])->name('test');
    });
    Route::get('/detail/{id}', [SuperAdminController::class, 'getSuperAdminInfor'])->name('detail');
    Route::post('/update/{id}', [SuperAdminController::class, 'updateSuperAdminInfo'])->name('update');
    Route::post('logout', [SuperAdminController::class, 'logout'])->name('logout');
    // Route::prefix('store')->name('store.')->group(function () {
    //     Route::get('/index', [StoreController::class, 'index'])->name('index');
    //     Route::get('/detail/{id}', [StoreController::class, 'detail'])->name('detail');
    //     Route::get('/findByPhone', [StoreController::class, 'findByPhone'])->name('findByPhone');
    //     Route::get('/delete/{id}', [StoreController::class, 'delete'])->name('delete');
    // });
});
