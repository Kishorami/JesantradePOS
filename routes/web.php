<?php

use Illuminate\Support\Facades\Route;
// use DB;
// use Controller;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login');
});

//Auto Login-------------------------------------------------------------
Route::group(['middleware' => ['web']], function () {
    Route::get('autologin', function () {
    	$Uemail = $_GET['email'];
    	$id = DB::table('users')->where('email',$Uemail)->first();

        // $user = $_GET['id'];
        if ($id !=null) {
        	$user = $id->id;
        	Auth::loginUsingId($user, true);
        }
        return redirect()->intended('/dashboard');
    });
});
//Auto Login-------------------------------------------------------------



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $Sessionid=Auth::id();
$Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
$role = $Sessionuser->role;
  if ($role ==3){
    $product=DB::table('products')
                ->join('categories','products.category_id','categories.id')
                ->select('categories.category_name','products.*')
                ->get();
        $customer = DB::table('customers')->get();
        $category = DB::table('categories')->get();
        return view('pos',compact('product','customer','category'));
  }
  else{
    // return view('home_report');
    return redirect()->route('homereport');
  }
    
})->name('dashboard');


Route::get('/test', 'TestController@Index')->name('test');
Route::get('/showdata', 'TestController@ShowData')->name('showdata');

//User Section
Route::get('/users', 'UserController@index')->name('users');
Route::post('add-user', 'UserController@StoreUser');
Route::get('edit-user/{id}', 'UserController@EditUser');
Route::post('/update-user/{id}', 'UserController@UpdateUser');
Route::get('/delete-user/{id}', 'UserController@DeleteUser');

//Category Section
Route::get('/categories', 'CategoryController@index')->name('categories');
Route::post('add-category', 'CategoryController@StoreCategory');
Route::get('edit-category/{id}', 'CategoryController@EditCategory');
Route::post('/update-category/{id}', 'CategoryController@UpdateCategory');
Route::get('/delete-category/{id}', 'CategoryController@DeleteCategory');


//Product Section
Route::get('/all_products', 'ProductController@index')->name('all_products');
Route::resource('products','ProductController');
Route::get('all_products/{id}/edit/','ProductController@edit');
Route::post('print-barcode', 'ProductController@barcode');
// Route::get('all_products/{id}/show/','ProductController@show');
Route::get('order_products','ProductController@OrderProducts')->name('order_products');


//Suppliers Section
Route::get('/all_suppliers', 'SupplierController@index')->name('all_suppliers');
Route::resource('suppliers','SupplierController');
Route::get('suppliers/{id}/edit/','SupplierController@edit');

//Supplies Section
Route::get('/all_supplies', 'SuppliesController@index')->name('all_supplies');
Route::resource('supplies','SuppliesController');
Route::get('supplies/{id}/edit/','SuppliesController@edit');


//Customers Section
Route::get('/all_customers', 'CustomerController@index')->name('all_customers');
Route::resource('customers','CustomerController');
Route::get('customers/{id}/edit/','CustomerController@edit');



//POS Section
Route::get('pos-page', 'PosController@Index')->name('pos-page');
Route::post('/cart-add', 'PosController@AddCart');
Route::post('/cart-update/{rowId}', 'PosController@UpdateCart');
Route::post('/cart-updateprice/{rowId}', 'PosController@UpdateCartPrice');
Route::get('/cart-remove/{rowId}', 'PosController@removeCart');

Route::post('/cart-add-barcode', 'PosController@AddCartBarcode');

Route::get('taxes', 'PosController@changetaxes')->name('taxes');
Route::post('/update-tax', 'PosController@Updatetax');

Route::post('/change_currency', 'PosController@UpdateCurrency');

Route::get('hold-cart', 'PosController@HoldCart')->name('hold-cart');
Route::get('clear-cart', 'PosController@clearCart')->name('clear-cart');

Route::post('show.invoice', 'PosController@PrintBill')->name('show.invoice');


Route::post('/insert-customer-pos', 'PosController@AddCustomer');


//Sales Section
Route::get('sales', 'SalesController@Index')->name('sales');
Route::get('edit-sale/{id}', 'SalesController@EditSales');
Route::post('update-sale/{id}', 'SalesController@UpdateSales');

Route::get('print-invoice/{id}', 'SalesController@PrintInvoice');
Route::get('delete-sale/{id}', 'SalesController@DeleteSale');



//Allreports Section

