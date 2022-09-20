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

/* artisan command */
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'cache clear';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'config:cache';
});
Route::get('/view-cache', function() {
    $exitCode = Artisan::call('view:cache');
    return 'view:cache';
});
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'view:clear';
});
/* artisan command */


Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Route::group(['middleware'=>['auth','users']], function (){

    Route::get('/user/dashboard','UserDashboardController@dashboard' )->name('user.dashboard');
    Route::get('/user/edit-profile','UserDashboardController@editProfile' )->name('user.edit.profile');
    Route::post('/user/update-profile', 'UserDashboardController@updateProfile')->name('update.profile');
    Route::get('change-password','UserDashboardController@changedPassword')->name('password.change');
    Route::post('change-password-update','UserDashboardController@changedPasswordUpdated')->name('password.change_password_update');
    Route::get('/product-history', 'UserDashboardController@productHistory' )->name('product.history');
    Route::get('/product-details/{id}', 'UserDashboardController@productDetails' )->name('product.details');
    Route::get('/service-list/{id}', 'UserDashboardController@serviceList' )->name('service.list');
    Route::post('/status', 'UserDashboardController@status')->name('status');

    Route::get('/invoice', 'UserDashboardController@invoice')->name('invoice');
    Route::post('/invoice-details', 'UserDashboardController@invoiceDetails')->name('invoice.details');

    //reset Password
    Route::get('reset-password','VerificationController@getPhoneNumber')->name('user.reset.password');
    Route::post('otp-store','VerificationController@checkPhoneNumber')->name('phone.check');
    Route::post('change-password','VerificationController@otpStore')->name('otp.store');
    Route::post('new-password/update/{id}','VerificationController@passwordUpdate')->name('reset.password.update');

//});

Route::group(['middleware' => ['auth']], function() {
        Route::get('change-password/{id}','UserController@changedPassword')->name('password.change_password');
        Route::post ('change-password-update','UserController@changedPasswordUpdated')->name('password.change_password_update');

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('stores','StoreController');
    Route::resource('stores','StoreController');
    Route::resource('productCategories','ProductCategoryController');
    Route::resource('productSubCategories','ProductSubCategoryController');
    Route::resource('productBrands','ProductBrandController');
    Route::resource('productUnit','ProductUnitController');
    Route::resource('products','ProductController');
    Route::resource('free-products','FreeProductController');
    Route::resource('party','PartyController');
    Route::resource('productPurchases','ProductPurchaseController');
    Route::resource('productSales','ProductSaleController');
    Route::resource('productWholeSales','ProductWholeSaleController');
    Route::resource('productSaleReturns','ProductSaleReturnController');
    Route::resource('productPurchaseReturns','ProductPurchaseReturnController');
    Route::resource('officeCostingCategory','OfficeCostingCategoryController');
    Route::resource('expenses','ExpenseController');
    Route::resource('productPurchaseRawMaterials','ProductPurchaseRawMaterialsController');
    Route::resource('productProductions','ProductProductionController');
    Route::resource('productSaleReplacement','ProductSaleReplacementController');
    Route::resource('service','ServiceController');
    Route::resource('offers','OfferController');
    Route::resource('customer_complain','CustomerComplainController');
    Route::resource('online_platform','OnlinePlatFormController');
    Route::resource('account/ChartOfAccount','ChartOfAccountController');
    Route::resource('Ledger','LedgerController');
    Route::resource('postingForm','PostingFormController');
    Route::get('ledger-data','PostingFormController@ledgerRelationData');
    Route::get('ledger-data-group2','PostingFormController@group2RelationData');
    Route::resource('deliveryService','DeliveryServiceController');
    Route::resource('stockTransfers','StockTransferController');

    Route::get('customer_complain_complete/{id}','CustomerComplainController@complainDone')->name('customer_complain.complete');
    Route::post('customer_complain_complete/{id}','CustomerComplainController@complainComplete')->name('customer_complain_complete');

    Route::get('stock-transfer-invoice/{id}','StockTransferController@invoice')->name('stock.transfer.invoice');
    Route::get('stock-transfer-invoice-print/{id}','StockTransferController@invoicePrint')->name('stock.transfer.invoice.print');

    Route::get('account/posting-edit/{voucher_type_id}/{voucher_no}','PostingFormController@postingEdit');
    Route::post('account/posting-form-update/{voucher_type_id}/{voucher_no}','PostingFormController@postingUpdate');
    Route::get('account/posting-invoice/{voucher_type_id}/{voucher_no}','PostingFormController@voucher_invoice');
    Route::post('account/posting-delete/{voucher_type_id}/{voucher_no}/{id}','PostingFormController@postingDelete');

    //new account route
    Route::get('account/general-ledger','LedgerController@general_ledger_form')->name('account.general.ledger');
    Route::post('account/general-ledger-view','LedgerController@view_general_ledger')->name('account.general.ledger_view');
    Route::get('account/general-ledger-invoice/{date_from}/{date_to}','LedgerController@general_ledger_print');
    Route::get('account/trial/balance','TrialBalanceController@trial_balance_form');
    Route::post('account/trial-balance-view','TrialBalanceController@view_trial_balance')->name('account.trial_balance_view');
    Route::get('account/trial-balance-print/{date_from}/{date_to}','PostingController@trial_balance_print');
    Route::get('/account/income/statement','IncomeStatementController@incomeSatetment');
    Route::post('account/income/statement-view','IncomeStatementController@view_incomeSatetment')->name('account.income_statement_view');
    Route::get('account/income/statement-view-print/{date_from}/{date_to}','IncomeStatementController@income_statement_print');
    Route::get('/account/equity','EquityController@equityForm');
    Route::post('account/equity/view','EquityController@viewEquity')->name('account.equity-view');
    Route::get('/account/balance/sheet','BalanceSheetController@balanceSheetForm');
    Route::post('account/balance-sheet/view','BalanceSheetController@viewBalanceSheet')->name('account.balance-sheet-view');
    Route::get('/account/cash-flow','CashflowController@cashflowForm');
    Route::post('account/cash-flow/view','CashflowController@viewCashFlow')->name('account.cash-flow-view');
    Route::get('account/cash-book','LedgerController@cashBook_form')->name('account.cash.book');
    Route::post('account/cash-book-view','LedgerController@view_cashBook')->name('account.general.cashbook_view');
    Route::get('account/bank-book','LedgerController@bankBook_form')->name('account.bank.book');
    Route::post('account/bank-book-view','LedgerController@view_bankBook')->name('account.general.bankbook_view');
    Route::get('account/receipt-payment','LedgerController@receiptPayment_form')->name('account.receipt.payment');
    Route::post('account/receipt-payment-view','LedgerController@view_receiptPayment')->name('account.receipt.payment_view');



    Route::get('/supplier','PartyController@supplier');
    Route::get('/whole-sale','PartyController@wholeCustomer');
    Route::get('check-name','ServiceController@checkName');
    Route::get('check-phone-number','PartyController@checkPhoneNumber');
    Route::get('check-phone-number-provider','PartyController@checkPhoneNumberProvider');
    Route::get('check-product-name','ProductController@checkProductName');
    Route::get('productPurchases-invoice/{id}','ProductPurchaseController@invoice')->name('productPurchases-invoice');
    Route::get('productPurchases-invoice-print/{id}','ProductPurchaseController@invoicePrint')->name('productPurchases-invoice-print');
    Route::get('productSales-invoice/{id}','ProductSaleController@invoice')->name('productSales-invoice');
    Route::get('productSales-Challaninvoice/{id}','ProductSaleController@Challaninvoice')->name('productSales-Challaninvoice');
    Route::get('productSales-invoice-print/{id}','ProductSaleController@invoicePrint')->name('productSales-invoice-print');
    Route::get('productSales-invoice-print-count-number','ProductSaleController@invoicePrintCountNumber')->name('productSales-invoice-print-count-number');
    Route::get('productSales-challan-invoice-print/{id}','ProductSaleController@ChallanPrint')->name('productSales-challan-invoice-print');
    Route::get('productSales-invoice-edit/{id}','ProductSaleController@invoiceEdit')->name('productSales-invoice-edit');
    Route::post('productSales-invoice-update/{id}','ProductSaleController@updateInvoice')->name('productSales.invoiceUpdate');
    Route::get('sub-category-list','ProductController@subCategoryList');
    Route::get('check-barcode','ProductController@checkBarcode');
    Route::get('product-relation-data','ProductPurchaseController@productRelationData');
    Route::get('product-sale-relation-data','ProductSaleController@productSaleRelationData');

    Route::get('product-Transfersale-relation-data','StockTransferController@productSaleRelationData');
    Route::get('product-wholeSale-relation-data','ProductWholeSaleController@productWholeSaleRelationData');
    Route::get('all-stock-sale-list','StockController@allStockList')->name('stock-purchase.allStock');
    Route::get('stock-details/{store_id}','StockController@stockDetails')->name('stock.details');
    Route::get('stock-sale-list','StockController@stockList')->name('stock.index');
    Route::get('stock-purchase-list','StockController@stockPurchaseList')->name('stock-purchase.index');
    Route::get('stock-summary-list','StockController@stockSummaryList')->name('stock.summary.list');

    Route::get('stock-purchase-list-details/{store_id}','StockController@stockPurchaseDetails')->name('stock.purchase.listDetails');
    Route::get('stock-sale-list-details/{store_id}','StockController@stockSaleDetails')->name('stock.sale.listDetails');
    // stock sync
    Route::get('stock_sync','StockController@stock_sync')->name('stock_sync');

    Route::get('stock-summary/{store_id}','StockController@stockSummary');
    Route::get('stock-summary-invoice/{store_id}','StockController@stockSummaryInvoice')->name('stock-summary-invoice');

    Route::get('stock-low-list','StockController@stockLowList')->name('stock.low.list');
    Route::get('stock-low-list-details/{store_id}','StockController@stockLowListDEtails')->name('stock.low.list.details');

    Route::get('returnable-sale-product-list','ProductSaleReturnController@returnableSaleProduct')->name('returnable.sale.product');
    Route::get('returnable-purchase-product-list','ProductPurchaseReturnController@returnablePurchaseProduct')->name('returnable.purchase.product');
    Route::post('sale-product-return','ProductSaleReturnController@saleProductReturn')->name('sale.product.return');
    Route::post('purchase-product-return','ProductPurchaseReturnController@purchaseProductReturn')->name('purchase.product.return');

    Route::get('transaction-store','TransactionController@transactionStore')->name('transaction.store');
    Route::get('transaction-list/{store_id}','TransactionController@transactionList')->name('transaction.index');

//    Route::get('transaction-list','TransactionController@transactionList')->name('transaction.index');


    Route::get('transaction-loss-profit-store','TransactionController@lossProfitStore')->name('transaction.lossProfit.store');
    Route::get('transaction-loss-profit-dup/{store_id}','TransactionController@lossProfitdup')->name('transaction.lossProfit.dup');


    Route::get('transaction-loss-profit','TransactionController@lossProfit')->name('transaction.lossProfit');
    Route::get('delivery-list','TransactionController@deliveryList')->name('delivery.index');
    Route::post('party/new-party','ProductSaleController@newParty')->name('parties.store.new');
    Route::post('party/supplier/new-party','ProductPurchaseController@newParty')->name('parties.supplier.store.new');
    Route::post('pay-due','ProductSaleController@payDue')->name('pay.due');
    Route::post('pay-purchase-due','ProductPurchaseController@payDue')->name('pay.purchase.due');
    Route::get('productSales-customer-due','ProductSaleController@customerDue')->name('productSales.customer.due');
    Route::post('party/new-office-costing-category','ExpenseController@newOfficeCostingCategory')->name('office.costing.category.new');
    Route::get('product-production-relation-data','ProductProductionController@productProductionRelationData');

    Route::get('stock-date-wise/{store_id}','StockController@stockDateWise')->name('stock.date.wise');


    Route::get('productPosSales/list','ProductPosSaleController@index')->name('productPosSales.index');
    Route::get('productPosSales','ProductPosSaleController@create')->name('productPosSales.create');
    Route::get('sale/{id}/data', 'ProductPosSaleController@listData')->name('sale.data');
    Route::get('sale/loadform/{discount}/{total}/{paid}', 'ProductPosSaleController@loadForm');

    Route::get('pos/print/{id}/{status}', 'PointOfSaleController@print')->name('pointOfSale.print');
    Route::get('pos/print_pos/{id}/{status}', 'PointOfSaleController@printPos')->name('pointOfSale.print2');

    Route::get('product-pos-sales-invoice/{id}/{status}','PointOfSaleController@invoicePos')->name('product.pos.sales-invoice');
    Route::get('product-pos-sales-invoice-print/{id}','PointOfSaleController@invoicePosPrint')->name('product.pos.Sales-invoice-print');


    Route::get('selectedform/{product_code}/{store_id}','ProductPosSaleController@selectedform');
    Route::get('add-to-cart','CartController@addToCart');
    Route::get('delete-cart-product/{rowId}','CartController@deleteCartProduct');
    Route::get('delete-all-cart-product','CartController@deleteAllCartProduct');
    Route::post('pos_insert', 'ProductPosSaleController@postInsert');


    Route::get('get-sale-product/{sale_id}','ProductSaleReplacementController@getSaleProduct');
    Route::get('get-returnable-product/{sale_id}','ProductSaleReturnController@getReturnableProduct');
    Route::get('get-returnable-purchase-product/{purchase_id}','ProductPurchaseReturnController@getReturnablePurchaseProduct');


    //add service
    Route::get('productSales-addServices/{id}','ProductSaleController@Addservice')->name('productSales-addServices');
    Route::post('productSales-storeServices','ProductSaleController@Storeservice')->name('productSales-store-services');
    Route::get('productSales-showServices/{id}','ProductSaleController@Showservice')->name('productSales-showServices');
    Route::get('productSales-editServices/{id}','ProductSaleController@Editservice')->name('productSales-editServices');
    Route::post('productSales-updateServices/{id}','ProductSaleController@Updateeservice')->name('productSales-update-services');
    //excel
    Route::get('export', 'UserController@export')->name('export');
    Route::get('importExportView', 'UserController@importExportView');
    Route::post('import', 'UserController@import')->name('import');

    Route::get('customer-export', 'PartyController@export')->name('customer.export');
    Route::get('customer-importExportView', 'PartyController@importExportView');
    Route::post('customer-import', 'PartyController@import')->name('customer.import');


    Route::get('transaction/export/', 'TransactionController@export')->name('transaction.export');
    Route::get('delivery/export/', 'TransactionController@deliveryExport')->name('delivery.export');
    Route::get('loss-profit/export/', 'TransactionController@lossProfitExport')->name('loss.profit.export');
    Route::get('loss-profit-filter-export/{start_date}/{end_date}','TransactionController@lossProfitExportFilter')->name('loss.profit.filter.export');
    Route::get('stock/export/', 'StockController@export')->name('stock.export');

    // custom start
    Route::post('/roles/permission','RoleController@create_permission');
    Route::post('/user/active','UserController@activeDeactive')->name('user.active');

    //monthly service list
    Route::get('monthly-service','ServiceController@monthlyService')->name('monthly.services');
    Route::get('completed-service','ServiceController@completedService')->name('completed.services');
    Route::post('send-sms','ServiceController@sendSMS')->name('send.mail');



    ///////////////////////////Account////////////////////////////////////////////



    Route::resource('voucherType','VoucherTypeController');
    Route::resource('posting','PostingController');

    //Route::post('pay-due','ServiceSaleController@payDue')->name('pay.due');

    Route::get('account/coa_print','AccountController@coa_print')->name('account.coa_print');
    Route::get('account/cashbook','AccountController@cash_book_form');
    Route::post('account/cashbook','AccountController@cash_book_form')->name('account.cashbook');
    Route::get('account/cashbook-print/{date_from}/{date_to}','AccountController@cash_book_print');

    //Route::get('account/voucher-invoice/{voucher_no}/{transaction_date}','TransactionController@voucher_invoice');
    Route::get('account/voucher-invoice/{voucher_type_id}/{voucher_no}','PostingController@voucher_invoice');
    Route::post('account/transaction-delete/{voucher_type_id}/{voucher_no}','PostingController@transactionDelete');
    Route::get('account/transaction-edit/{voucher_type_id}/{voucher_no}','PostingController@transactionEdit');
    Route::post('account/posting-update/{voucher_type_id}/{voucher_no}','PostingController@transactionUpdate');
    Route::get('account/generalledger','PostingController@general_ledger_form')->name('account.generalledger');
    Route::get('/get-transaction-head/{id}','AccountController@transaction_head');
   // Route::post('account/general-ledger','PostingController@view_general_ledger')->name('account.general_ledger');
  //  Route::get('account/general-ledger-print/{headcode}/{date_from}/{date_to}','PostingController@general_ledger_print');
    Route::get('account/trial-balance','PostingController@trial_balance_form');
    Route::get('account/trial-balance-print/{date_from}/{date_to}','PostingController@trial_balance_print');
    Route::post('account/trial-balance','PostingController@view_trial_balance')->name('account.trial_balance');
   // Route::get('account/balance-sheet','PostingController@balance_sheet');
   // Route::get('account/balance-sheet-print','PostingController@balance_sheet_print');

    Route::get('account/debit-voucher','AccountController@debit_voucher_form')->name('account.debit.voucher');
    Route::post('account/debit-voucher','AccountController@view_debit_voucher')->name('account.debit_voucher');
    Route::get('account/debit-voucher-print/{headcode}/{date_from}/{date_to}','AccountController@debit_voucher_print');


    Route::get('account/credit-voucher','AccountController@credit_voucher_form')->name('account.credit.voucher');
    Route::post('account/credit-voucher','AccountController@view_credit_voucher')->name('account.credit_voucher');
    Route::get('account/credit-voucher-print/{headcode}/{date_from}/{date_to}','AccountController@credit_voucher_print');

    Route::resource('accounts','AccountController');
    Route::get('selectedform/{id}','AccountController@selectedform');
    Route::get('newform/{id}','AccountController@newform');
    Route::post('insert_coa','AccountController@insert_coa');


//relation-data

    //Route::get('service-relation-data','ServiceSaleController@serviceRelationData');

   // Route::get('employeeSalary-relation-data','EmployeeSalaryController@employeeSalaryRelationData');

    Route::get('get-voucher-no','PostingController@getVoucherNo');
    Route::get('get-voucher-number','PostingFormController@getVoucherNumber');
    Route::get('get-voucher-number-edit','PostingFormController@getVoucherNumberEdit');



});
