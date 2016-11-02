<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/',array('uses'=>'CoverController@index'));
Route::get('/login',array('uses'=>'CoverController@showlogin'));
Route::post('/login',array('uses'=>'CoverController@authent'));
Route::get('/logout',array('uses'=>'CoverController@logOut'));

Route::get('/main',array('before'=>'auth','uses'=>'CoverController@main'));

Route::get('/profile',array('before'=>'auth','uses'=>'ProfileController@editprofile'));
Route::post('/profile',array('before'=>'auth','uses'=>'ProfileController@store'));

// Users Management
Route::get('/users',array('before'=>'auth','uses'=>'UsersController@show_users'));
Route::get('/users/create',array('before'=>'auth','uses'=>'UsersController@create_form'));
Route::post('/users/create',array('before'=>'auth','uses'=>'UsersController@store'));

Route::get('/users/roles',array('before'=>'auth','uses'=>'UsersController@show_user_roles'));
Route::post('/users/delete_user',array('before'=>'auth','uses'=>'UsersController@delete_user'));
Route::post('/users/delete_user_role',array('before'=>'auth','uses'=>'UsersController@delete_user_role'));
Route::post('/users/edit',array('before'=>'auth','uses'=>'UsersController@save_edit'));
Route::get('/users/{id}',array('before'=>'auth','uses'=>'UsersController@edit_user'));

//Product Category
Route::get('/product_category',array('before'=>'auth','uses'=>'ProductsCategoryController@show_productcategory'));
Route::get('/product_category/create',array('before'=>'auth','uses'=>'ProductsCategoryController@create_form'));
Route::post('/product_category/create',array('before'=>'auth','uses'=>'ProductsCategoryController@store'));

Route::post('/product_category/delete_productcategory',array('before'=>'auth','uses'=>'ProductsCategoryController@delete_productcategory'));
Route::post('/product_category/edit',array('before'=>'auth','uses'=>'ProductsCategoryController@save_edit'));
Route::get('/product_category/view/{id}',array('before'=>'auth','uses'=>'ProductsCategoryController@view_productcategory'));
Route::get('/product_category/{id}',array('before'=>'auth','uses'=>'ProductsCategoryController@edit_productcategory'));
// Products Management

Route::get('/products',array('before'=>'auth','uses'=>'ProductsController@show_products'));
Route::post('/products/import',array('before'=>'auth','uses'=>'ProductsController@import_products'));
Route::get('api/products', array('as' => 'api.products', 'uses' => 'ProductsController@getProductsDataTable'));
Route::get('/products/create',array('before'=>'auth','uses'=>'ProductsController@create_form'));
Route::post('/products/create',array('before'=>'auth','uses'=>'ProductsController@store'));

Route::post('/products/delete_product',array('before'=>'auth','uses'=>'ProductsController@delete_product'));
Route::post('/products/edit',array('before'=>'auth','uses'=>'ProductsController@save_edit'));
Route::get('/products/view/{id}',array('before'=>'auth','uses'=>'ProductsController@view_product'));
Route::get('/products/{id}',array('before'=>'auth','uses'=>'ProductsController@edit_product'));

Route::post('/products/enable',array('before'=>'auth','uses'=>'ProductsController@enable_product'));
Route::post('/products/disable',array('before'=>'auth','uses'=>'ProductsController@disable_product'));
Route::post('/products/getprice',array('before'=>'auth','uses'=>'ProductsController@getprice'));

// Clients Management
Route::get('/clients',array('before'=>'auth','uses'=>'ClientsController@show_clients'));
Route::get('/clients/create',array('before'=>'auth','uses'=>'ClientsController@create_form'));
Route::get('/clients/fancycreate',array('before'=>'auth','uses'=>'ClientsController@fancy_create_form'));
Route::post('/clients/create',array('before'=>'auth','uses'=>'ClientsController@store'));
Route::post('/clients/fancycreate',array('before'=>'auth','uses'=>'ClientsController@fancystore'));

Route::post('/clients/delete_client',array('before'=>'auth','uses'=>'ClientsController@delete_client'));
Route::post('/clients/edit',array('before'=>'auth','uses'=>'ClientsController@save_edit'));
Route::get('/clients/view/{id}',array('before'=>'auth','uses'=>'ClientsController@view_client'));
Route::get('/clients/{id}',array('before'=>'auth','uses'=>'ClientsController@edit_client'));


// Middlemen Management
Route::get('/company',array('before'=>'auth','uses'=>'MiddlemenController@show_middlemen'));
Route::get('/company/create',array('before'=>'auth','uses'=>'MiddlemenController@create_form'));
Route::get('/company/fancycreate',array('before'=>'auth','uses'=>'MiddlemenController@fancy_create_form'));
Route::post('/company/create',array('before'=>'auth','uses'=>'MiddlemenController@store'));
Route::post('/company/fancycreate',array('before'=>'auth','uses'=>'MiddlemenController@fancystore'));

