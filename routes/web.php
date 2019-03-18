<?php

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
    //return view('fontpage');
});

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Auth::routes();
// Route::get('verifyEmailFirst','Auth\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');
Route::get('verify/{email}/{verifyToken}','Auth\RegisterController@sendEmailDone')->name('sendEmailDone');
Route::post('updatePass','Auth\RegisterController@updatePassword')->name('updatePass');

Route::get('user/verifyEmailFirst','UserController@verifyEmailFirst')->name('user.verifyEmailFirst');

Route::get('admin/verifyEmailFirst','AdminController@verifyEmailFirst')->name('verifyEmailFirst');
// admin ------------
 Route::GET('admin/home','AdminController@index');
Route::POST('admin','Admin\LoginController@login')->name('admin.login');
Route::GET('admin','Admin\LoginController@showLoginForm');
ROute::POST('admin/logout','Admin\LoginController@logout');
Route::POST('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::GET('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::POST('admin-password/reset','Admin\ResetPasswordController@reset')->name('admin.password.reset');
Route::GET('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::GET('admin/register','Admin\RegisterController@showRegistrationForm');
Route::POST('admin/register','Admin\RegisterController@register')->name('admin.register');

Route::GET('admin/client-register','AdminController@clientRegisterForm');
Route::POST('admin/create-client','AdminController@clientCreate')->name('admin.client-register');

Route::GET('admin/client-list','AdminController@clientList');
Route::GET('admin/client-approved','AdminController@clientApproved');

// -----end admin register-------
// -------client user create-------
Route::GET('user/register','UserController@showRegistrationForm');
Route::POST('user/register','UserController@userCreate')->name('user.register');
Route::GET('user/list','UserController@userList');
Route::GET('user/approved','UserController@clientApproved');
Route::GET('user/delete-user/{id}','UserController@deleteUser');
// -------end client user create-------
Route::get('/home', 'HomeController@index')->name('home');
// -----Seller--------------
Route::resource('/seller', 'SellerInfoController');
Route::GET('/seller-edit', 'SellerInfoController@editseller');
Route::POST('/seller/info-update', 'SellerInfoController@updateSeller');
Route::POST('/seller/info-store', 'SellerInfoController@store');
Route::GET('/seller-delete', 'SellerInfoController@deleteSellerinfo');

Route::GET('/seller-product-add/{cid}/{id}','SellerProductController@index');
Route::GET('/seller-invoice-add/{id}','SellerProductController@invoicePage');
Route::POST('/seller/invoice-store','SellerProductController@inviceCreate');
Route::GET('/seller-extra-cost-add','SellerProductController@extraCostAdd');
Route::GET('/seller-product-add-temp','SellerProductController@addProductInfos');
Route::GET('/seller-product-edit-temp','SellerProductController@productEdit');
Route::GET('/seller-product-update-temp','SellerProductController@editProductInfos');
Route::GET('/seller-product-delete','SellerProductController@deleteProduct');
Route::GET('/seller-extra-cost-delete','SellerProductController@deleteExtraCost');
Route::GET('/seller-extra-cost-edit','SellerProductController@editExtraCost');
Route::GET('/seller-extra-cost-update','SellerProductController@updateExtraCost');
Route::GET('/seller-final-voucher-create','SellerProductController@finalVoucherCreate');
Route::GET('/seller-voucher-page/{cid}/{id}','SellerProductController@voucherPage');
Route::GET('/seller-get-amount-summary','SellerProductController@getAmountSummary');

Route::GET('/stock-product','SellerProductController@stockList');

Route::get('/category-change','SellerProductController@category_change');
// ----------organization--------------
Route::resource('/organization','OrganizationController');
Route::GET('/edit-organization','OrganizationController@editOrg');
Route::POST('/update-organization','OrganizationController@update');
Route::GET('/organization_load','OrganizationController@orgload');
// --------customer--------------------------
Route::resource('/customer','CustomerInfoController');
Route::GET('/customer-edit', 'CustomerInfoController@editseller');
Route::POST('/customer/info-update', 'CustomerInfoController@updateSeller');
Route::POST('/customer/info-store', 'CustomerInfoController@store');
Route::GET('/customer-delete', 'CustomerInfoController@deleteSellerinfo');

Route::GET('/customer-product-add/{cid}/{id}','CustomerProductController@index');
Route::GET('/customer-article-onchange','CustomerProductController@articaleOnChange');
Route::POST('/customer/invoice-store','CustomerProductController@inviceCreate');
Route::GET('/customer-extra-cost-add','CustomerProductController@extraCostAdd');
Route::GET('/customer-product-add-temp','CustomerProductController@addProductInfos');
Route::GET('/customer-product-edit-temp','CustomerProductController@productEdit');
Route::GET('/customer-product-update-temp','CustomerProductController@editProductInfos');
Route::GET('/customer-product-delete','CustomerProductController@deleteProduct');
Route::GET('/customer-extra-cost-delete','CustomerProductController@deleteExtraCost');
Route::GET('/customer-extra-cost-edit','CustomerProductController@editExtraCost');
Route::GET('/customer-extra-cost-update','CustomerProductController@updateExtraCost');
Route::GET('/customer-final-voucher-create','CustomerProductController@finalVoucherCreate');
Route::GET('/customer-voucher-page/{cid}/{id}','CustomerProductController@voucherPage');

Route::GET('/customer-product-add','CustomerProductController@index');
Route::GET('/customer-get-amount-summary','CustomerProductController@getAmountSummary');


Route::GET('/balance-recive','ReportController@balanceRecive');
Route::GET('/get-client-name','ReportController@getChangeClicnt');
Route::GET('/get-client-amount','ReportController@getClientTotalAmount');
Route::POST('/recive-payment-store','ReportController@recivepaymentstore');
Route::GET('/get-invoice-wise-boucher','ReportController@invoiceWiseBoucher');
Route::GET('/get-invoice-no','ReportController@getInvoiceNumber');
Route::GET('/get-boucher','ReportController@boucherPageFind');
Route::GET('/get-boucher-customer/{cid}/{id}','ReportController@findBoucherCustomer');
Route::GET('/get-boucher-seller/{cid}/{id}','ReportController@findBoucherSeller');
Route::GET('/get-customer-wise-report','ReportController@customerWiseReport');
Route::GET('/get-seller-wise-report','ReportController@sellerWiseReport');
Route::GET('/get-extra-cost-report','ReportController@extraCoustReport');
Route::GET('/get-client-wise-report','ReportController@clientWiseform');
Route::POST('/get-client-wise-report','ReportController@clientsWiseReport');
Route::GET('/get-total-account-report','ReportController@totalAcounts');
Route::GET('/get-profite-report','ReportController@profiteForm');
Route::POST('/get-profite-report','ReportController@profite');
Route::get('/get-profite','ReportController@simpleprofite');
Route::GET('/get-date-wise-report','ReportController@dateWiseForm');
Route::POST('/get-date-wise-report','ReportController@dateWiseReport');

// --------extra cost--------------------------
Route::get('/owner-extra-cost','ExtraCostController@index');
Route::get('/extra-cost-add','ExtraCostController@insertextracost');
Route::get('/extra-cost-edit','ExtraCostController@getextracost');
Route::get('/extra-cost-update','ExtraCostController@getextracostupdate');
Route::get('/extra-cost-delete/{id}','ExtraCostController@destroy');

// -------employer--------
Route::GET('/employer-list','EmployerController@index');
Route::GET('/employer-add','EmployerController@insertEmployer');
Route::GET('/employer-edit','EmployerController@editEmployer');
Route::GET('/employer-update','EmployerController@updateEmployer');
Route::GET('/employer-delete/{id}','EmployerController@deleteEmployer');
Route::GET('/employer-salary','EmployerController@salaryPayment');
Route::GET('/employer-salary-insert','EmployerController@insertSalary');
Route::GET('/employer-salary-edit','EmployerController@editSalary');
Route::GET('/employer-salary-update','EmployerController@updateSalary');
Route::GET('/employer-salary-delete/{id}','EmployerController@deleteSalary');

//-----------category------------
Route::GET('/category','CategoryController@category');
Route::POST('/category','CategoryController@category_insert');
Route::GET('/sub-category/{id}','CategoryController@sub_category');
Route::POST('/sub-category/{id}','CategoryController@sub_category_insert');
Route::GET('/category-edit/{id}','CategoryController@category_edit');
Route::POST('/category-update','CategoryController@category_update');
Route::GET('/sub-category-edit/{parentid}/{id}','CategoryController@sub_category_edit');
Route::POST('/sub-category-update','CategoryController@sub_category_update');
Route::DELETE('/category-delete/{id}','CategoryController@category_delete');