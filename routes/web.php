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

/*Route::get('/', function () {
    return view('index');
});*/

/*
 * Account
 * */
Route:: get('/', 'AuthController@showLoginForm');
Route:: post('login_user', 'AuthController@userLogin');
Route:: get('logout', 'AuthController@userLogout');



Route:: get('/home', 'AccountController@userHome');
Route:: get('register_user', 'AccountController@showRegisterPage');
Route:: post('create-new-user', 'AccountController@registerUser');
Route:: get('show-accounts', 'AccountController@showAccount');
Route:: get('create-group', 'AccountController@createGroupForm');
Route:: post('create-new-group', 'AccountController@createGroup');
Route:: get('create-ledger', 'AccountController@createLedgerForm');
Route:: post('create-new-ledger', 'AccountController@createLeder');
Route:: get('get-tree', 'AccountController@getTree');

Route:: get('edit-group/{group_id}', 'AccountController@editGroup');
Route:: post('edit-group-info', 'AccountController@editGroupInfo');
Route:: get('delete-group/{group_id}', 'AccountController@deleteGroup');
Route:: get('edit-ledger/{ledger_id}', 'AccountController@editLedger');
Route:: post('edit-ledger-info', 'AccountController@editLedgerInfo');
Route:: get('delete-ledger/{ledger_id}', 'AccountController@deleteLedger');


//Route:: get('add_category', 'TestCategoryController@showCategoryForm');

/*
 * Entries
 * */
Route:: get('/entries', 'AccountController@newEntries');
Route:: post('/create-new-entry', 'AccountController@createEntries');

/*
 * Rreports
 * */
Route:: get('/balance-sheet', 'AccountController@showBalanceSheet');
Route:: get('/profit-loss', 'AccountController@showProfitLoss');
Route:: get('/trial-balance', 'AccountController@showTrialBalance');


Route:: get('/ledger-statement', 'AccountController@showLedgerStatement');
Route:: get('/get_ledger_statement/{ledger_id}/{start_date}/{end_date}', 'AccountController@getLedgerStatement');
Route:: get('/view-details/{type}/{entry_id}', 'AccountController@getLedgerStatementDetails');
Route:: get('/edit-entry/{type}/{entry_id}', 'AccountController@editEntryForm');
Route:: post('/edit-entry-info', 'AccountController@editEntryInfo');
Route:: post('/edit-payment-entry', 'AccountController@editPaymentEntry');
Route:: post('/edit-receipt-entry', 'AccountController@editReceiptEntry');
Route:: post('/edit-contra-entry', 'AccountController@editContraEntry');
Route:: post('/edit-journal-entry', 'AccountController@editJournalEntry');
Route:: get('/delete-entry/{type}/{entry_id}', 'AccountController@deleteEntry');


Route:: get('/ledger-entries', 'AccountController@showLedgerEntries');
Route:: get('/process', 'AccountController@makeProcess');

/*
 * create edit delete bank ledgers
 * */
Route:: get('/create-bank', 'AccountController@showCreateBankForm');
Route:: post('/create-new-bank', 'AccountController@createNewBank');
Route:: get('/edit-bank/{id}', 'AccountController@showEditBankForm');
Route:: get('/delete-bank/{id}', 'AccountController@deleteBank');
Route:: post('/edit-bank-info', 'AccountController@editBankInfo');


/*
 * create edit delete client ledgers
 * */
Route:: get('/create-doctor', 'AccountController@showCreateClientForm');
Route:: post('/create-new-client', 'AccountController@createNewClient');
Route:: get('/edit-doctor/{id}', 'AccountController@showEditClientForm');
Route:: get('/delete-client/{id}', 'AccountController@deleteClient');
Route:: post('/edit-client-info', 'AccountController@editClientInfo');

/*
 * create edit delete expense ledgers
 * */