Route::post('/company/delete_middlemen',array('before'=>'auth','uses'=>'MiddlemenController@delete_middlemen'));
Route::post('/company/edit',array('before'=>'auth','uses'=>'MiddlemenController@save_edit'));
Route::get('/company/view/{id}',array('before'=>'auth','uses'=>'MiddlemenController@view_middlemen'));
Route::get('/company/{id}',array('before'=>'auth','uses'=>'MiddlemenController@edit_middlemen'));
// Staffs Management
Route::get('/staffs',array('before'=>'auth','uses'=>'StaffsController@show_staffs'));
Route::get('/staffs/create',array('before'=>'auth','uses'=>'StaffsController@create_form'));
Route::get('/staffs/fancycreate',array('before'=>'auth','uses'=>'StaffsController@fancy_create_form'));
Route::post('/staffs/create',array('before'=>'auth','uses'=>'StaffsController@store'));
Route::post('/staffs/fancycreate',array('before'=>'auth','uses'=>'StaffsController@fancystore'));

Route::post('/staffs/delete_staff',array('before'=>'auth','uses'=>'StaffsController@delete_staff'));
Route::post('/staffs/edit',array('before'=>'auth','uses'=>'StaffsController@save_edit'));
Route::get('/staffs/view/{id}',array('before'=>'auth','uses'=>'StaffsController@view_staff'));
Route::get('/staffs/{id}',array('before'=>'auth','uses'=>'StaffsController@edit_staff'));

// Suppliers Management
Route::get('/suppliers',array('before'=>'auth','uses'=>'SuppliersController@show_suppliers'));
Route::get('/suppliers/create',array('before'=>'auth','uses'=>'SuppliersController@create_form'));
Route::get('/suppliers/fancycreate',array('before'=>'auth','uses'=>'SuppliersController@fancy_create_form'));
Route::post('/suppliers/create',array('before'=>'auth','uses'=>'SuppliersController@store'));
Route::post('/suppliers/fancycreate',array('before'=>'auth','uses'=>'SuppliersController@fancystore'));

Route::post('/suppliers/delete_supplier',array('before'=>'auth','uses'=>'SuppliersController@delete_supplier'));
Route::post('/suppliers/edit',array('before'=>'auth','uses'=>'SuppliersController@save_edit'));
Route::get('/suppliers/view/{id}',array('before'=>'auth','uses'=>'SuppliersController@view_supplier'));
Route::get('/suppliers/{id}',array('before'=>'auth','uses'=>'SuppliersController@edit_supplier'));

// Quotations Management
Route::get('/quotations',array('before'=>'auth','uses'=>'QuotationsController@show_quotations'));
Route::put('/quotations',array('before'=>'auth','uses'=>'QuotationsController@pay_money'));
Route::get('/quotations/create',array('before'=>'auth','uses'=>'QuotationsController@create_form'));
Route::post('/quotations/create',array('before'=>'auth','uses'=>'QuotationsController@store'));
Route::post('/quotations/download',array('before'=>'auth','uses'=>'QuotationsController@download_quotation'));

Route::post('/quotations/delete_quotation',array('before'=>'auth','uses'=>'QuotationsController@delete_quotation'));
Route::post('/quotations/edit',array('before'=>'auth','uses'=>'QuotationsController@save_edit'));
Route::get('/quotations/view/{id}',array('before'=>'auth','uses'=>'QuotationsController@view_quotation'));
Route::get('/quotations/{id}',array('before'=>'auth','uses'=>'QuotationsController@edit_quotation'));

Route::post('/quotations/enable',array('before'=>'auth','uses'=>'QuotationsController@enable_quotation'));
Route::post('/quotations/disable',array('before'=>'auth','uses'=>'QuotationsController@disable_quotation'));

Route::post('/quotations/confirm_quotation',array('before'=>'auth','uses'=>'QuotationsController@confirm_quotation'));


// Invoices Management
Route::get('/invoices',array('before'=>'auth','uses'=>'InvoicesController@show_invoices'));
Route::put('/invoices',array('before'=>'auth','uses'=>'InvoicesController@pay_money'));
Route::put('/invoices/create',array('before'=>'auth','uses'=>'InvoicesController@pass_form'));
Route::get('/invoices/create',array('before'=>'auth','uses'=>'InvoicesController@create_form'));
Route::post('/invoices/create',array('before'=>'auth','uses'=>'InvoicesController@store'));
Route::post('/invoices/download',array('before'=>'auth','uses'=>'InvoicesController@download_invoice'));

