<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController  as AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SalesPointController;
use App\Http\Controllers\admin\purchases\VendorsController;
use App\Http\Controllers\admin\finance\CategoryController;
use App\Http\Controllers\admin\finance\AssetsController;
use App\Http\Controllers\admin\finance\ExpenseCategoryController;
use App\Http\Controllers\admin\finance\ExpenseController;
use App\Http\Controllers\admin\finance\PendingChequesController;
use App\Http\Controllers\admin\finance\BankAccountsController;
use App\Http\Controllers\admin\warehouse\PartsController;
use App\Http\Controllers\admin\warehouse\CarsController;
use App\Http\Controllers\admin\automanagment\CarsMakeController;
use App\Http\Controllers\admin\automanagment\CarsModelController;
use App\Http\Controllers\admin\warehouse\PartsListController;
use App\Http\Controllers\admin\warehouse\PartsCategoryController;
use App\Http\Controllers\admin\automanagment\FeaturesLevelController;
use App\Http\Controllers\admin\automanagment\ClientsController;
use App\Http\Controllers\admin\purchases\PurchasesController;
use App\Http\Controllers\admin\finance\HistoryController;
use App\Http\Controllers\admin\finance\VendorPaymentController;
use App\Http\Controllers\admin\NotificationsController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\automanagment\CarsSubModelController;
use App\Http\Controllers\admin\CountriesController;
use App\Http\Controllers\admin\VatController;