Route:: get('/create-expense', 'AccountController@showCreateExpenseForm');
Route:: post('/create-new-expense', 'AccountController@createNewExpense');
Route:: get('/edit-expense/{id}', 'AccountController@showEditExpenseForm');
Route:: get('/delete-expense/{id}', 'AccountController@deleteExpense');
Route:: post('/edit-expense-info', 'AccountController@editExpenseInfo');

/*
 * create edit delete income ledgers
 * */
Route:: get('/create-income', 'AccountController@showCreateIncomeForm');
Route:: post('/create-new-income', 'AccountController@createNewIncome');
Route:: get('/edit-income/{id}', 'AccountController@showEditIncomeForm');
Route:: get('/delete-income/{id}', 'AccountController@deleteIncome');
Route:: post('/edit-income-info', 'AccountController@editIncomeInfo');

/*
 * create edit delete liability
 * */
Route:: get('/create-liability', 'AccountController@showCreateLiabilityForm');
Route:: post('/create-new-liability', 'AccountController@createNewLiability');
Route:: get('/edit-liability/{id}', 'AccountController@showEditLiabilityForm');
Route:: get('/delete-liability/{id}', 'AccountController@deleteLiability');
Route:: post('/edit-liability-info', 'AccountController@editLiabilityInfo');


/*
 * daily-receive-payments reports
 * */
Route:: get('/daily-receive-payments', 'AccountController@showBalancePaymentReceiveForm');
Route:: post('/receive-payments-report', 'AccountController@showBalancePaymentReceive');



Route:: get('/selected-receive-payments', 'AccountController@showSelectedReceiptPaymentReportForm');
Route:: post('/selected-receive-payments', 'AccountController@selectedReceiptPaymentReport');

Route:: get('/all-receive-payments-details', 'AccountController@showAllReceiptPaymentDetailsForm');
Route:: post('/all-receive-payments-details', 'AccountController@allReceiptPaymentDetails');



/*
 * search income statement
 * */
Route:: get('/search-income-statement', 'AccountController@showIncomeStatementForm');
Route:: post('/search-income-statement', 'AccountController@incomeStatementReport');



Route:: get('/transaction-list', 'AccountController@showTransactionListingForm');
Route:: post('/transaction-list', 'AccountController@showTransactionListing');


Route:: get('/search-trial-balance', 'AccountController@showTrialBalanceForm');
Route:: post('/search-trial-balance', 'AccountController@showTrialBalanceReport');


Route:: get('/cash-book', 'AccountController@showCashBookForm');

Route:: get('/notes-to-the-accounts', 'AccountController@showNotesToAccForm');
Route:: get('/get_heads', 'AccountController@showHeadNames');
Route:: post('/notes-to-the-accounts', 'AccountController@showNotesToAccReport');




Route:: get('/topsheet', 'ReportController@showTopsheetForm');
Route:: post('/topsheet', 'ReportController@showTopsheet');
Route::get('/get_bill_info','ReportController@getBillInfo');


/*
 *
 * Inventory
 *
 * */

//product entry panel ..
Route::get('add_test','productController@index');
Route::post('add_product','productController@store');
Route::get('product_list','productController@productList');
Route::get('product_edit/{id}','productController@show');
Route::post('update_product','productController@update');
Route::get('product_delete/{id}','productController@destroy');
Route::get('product_show/{id}','productController@showById');
Route::get('product_status','productController@getStatus');
Route::get('edit-test/{id}','productController@editTest');
Route::post('edit_product','productController@editProduct1');
Route::get('delete-test/{id}','productController@deleteTest');

//category panel ....
Route::get('test_category','categoryController@index');
Route::post('category_value','categoryController@store');
Route::get('getCatId/{id}','categoryController@show');
Route::post('update_category','categoryController@update');
Route::get('/delete_Id/{id}','categoryController@destroy');