Route::post('/invoices/delete_invoice',array('before'=>'auth','uses'=>'InvoicesController@delete_invoice'));
Route::post('/invoices/edit',array('before'=>'auth','uses'=>'InvoicesController@save_edit'));
Route::get('/invoices/view/{id}',array('before'=>'auth','uses'=>'InvoicesController@view_invoice'));
Route::get('/invoices/{id}',array('before'=>'auth','uses'=>'InvoicesController@edit_invoice'));

Route::post('/invoices/enable',array('before'=>'auth','uses'=>'InvoicesController@enable_invoice'));
Route::post('/invoices/disable',array('before'=>'auth','uses'=>'InvoicesController@disable_invoice'));

Route::post('/invoices/confirm_invoice',array('before'=>'auth','uses'=>'InvoicesController@confirm_invoice'));

Route::post('/getcontacts',array('before'=>'auth','uses'=>'SuppliersController@getcontacts'));
Route::post('/getaddress',array('before'=>'auth','uses'=>'ClientsController@getaddress'));

// Purchase Orders Management
Route::get('/purchase_orders',array('before'=>'auth','uses'=>'PurchaseOrdersController@show_purchase_orders'));
Route::get('/purchase_orders/create',array('before'=>'auth','uses'=>'PurchaseOrdersController@create_form'));
Route::put('/purchase_orders/create',array('before'=>'auth','uses'=>'PurchaseOrdersController@pass_form'));
Route::put('/purchase_orders/pass_form_fromproduct',array('before'=>'auth','uses'=>'PurchaseOrdersController@pass_form_fromproduct'));
Route::post('/purchase_orders/create',array('before'=>'auth','uses'=>'PurchaseOrdersController@store'));
Route::post('/purchase_orders/download',array('before'=>'auth','uses'=>'PurchaseOrdersController@download_po'));
Route::post('/purchase_orders/createp',array('before'=>'auth','uses'=>'PurchaseOrdersController@store_frompstatus'));

Route::post('/purchase_orders/delete_purchase_order',array('before'=>'auth','uses'=>'PurchaseOrdersController@delete_purchase_order'));
Route::post('/purchase_orders/edit',array('before'=>'auth','uses'=>'PurchaseOrdersController@save_edit'));
Route::get('/purchase_orders/view/{id}',array('before'=>'auth','uses'=>'PurchaseOrdersController@view_purchase_order'));
Route::get('/purchase_orders/{id}',array('before'=>'auth','uses'=>'PurchaseOrdersController@edit_purchase_order'));

Route::post('/purchase_orders/enable',array('before'=>'auth','uses'=>'PurchaseOrdersController@enable_purchase_order'));
Route::post('/purchase_orders/disable',array('before'=>'auth','uses'=>'PurchaseOrdersController@disable_purchase_order'));
Route::post('/purchase_orders/disable',array('before'=>'auth','uses'=>'PurchaseOrdersController@disable_purchase_order'));
Route::post('/purchase_orders/confirm_po',array('before'=>'auth','uses'=>'PurchaseOrdersController@confirm_po'));

// Credit Note Management
Route::get('/credit_notes',array('before'=>'auth','uses'=>'CreditNotesController@show_credit_notes'));
Route::get('/credit_notes/create/{id}',array('before'=>'auth','uses'=>'CreditNotesController@pass_form'));
Route::get('/credit_notes/create',array('before'=>'auth','uses'=>'CreditNotesController@create_form'));
Route::post('/credit_notes/create',array('before'=>'auth','uses'=>'CreditNotesController@store'));
Route::post('/credit_notes/download',array('before'=>'auth','uses'=>'CreditNotesController@download_cn'));

Route::post('/credit_notes/delete_credit_note',array('before'=>'auth','uses'=>'CreditNotesController@delete_credit_note'));
Route::post('/credit_notes/edit',array('before'=>'auth','uses'=>'CreditNotesController@save_edit'));
Route::get('/credit_notes/view/{id}',array('before'=>'auth','uses'=>'CreditNotesController@view_credit_note'));
Route::get('/credit_notes/{id}',array('before'=>'auth','uses'=>'CreditNotesController@edit_credit_note'));

Route::post('/credit_notes/enable',array('before'=>'auth','uses'=>'CreditNotesController@enable_credit_note'));
Route::post('/credit_notes/disable',array('before'=>'auth','uses'=>'CreditNotesController@disable_credit_note'));


// Delivery Orders Management
Route::get('/delivery_orders',array('before'=>'auth','uses'=>'DeliveryOrdersController@show_delivery_orders'));
Route::get('/delivery_orders/create',array('before'=>'auth','uses'=>'DeliveryOrdersController@create_form'));
Route::put('/delivery_orders/create',array('before'=>'auth','uses'=>'DeliveryOrdersController@pass_form'));
Route::post('/delivery_orders/create',array('before'=>'auth','uses'=>'DeliveryOrdersController@store'));
Route::post('/delivery_orders/download',array('before'=>'auth','uses'=>'DeliveryOrdersController@download_do'));