// admin routes
Route::prefix("admin")->name("admin.")->group( function() {
	Route::group(['middleware' => 'admin.guest'], function(){
		Route::get('/login',[AdminLoginController::class, 'index'])->name('login');
		Route::post('/login',[AdminLoginController::class, 'authenticate'])->name('auth');
	});

	Route::group(['middleware' => 'admin.auth'], function(){
		Route::get('/dashboard', function(){
		    echo "welcome to admin dashboard";
		})->name('dashboard');

		Route::get('/logout',[AdminLoginController::class, 'logout'])->name('logout');	

	// 	Parts
    Route::get('/parts',[PartsController::class,'parts'])->name('parts');
    Route::post('/showParts',[PartsController::class,'show'])->name('showParts');
    Route::post('/getModels',[PartsController::class,'getModels'])->name('getModels');
    Route::post('/addParts',[PartsController::class,'add'])->name('addParts');
    Route::post('/editParts',[PartsController::class,'edit'])->name('editParts');
    Route::post('/e_getModelsPart',[PartsController::class,'e_getModelsPart'])->name('e_getModelsPart');
    Route::post('/updateParts',[PartsController::class,'update'])->name('updateParts');
    Route::post('/updateParts',[PartsController::class,'update'])->name('updateParts');
    Route::post('/partsMarkDelete',[PartsController::class,'partsMarkDelete'])->name('partsMarkDelete');
    Route::post('/deleteParts',[PartsController::class,'delete'])->name('deleteParts');
    Route::get('/showPartsNotifications',[PartsController::class,'showNotifications'])->name('showPartsNotifications');
    Route::post('/markAsRead',[PartsController::class,'markAsRead'])->name('markAsRead');
    // Parts end
    
    

// 	Purchases    
    Route::get('/purchases',[PurchasesController::class,'index'])->name('purchases');
    Route::get('/purchaseInvoice/{id}',[PurchasesController::class,'purchaseInvoice'])->name('purchaseInvoice');
    Route::post('/carsCodeAutoC/',[PurchasesController::class,'carsCodeAutoC'])->name('carsCodeAutoC');
    Route::post('/clientNameAutoC',[PurchasesController::class,'clientNameAutoC'])->name('clientNameAutoC');
    Route::post('/checkVendor',[PurchasesController::class,'checkVendor'])->name('checkVendor');
    Route::post('/showPurchases',[PurchasesController::class,'show'])->name('showPurchases');
    Route::get('/purchasesView',[PurchasesController::class,'purchasesView'])->name('purchasesView');
    Route::post('/addTablePurchase',[PurchasesController::class,'addTablePurchase'])->name('addTablePurchase');
    Route::post('/setCategoryDrop',[PurchasesController::class,'setCategoryDrop'])->name('setCategoryDrop');
    Route::post('/savePurchase',[PurchasesController::class,'savePurchase'])->name('savePurchase');
    Route::post('/checkPartCode',[PurchasesController::class,'checkPartCode'])->name('checkPartCode');
    Route::post('/checkCarCode',[PurchasesController::class,'checkCarCode'])->name('checkCarCode');
    Route::post('/addToTable',[PurchasesController::class,'addToTable'])->name('addToTable');
	Route::post('/deletePurchase',[PurchasesController::class,'delete'])->name('deletePurchase');
	Route::get('/editPurchaseOrder/{id}',[PurchasesController::class,'edit'])->name('editPurchaseOrder');
	Route::post('/updatePurchaseOrder',[PurchasesController::class,'updated'])->name('updatePurchaseOrder');
    Route::post('/addMakePayment',[PurchasesController::class,'addMakePayment'])->name('addMakePayment');  
	Route::post('/addVendorFromPurchase',[PurchasesController::class,'addVendorFromPurchase'])->name('addVendorFromPurchase');
       
    // purchases end

    //vendor payments
    // vendor payments


	// payments
	Route::get('/vendorPayments',[VendorPaymentController::class,'index'])->name('vendorPayments');
	Route::post('/PurchasePayments',[VendorPaymentController::class,'show'])->name('PurchasePayments');
	// Route::get('/addVendorPayments/{id}',[VendorPaymentController::class,'addVendorPayments'])->name('addVendorPayments');
	// payments

    // Vendors
	Route::get('/vendors',[VendorsController::class,'vendors'])->name('vendors');
	Route::post('/showVendors',[VendorsController::class,'show'])->name('showVendors');
	Route::post('/addVendors',[VendorsController::class,'add'])->name('addVendors');
	Route::post('/editvendors',[VendorsController::class,'edit'])->name('editvendors');
	Route::post('/updateVendors',[VendorsController::class,'update'])->name('updateVendors');
	Route::post('/deleteVendors',[VendorsController::class,'delete'])->name('deleteVendors');
    // Vendors End
    
    // 	Finance
	// Category
	Route::get('/category',[CategoryController::class,'category'])->name('category');
	Route::post('/showCategory',[CategoryController::class,'show'])->name('showCategory');
	Route::post('/addCategory',[CategoryController::class,'add'])->name('addCategory');
	Route::post('/editCategory',[CategoryController::class,'edit'])->name('editCategory');
	Route::post('/updateCategory',[CategoryController::class,'update'])->name('updateCategory');
	Route::post('/deleteCategory',[CategoryController::class,'delete'])->name('deleteCategory');


	// make
	Route::get('/make',[CarsMakeController::class,'make'])->name('make');
	Route::post('/showCarsMake',[CarsMakeController::class,'show'])->name('showCarsMake');
	Route::post('/addCarsMake',[CarsMakeController::class,'add'])->name('addCarsMake');
	Route::post('/editCarsMake',[CarsMakeController::class,'edit'])->name('editCarsMake');
	Route::post('/updateCarsMake',[CarsMakeController::class,'update'])->name('updateCarsMake');
	Route::post('/deleteCarsMake',[CarsMakeController::class,'delete'])->name('deleteCarsMake');
	Route::post('/setMakeCol',[CarsMakeController::class,'setMakeCol'])->name('setMakeCol');
	Route::get('/getMakeCol',[CarsMakeController::class,'getMakeCol'])->name('getMakeCol');
	

	// model
	Route::get('/model',[CarsModelController::class,'model'])->name('model');
	Route::post('/showCarsModel',[CarsModelController::class,'show'])->name('showCarsModel');
	Route::post('/addCarsModel',[CarsModelController::class,'add'])->name('addCarsModel');
	Route::post('/editCarsModel',[CarsModelController::class,'edit'])->name('editCarsModel');
	Route::post('/updateCarsModel',[CarsModelController::class,'update'])->name('updateCarsModel');
	Route::post('/deleteCarsModel',[CarsModelController::class,'delete'])->name('deleteCarsModel');

	
	// Expense Category
	Route::get('/expenseCategory',[ExpenseCategoryController::class,'expenseCategory'])->name('expenseCategory');
	Route::post('/showExpenseCategory',[ExpenseCategoryController::class,'show'])->name('showExpenseCategory');
	Route::post('/addExpenseCategory',[ExpenseCategoryController::class,'add'])->name('addExpenseCategory');
	Route::post('/editExpenseCategory',[ExpenseCategoryController::class,'edit'])->name('editExpenseCategory');
	Route::post('/updateExpenseCategory',[ExpenseCategoryController::class,'update'])->name('updateExpenseCategory');
	Route::post('/deleteExpenseCategory',[ExpenseCategoryController::class,'delete'])->name('deleteExpenseCategory');
	

	// Expenses
	Route::get('/expense',[ExpenseController::class,'expense'])->name('expense');
	Route::post('/showExpense',[ExpenseController::class,'show'])->name('showExpense');
	Route::post('/addExpense',[ExpenseController::class,'add'])->name('addExpense');
	Route::post('/editExpense',[ExpenseController::class,'edit'])->name('editExpense');
	Route::post('/getExpenseFiles',[ExpenseController::class,'getFiles'])->name('getExpenseFiles');
	Route::post('/updateExpense',[ExpenseController::class,'update'])->name('updateExpense');
	Route::post('/expenseMarkAsDelete',[ExpenseController::class,'markAsDelete'])->name('expenseMarkAsDelete');
	Route::post('/expenseDelete',[ExpenseController::class,'delete'])->name('expenseDelete');
	// 	Expenses end


    // assets
	Route::get('/asset',[AssetsController::class,'assets'])->name('asset');
	Route::post('/showAsset',[AssetsController::class,'show'])->name('showAsset');
	Route::post('/addAsset',[AssetsController::class,'add'])->name('addAsset');
	Route::post('/editAsset',[AssetsController::class,'edit'])->name('editAsset');
	Route::post('/getAssetFiles',[AssetsController::class,'getFiles'])->name('getAssetFiles');
	Route::post('/updateAsset',[AssetsController::class,'update'])->name('updateAsset');
	Route::post('/assetMarkAsDelete',[AssetsController::class,'markAsDelete'])->name('assetMarkAsDelete');
	Route::post('/assetDelete',[AssetsController::class,'delete'])->name('assetDelete');
	Route::post('/addAllocation',[AssetsController::class,'addAllocation'])->name('addAllocation');
	Route::post('/allocationHistory',[AssetsController::class,'allocationHistory'])->name('allocationHistory');
	Route::post('/removeAllocationHistory',[AssetsController::class,'removeAllocationHistory'])->name('removeAllocationHistory');
	Route::post('/assetAssignIncome',[AssetsController::class,'assetAssignIncome'])->name('assetAssignIncome');
	
// 	pending cheques
	Route::get('/pendingCheques',[PendingChequesController::class,'pendingCheques'])->name('pendingCheques');
	Route::post('/showPendingCheques',[PendingChequesController::class,'show'])->name('showPendingCheques');
	Route::post('/addPendingCheques',[PendingChequesController::class,'add'])->name('addPendingCheques');
	Route::post('/editPendingCheques',[PendingChequesController::class,'edit'])->name('editPendingCheques');
	Route::post('/getPendingChequesFiles',[PendingChequesController::class,'getFiles'])->name('getPendingChequesFiles');
	Route::post('/updatePendingCheques',[PendingChequesController::class,'update'])->name('updatePendingCheques');
	Route::post('/pendingChequesMarkAsDelete',[PendingChequesController::class,'markAsDelete'])->name('pendingChequesMarkAsDelete');
	Route::post('/pendingChequesDelete',[PendingChequesController::class,'delete'])->name('pendingChequesDelete');
	


	// Parts List
	Route::get('/partsList',[PartsListController::class,'partsList'])->name('partsList');
	Route::post('/showPartsList',[PartsListController::class,'show'])->name('showPartsList');
	Route::post('/addPartsList',[PartsListController::class,'add'])->name('addPartsList');
	Route::post('/editPartsList',[PartsListController::class,'edit'])->name('editPartsList');
	Route::post('/updatePartsList',[PartsListController::class,'update'])->name('updatePartsList');
	Route::post('/deletePartsList',[PartsListController::class,'delete'])->name('deletePartsList');
	

	//parts Category
	Route::get('/partsCategory',[PartsCategoryController::class,'partsCategory'])->name('partsCategory');
	Route::post('/showPartsCategory',[PartsCategoryController::class,'show'])->name('showPartsCategory');
	Route::post('/addPartsCategory',[PartsCategoryController::class,'add'])->name('addPartsCategory');
	Route::post('/editPartsCategory',[PartsCategoryController::class,'edit'])->name('editPartsCategory');
	Route::post('/updatePartsCategory',[PartsCategoryController::class,'update'])->name('updatePartsCategory');
	Route::post('/deletePartsCategory',[PartsCategoryController::class,'delete'])->name('deletePartsCategory');



	// Feature Level
	Route::get('/featuresLevel',[FeaturesLevelController::class,'featuresLevel'])->name('featuresLevel');
	Route::post('/showFeaturesLevel',[FeaturesLevelController::class,'show'])->name('showFeaturesLevel');
	Route::post('/addFeaturesLevel',[FeaturesLevelController::class,'add'])->name('addFeaturesLevel');
	Route::post('/editFeaturesLevel',[FeaturesLevelController::class,'edit'])->name('editFeaturesLevel');
	Route::post('/updateFeaturesLevel',[FeaturesLevelController::class,'update'])->name('updateFeaturesLevel');
	Route::post('/deleteFeaturesLevel',[FeaturesLevelController::class,'delete'])->name('deleteFeaturesLevel');
	
	// CLients
	Route::get('/clients',[ClientsController::class,'clients'])->name('clients');
	Route::post('/showClients',[ClientsController::class,'show'])->name('showClients');
	Route::post('/addClients',[ClientsController::class,'add'])->name('addClients');
	Route::post('/editClients',[ClientsController::class,'edit'])->name('editClients');
	Route::post('/updateClients',[ClientsController::class,'update'])->name('updateClients');
	Route::post('/deleteClients',[ClientsController::class,'delete'])->name('deleteClients');
	// Clients End

	// cars
	Route::get('/cars',[CarsController::class,'cars'])->name('cars');
    Route::post('showCars',[CarsController::class,'show'])->name('showCars');
    Route::post('/addCars',[CarsController::class,'add'])->name('addCars');
    Route::post('/editCars',[CarsController::class,'edit'])->name('editCars');
    Route::post('/e_getModels',[CarsController::class,'e_getModels'])->name('e_getModels');
    Route::post('/updateCars',[CarsController::class,'update'])->name('updateCars');
    Route::post('/deleteCars',[CarsController::class,'delete'])->name('deleteCars');
    Route::post('/carsMarkDelete',[CarsController::class,'markDelete'])->name('carsMarkDelete');



    Route::post('carsGetModels',[CarsController::class,'carsGetModels'])->name('carsGetModels');
    Route::post('carsGetSubModels',[CarsController::class,'carsGetSubModels'])->name('carsGetSubModels');
	Route::post('getCode',[CarsController::class,'getCode'])->name('getCode');

// History

	Route::get('/history',[HistoryController::class,'history'])->name('history');
	Route::post('/showHistory',[HistoryController::class,'show'])->name('showHistory');
	Route::post('/getEditDetails',[HistoryController::class,'getEditDetails'])->name('getEditDetails');
	Route::post('/updateHistoryCheckbox',[HistoryController::class,'updateHistoryCheckbox'])->name('updateHistoryCheckbox');
	Route::post('/getReconciNotes',[HistoryController::class,'getReconciNotes'])->name('getReconciNotes');
	Route::post('/updateNotes',[HistoryController::class,'update'])->name('updateNotes');
	Route::post('/getDetailsDelete',[HistoryController::class,'getDetailsDelete'])->name('getDetailsDelete');
	
	// Notifications
	Route::get('/notifications',[NotificationsController::class,'notifications'])->name('notifications');
	Route::post('/showNotifications',[NotificationsController::class,'show'])->name('showNotifications');
	Route::post('/deleteNotifications',[NotificationsController::class,'delete'])->name('deleteNotifications');
	
	// USers
	
	Route::get('/users',[UserController::class,'users'])->name('users');
	Route::post('/showUsers',[UserController::class,'show'])->name('showUsers');
	Route::post('/addUsers',[UserController::class,'add'])->name('addUsers');
	Route::post('/editUsers',[UserController::class,'edit'])->name('editUsers');
	Route::post('/updateUsers',[UserController::class,'update'])->name('updateUsers');
	Route::post('/deleteUsers',[UserController::class,'delete'])->name('deleteUsers');
	
// Bank Accounts
	Route::get('/bankAccounts',[BankAccountsController::class,'bank_accounts'])->name('bankAccounts');
	Route::post('/showBankAccounts',[BankAccountsController::class,'show'])->name('showBankAccounts');
	Route::post('/addBankAccounts',[BankAccountsController::class,'add'])->name('addBankAccounts');
	Route::post('/editBankAccounts',[BankAccountsController::class,'edit'])->name('editBankAccounts');
	Route::post('/updateBankAccounts',[BankAccountsController::class,'update'])->name('updateBankAccounts');
	Route::post('/deleteBankAccounts',[BankAccountsController::class,'delete'])->name('deleteBankAccounts');
	// profile
	Route::get('/profile',[ProfileController::class,'profile'])->name('profile');
	Route::post('/profileUpload',[ProfileController::class,'profileUpload'])->name('profileUpload');
	Route::post('/updateProfile',[ProfileController::class,'update'])->name('updateProfile');
	
	    // Sub Model

Route::get('carsSubModel',[CarsSubModelController::class,'carsSubModel'])->name('carsSubModel');
Route::post('showCarsSubModels',[CarsSubModelController::class,'show'])->name('showCarsSubModels');
Route::post('addCarsSubModels', [CarsSubModelController::class, 'add'])->name('addCarsSubModels');
Route::post('editCarsSubModels', [CarsSubModelController::class, 'edit'])->name('editCarsSubModels');
Route::post('getFiles', [CarsSubModelController::class, 'getFiles'])->name('getFiles');
Route::post('updateCarsSubModels', [CarsSubModelController::class, 'update'])->name('updateCarsSubModels');
Route::post('deleteCarsSubModels', [CarsSubModelController::class, 'delete'])->name('deleteCarsSubModels');

// country
	Route::get('/countries',[CountriesController::class,'countries'])->name('countries');
	Route::post('/showCountries',[CountriesController::class,'show'])->name('showCountries');
	Route::post('/addCountries',[CountriesController::class,'add'])->name('addCountries');
	Route::post('/editCountries',[CountriesController::class,'edit'])->name('editCountries');
	Route::post('/updateCountries',[CountriesController::class,'update'])->name('updateCountries');
	Route::post('/deleteCountries',[CountriesController::class,'delete'])->name('deleteCountries');
	
// VAT
	Route::get('/vat',[VatController::class,'vat'])->name('vat');
	Route::post('/showVat',[VatController::class,'show'])->name('showVat');
	Route::post('/addVat',[VatController::class,'add'])->name('addVat');
	Route::post('/editVat',[VatController::class,'edit'])->name('editVat');
	Route::post('/updateVat',[VatController::class,'update'])->name('updateVat');
	Route::post('/deleteVat',[VatController::class,'delete'])->name('deleteVat');
	});


});



	
	Route::get('/salesPoint',[SalesPointController::class,'salesPoint'])->name('salesPoint');
	Route::get('/generalWidget',[HomeController::class,'generalWidget'])->name('generalWidget');
	Route::get('/chartWidget',[HomeController::class,'chartWidget'])->name('chartWidget');
	Route::get('/pos',[HomeController::class,'pos'])->name('pos');
	Route::get('/kanban',[HomeController::class,'kanban'])->name('kanban');
	Route::get('/orderHistory',[HomeController::class,'orderHistory'])->name('orderHistory');
	Route::get('/invoice',[HomeController::class,'invoice'])->name('invoice');
	Route::get('/calendarBasic',[HomeController::class,'calendarBasic'])->name('calendarBasic');