//supplier panel ...
Route::get('add_supplier','supplierController@index');
Route::post('add_supplier','supplierController@store');
Route::get('supplier_list','supplierController@showSupplier');
Route::get('supplier_show/{id}','supplierController@showById');
Route::get('supplier_edit/{id}','supplierController@editById');
Route::post('supplier_edit','supplierController@update');
Route::get('supplier_delete/{id}','supplierController@destroy');
Route::get('supplier_payment','supplierController@payment');
Route::get('supplier_payment_view/{id}','supplierController@paymentView');

// Warehouse panel
Route::get('add_warehouse','WarehouseController@index');
Route::post('add_warehouse','WarehouseController@store');
Route::get('warehouse_list','WarehouseController@showWareHouseList');
Route::get('warehouse_edit/{id}','WarehouseController@editById');
Route::post('warehouse_edit','WarehouseController@update');
Route::get('warehouse_delete/{id}','WarehouseController@destroy');
Route::get('transfer_product','WarehouseController@showWarehouseTransfer');
Route::get('get_transfer_memos_by_date','ajaxController@getTransferMemosByDate');
Route::post('edit_transfer_info','WarehouseController@showTransferProductForm');
Route::post('edit_transfer','WarehouseController@showTransferProductInfo');
Route::get('get_qt_per_carton','WarehouseController@getQtPerCarton');
Route::post('transfer_product','WarehouseController@transferProduct');
Route::get('get_products','WarehouseController@getProductsByCatagory');
Route::get('available_products','WarehouseController@getAvailableProductsList');


//purchase controller section ....
Route::get('purchase_entry','purchaseController@index');
//Route::post('purchase_entry','purchaseController@entryValue');
Route::post('purchase_entry','purchaseController@entryPurchase');
Route::get('get_purchase_memos_by_date','ajaxController@getPurchaseMemosByDate');
Route::post('get_memo_info','purchaseController@getPurchaseMemosInfo');
Route::get('edit_purchase_info/{id}','purchaseController@editPurchaseInfoForm');
Route::post('edit_purchase','purchaseController@editPurchaseInfo');
Route::get('purchase_list','purchaseController@purchaseList');
Route::get('purchase_return','purchaseController@purchaseReturn');
Route::get('get_purchase_return_memos_by_date','ajaxController@getPurchaseReturnMemosByDate');
Route::post('get_memo_info_purchase_return','purchaseController@showPurchaseReturnMemoInfo');
Route::post('edit_purchase_return_info','purchaseController@editPurchaseReturnInfo');
Route::post('purchase_return','purchaseController@entryPurchaseReturn');
//Route::post('purchase_return','purchaseController@purchaseReturnEntry');
Route::post('add_supplier1','purchaseController@addSupplier');
Route::get('show_purchase_Byid/{id}','purchaseController@purchaseById');
Route::get('print_purchase_report/{id}','purchaseController@printPurchaseById');
Route::get('purchase_return_list','purchaseController@returnList');
Route::get('return_view/{id}','purchaseController@returnViewList');
Route::get('print_purchase_return_report/{id}','purchaseController@returnViewPrint');


//ajax controller section
Route::post('getProductName','ajaxController@productName');
Route::post('getRate','ajaxController@productRate');
Route::post('getQuantityPerCarton','ajaxController@quantityPerCarton');
Route::post('getAvailableQt','ajaxController@getAvailableQuantity');

//Route::post('getAvailableQt','ajaxController@getAvailableQuantity');