Route::post('/delivery_orders/delete_delivery_order',array('before'=>'auth','uses'=>'DeliveryOrdersController@delete_delivery_order'));
Route::post('/delivery_orders/edit',array('before'=>'auth','uses'=>'DeliveryOrdersController@save_edit'));
Route::get('/delivery_orders/view/{id}',array('before'=>'auth','uses'=>'DeliveryOrdersController@view_delivery_order'));
Route::get('/delivery_orders/{id}',array('before'=>'auth','uses'=>'DeliveryOrdersController@edit_delivery_order'));

Route::post('/delivery_orders/delivered',array('before'=>'auth','uses'=>'DeliveryOrdersController@delivered_delivery_order'));
Route::post('/delivery_orders/notdelivered',array('before'=>'auth','uses'=>'DeliveryOrdersController@not_delivered_delivery_order'));

//Store
Route::get('/store',array('before'=>'auth','uses'=>'StoreController@show_store'));
Route::get('/store/create',array('before'=>'auth','uses'=>'StoreController@create_form'));
Route::post('/store/create',array('before'=>'auth','uses'=>'StoreController@store'));

Route::post('/store/delete_store',array('before'=>'auth','uses'=>'StoreController@delete_store'));
Route::post('/store/edit',array('before'=>'auth','uses'=>'StoreController@save_edit'));
Route::get('/store/view/{id}',array('before'=>'auth','uses'=>'StoreController@view_store'));
Route::get('/store/{id}',array('before'=>'auth','uses'=>'StoreController@edit_store'));

//Store Type
Route::get('/store_type',array('before'=>'auth','uses'=>'StoreTypeController@show_store_type'));
Route::get('/store_type/create',array('before'=>'auth','uses'=>'StoreTypeController@create_form'));
Route::post('/store_type/create',array('before'=>'auth','uses'=>'StoreTypeController@store'));
Route::get('/store_type/fancycreate',array('before'=>'auth','uses'=>'StoreTypeController@fancy_create_form'));
Route::post('/store_type/delete_store',array('before'=>'auth','uses'=>'StoreTypeController@delete_store_type'));
Route::post('/store_type/edit',array('before'=>'auth','uses'=>'StoreTypeController@save_edit'));
Route::get('/store_type/view/{id}',array('before'=>'auth','uses'=>'StoreTypeController@view_store_type'));
Route::get('/store_type/{id}',array('before'=>'auth','uses'=>'StoreTypeController@edit_store_type'));
Route::post('/store_type/fancycreate',array('before'=>'auth','uses'=>'StoreTypeController@fancystore'));

//Currency Exchange
Route::get('/currency_exchange',array('before'=>'auth','uses'=>'CurrencyExchangeController@show_currencyexchange'));
Route::post('/currency_exchange/create_form',array('before'=>'auth','uses'=>'CurrencyExchangeController@create_form'));
Route::post('/currency_exchange/create',array('before'=>'auth','uses'=>'CurrencyExchangeController@store'));

Route::post('/currency_exchange/delete_currency_exchange',array('before'=>'auth','uses'=>'CurrencyExchangeController@delete_currencyexchange'));
Route::post('/currency_exchange/edit',array('before'=>'auth','uses'=>'CurrencyExchangeController@save_edit'));
Route::get('/currency_exchange/view/{id}',array('before'=>'auth','uses'=>'CurrencyExchangeController@view_currencyexchange'));
Route::get('/currency_exchange/{id}',array('before'=>'auth','uses'=>'CurrencyExchangeController@edit_currencyexchange'));
Route::post('/currency_exchange/showmonths', 'CurrencyExchangeController@showbymonths');

//Currency Country
Route::get('/currency_country',array('before'=>'auth','uses'=>'CurrencyCountryController@show_countrycurrency'));
Route::get('/currency_country/create',array('before'=>'auth','uses'=>'CurrencyCountryController@create_form'));
Route::post('/currency_country/create',array('before'=>'auth','uses'=>'CurrencyCountryController@store'));


Route::post('/currency_country/delete_countrycurrency',array('before'=>'auth','uses'=>'CurrencyCountryController@delete_countrycurrency'));
Route::post('/currency_country/edit',array('before'=>'auth','uses'=>'CurrencyCountryController@save_edit'));
Route::get('/currency_country/view/{id}',array('before'=>'auth','uses'=>'CurrencyCountryController@view_countrycurrency'));
Route::get('/currency_country/{id}',array('before'=>'auth','uses'=>'CurrencyCountryController@edit_countrycurrency'));

// Settings
Route::get('/settings',array('uses'=>'SettingsController@showsettings'));
Route::post('/settings',array('uses'=>'SettingsController@savesettings'));

//product status
Route::get('/product_status',array('before'=>'auth','uses'=>'ProductStatusController@show_productstatus'));