Route::get('all_reports', 'ReportsController@Index')->name('all_reports');
Route::post('all_reports', 'ReportsController@Index');
Route::get('all_ProductsDownload', 'ReportsController@PrintAllProduct')->name('all_ProductsDownload');

// Route::get('all_reports', 'ReportsController@Index')->name('all_reports');
Route::post('all_SalesReport', 'ReportsController@SalesReport');
Route::get('all_SalesReportDownload', 'ReportsController@PrintAllSales')->name('all_SalesReportDownload');

// Route::get('all_reports', 'ReportsController@Index')->name('all_reports');
Route::post('all_CustomersReport', 'ReportsController@CustomersReport');
Route::get('all_CustomersReportDownload', 'ReportsController@PrintAllCustomers')->name('all_CustomersReportDownload');
Route::post('all_ProfitsReport', 'ReportsController@ProfitsReport');
Route::get('all_ProfitsReportDownload', 'ReportsController@PrintAllProfits')->name('all_ProfitsReportDownload');


//refund Section
Route::get('/refunds', 'RefundController@index')->name('refunds');
Route::post('add-refunds', 'RefundController@StoreRefund');
Route::get('view-refunds/{id}', 'RefundController@ViewRefund');
Route::post('/update-refunds/{id}', 'RefundController@UpdateRefund');
Route::get('/delete-refunds/{id}', 'RefundController@DeleteRefund');



//Due Section
Route::get('dues', 'SalesController@DueIndex')->name('dues');
// Route::get('edit-sale/{id}', 'SalesController@EditSales');
// Route::post('update-sale/{id}', 'SalesController@UpdateSales');
// Route::get('print-invoice/{id}', 'SalesController@PrintInvoice');
// Route::get('delete-sale/{id}', 'SalesController@DeleteSale');

// Expenses Section

Route::get('/all_expenses', 'ExpensesController@index')->name('all_expenses');
Route::resource('expenses','ExpensesController');
Route::get('expenses/{id}/edit/','ExpensesController@edit');

// Hold Section

Route::get('hold', 'HoldController@HoldIndex')->name('hold');

Route::post('hold.invoice', 'HoldController@HoldOrder')->name('hold.invoice');
Route::get('print-holds/{id}', 'HoldController@PrintHolds');
Route::get('edit-holds/{id}', 'HoldController@EditHold');
Route::post('update-hold/{id}', 'HoldController@Updatehold');
Route::get('delete-hold/{id}', 'HoldController@DeleteHold');

// Commissions Section

Route::get('/all_commissions', 'CommissionsController@index')->name('all_commissions');
Route::resource('commissions','CommissionsController');
Route::get('commissions/{id}/edit/','CommissionsController@edit');


// Profits Section

Route::get('profits/{id}','ProfitController@View');


//Quotation Section
Route::get('quotation-page', 'QuotationController@Index')->name('quotation-page');
Route::post('/quotation-cart-add', 'QuotationController@AddCart');
Route::post('/quotation-cart-update/{rowId}', 'QuotationController@UpdateCart');
Route::post('/quotation-cart-updateprice/{rowId}', 'QuotationController@UpdateCartPrice');
Route::get('/quotation-cart-remove/{rowId}', 'QuotationController@removeCart');

// Route::post('/cart-add-barcode', 'QuotationController@AddCartBarcode');

// Route::get('taxes', 'QuotationController@changetaxes')->name('taxes');
// Route::post('/update-tax', 'QuotationController@Updatetax');

// Route::post('/change_currency', 'QuotationController@UpdateCurrency');

// Route::get('hold-cart', 'QuotationController@HoldCart')->name('hold-cart');
Route::get('quotation-clear-cart', 'QuotationController@clearCart')->name('quotation-clear-cart');

Route::post('quotation-show.invoice', 'QuotationController@PrintBill')->name('quotation-show.invoice');

Route::post('/quotation-insert-customer-pos', 'QuotationController@AddCustomer');




// Changedparts Section

Route::get('/all_changed_parts', 'PartsController@index')->name('all_changed_parts');
Route::resource('changed_parts','PartsController');
Route::get('changed_parts/{id}/edit/','PartsController@edit');



Route::get('/our_backup_database', 'PartsController@our_backup_database')->name('our_backup_database');


Route::get('/homereport', 'HomeReportController@index')->name('homereport');
Route::post('customHome', 'HomeReportController@index');


Route::get('/colours', 'ColourController@index')->name('colours');
Route::post('side_colour', 'ColourController@SideColour');
Route::post('nav_colour', 'ColourController@NavColour');