//sale section here ....
Route::get('create_test_memo','sellController@index');
Route::get('edit_sale','sellController@editSaleForm');
Route::post('edit_sale','sellController@editSale');
Route::get('get_memos_by_date','ajaxController@getMemosByDate');
Route::get('get_info_by_memo','ajaxController@getInfoByMemos');
//Route::post('create_sell','sellController@storeSell');
Route::post('create_sell','sellController@storeSellProduct');
Route::get('get_client_info','sellController@getClientInfo');
Route::post('add_client','sellController@createClient');
Route::get('sale_list','sellController@sellList');
Route::get('sell_view_by/{id}','sellController@sellInfoById');
//Route::get('sell_view_by/{id}','sellController@sellViewById');
Route::get('customer_copy_bill/{id}','sellController@showBill');
Route::get('office_copy_bill/{id}','sellController@showOfficeCopy');
Route::get('edit_memo/{id}','sellController@editMemoForm');
Route::get('edit_memo/{id}','sellController@editMemoForm');
Route::post('edit_sale','sellController@editSale');
Route::post('edit_memo','sellController@editMemo');
Route::get('print_salcash-booke_report/{id}','sellController@printBill');
//Route::get('show_bill/{id}','sellController@Bill');
Route::get('sale_return','sellController@saleReturn');
Route::post('sale_return','sellController@storeSaleReturn');
Route::get('get_sale_return_memos_by_date','ajaxController@getSaleReturnMemosByDate');
Route::post('get_memo_info_sale_return','sellController@getSaleReturnMemoInfo');
Route::post('edit_memo_info_sale_return','sellController@editSaleReturnMemoInfo');
Route::get('sale_return_list','sellController@returnList');
Route::get('view_bill/{id}','sellController@viewBill');
Route::get('print_bill_report/{id}','sellController@printBill');
Route::get('print_office_copy_report/{id}','sellController@printOfficeBill');
Route::get('print_sale_return_report/{id}','sellController@printReturnBill');
Route::get('return_challan/{id}','sellController@returnChallan');


// LC informations
Route::get('create_lc','LcController@index');
Route::post('create_lc','LcController@storeIcInfo');
Route::get('all_lc','LcController@getLcList');
Route::get('lc_show/{id}','LcController@showLcInfo');
Route::get('lc_edit/{id}','LcController@editLcForm');
Route::post('update_lc','LcController@editLc');
Route::get('lc_delete/{id}','LcController@deleteLC');


// stock reports
Route::get('closing_stock','StockReports@closingStockForm');
Route::post('closing_stock','StockReports@closingStockReport');

Route::get('storewise_closing_stock_with_rate','StockReports@StoreWiseClosingStockWithRateForm');
Route::post('storewise_closing_stock_with_rate','StockReports@StoreWiseClosingStockWithRateReport');

Route::get('item_details','StockReports@itemDetailsReport');
Route::get('warehouse_wise_stock','StockReports@warehouseWiseStockReport');

Route::get('item_stock','StockReports@itemStockForm');
Route::post('item_stock','StockReports@itemStockReport');

Route::get('catagory_wise_item_stock','StockReports@catagoryWiseItemStockForm');
Route::post('catagory_wise_item_stock','StockReports@catagoryWiseItemStockReport');

Route::get('closing_stock_store_wise','StockReports@closingStockStoreWiseForm');
Route::post('closing_stock_store_wise','StockReports@closingStockStoreWiseReport');

Route::get('lc_info','StockReports@lcInfoForm');
Route::post('lc_info','StockReports@lcInfoReport');

Route::get('party_wise_sales','StockReports@partyWiseSalesForm');
Route::post('party_wise_sales','StockReports@partyWiseSalesReport');

Route::get('party_wise_summerized_sales','StockReports@partyWiseSummerizedSalesForm');
Route::post('party_wise_summerized_sales','StockReports@partyWiseSummerizedSalesReport');

Route::get('party_wise_summerized_statement','StockReports@partyWiseSummerizedStatementForm');
Route::post('party_wise_summerized_statement','StockReports@partyWiseSummerizedStatementReport');

Route::get('sale_statement','StockReports@saleStatementForm');
Route::post('sale_statement','StockReports@saleStatementReport');

Route::get('sales_or_purchase_statement','StockReports@salePurchaseStatementForm');
Route::post('sales_or_purchase_statement','StockReports@salePurchaseStatementReport');