// 	Route::get('/login',[HomeController::class,'login'])->name('login');

	Route::get('/modals',[HomeController::class,'modals'])->name('modals');
	Route::get('/alerts',[HomeController::class,'alerts'])->name('alerts');
	Route::get('/accordian',[HomeController::class,'accordian'])->name('accordian');
	Route::get('/list',[HomeController::class,'list'])->name('list');
	Route::get('/tabs',[HomeController::class,'tabs'])->name('tabs');
	Route::get('/jobApply',[HomeController::class,'jobApply'])->name('jobApply');
	Route::get('/ckeditior',[HomeController::class,'ckeditior'])->name('ckeditior');
	Route::get('/supportTicket',[HomeController::class,'supportTicket'])->name('supportTicket');
	Route::get('/datatables',[HomeController::class,'datatables'])->name('datatables');
	Route::get('/forms',[HomeController::class,'forms'])->name('forms');
	Route::get('/projectCreate',[HomeController::class,'projectCreate'])->name('projectCreate');
	Route::get('/datePicker',[HomeController::class,'datePicker'])->name('datePicker');
	Route::get('/select2',[HomeController::class,'select2'])->name('select2');
	Route::get('/formWizard2',[HomeController::class,'formWizard2'])->name('formWizard2');

	
	Route::get('/login2',[HomeController::class,'login2'])->name('login2');


// admin routes ends here