Route::get('item_register','StockReports@ItemRegisterForm');
Route::post('item_register','StockReports@ItemRegisterReport');

Route::get('quantity_wise_item_register','StockReports@quantityWiseItemRegisterForm');
Route::post('quantity_wise_item_register','StockReports@quantityWiseItemRegisterReport');


Route::get('store_wise_item_register','StockReports@storeWiseItemRegisterForm');
Route::post('store_wise_item_register','StockReports@storeWiseItemRegisterReport');

Route::get('summarized_sale_item','StockReports@summarizedSaleItemForm');
Route::post('summarized_sale_item','StockReports@summarizedSaleItemReport');



/*
 * PROBLEM
 * */
Route::get('sale_purchase_return_summarized','StockReports@salePurchaseReturnSummarizedForm');
Route::post('sale_purchase_return_summarized','StockReports@salePurchaseReturnSummarizedReport');

Route::get('sale_purchase_return_party_wise','StockReports@salePurchaseReturnPartyWiseForm');
Route::post('sale_purchase_return_party_wise','StockReports@salePurchaseReturnPartyWiseReport');

Route::get('closing_stock_and_value','StockReports@closingStockAndValueForm');
Route::post('closing_stock_and_value','StockReports@closingStockAndValueReport');


Route::get('sale_purchase_transfer_return','StockReports@salePurchaseReturnTransferForm');
Route::get('get_all_suppliers','ajaxController@getAllSuppliers');
Route::get('get_all_clients','ajaxController@getAllClients');
Route::get('get_all_warehouses','ajaxController@getAllWarehouses');
Route::post('sale_purchase_transfer_return','StockReports@salePurchaseReturnTransferReport');


Route::get('store_wise_closing_stock','StockReports@storeWiseClosingStockForm');
Route::post('store_wise_closing_stock','StockReports@storeWiseClosingStockReport');
Route::get('storewise_stock_purchase/{from_date}/{to_date}/{warehouse_id}','StockReports@storewiseStockPurchase');
Route::get('storewise_stock_purchase_return/{from_date}/{to_date}/{warehouse_id}','StockReports@storewiseStockPurchaseReturn');
Route::get('storewise_stock_sale/{from_date}/{to_date}/{warehouse_id}','StockReports@storewiseStockSale');
Route::get('storewise_stock_sale_return/{from_date}/{to_date}/{warehouse_id}','StockReports@storewiseStockSaleReturn');
Route::get('storewise_stock_in/{from_date}/{to_date}/{warehouse_id}','StockReports@storewiseStockIn');
Route::get('storewise_stock_out/{from_date}/{to_date}/{warehouse_id}','StockReports@storewiseStockOut');





Route::get('summarized_items','StockReports@summarizedItemsForm');
Route::post('summarized_items','StockReports@summarizedItemsReport');
Route::get('summarized_items_purchase/{from_date}/{to_date}/{cat_id}/{warehouse_id}','StockReports@summarizedItemsPurchase');
Route::get('summarized_items_purchase_return/{from_date}/{to_date}/{cat_id}/{warehouse_id}','StockReports@summarizedItemsPurchaseReturn');
Route::get('summarized_items_sale/{from_date}/{to_date}/{cat_id}/{warehouse_id}','StockReports@summarizedItemsSale');
Route::get('summarized_items_sale_return/{from_date}/{to_date}/{cat_id}/{warehouse_id}','StockReports@summarizedItemsSaleReturn');
Route::get('summarized_items_in/{from_date}/{to_date}/{cat_id}/{warehouse_id}','StockReports@summarizedItemsIn');
Route::get('summarized_items_out/{from_date}/{to_date}/{cat_id}/{warehouse_id}','StockReports@summarizedItemsOut');



Route::get('store_wise_closing_stock_value','StockReports@storeWiseClosingStockValueForm');
Route::post('store_wise_closing_stock_value','StockReports@storeWiseClosingStockValueReport');









