<?php

use App\Http\Controllers\adminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealSelectionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MealticketController;
use App\Http\Controllers\PrintersController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SecurityMealTicket;
use Illuminate\Support\Facades\Auth;


Route::get('/printTest', [MealSelectionController::class, 'printTest'])->name('printTest');
// Route::get('/mpe', function () {
//     $user = Auth::user();
//     dd($user);
//     $user->assignRole('super-admin');
// });

Route::group(['middleware' => ['role:admin|super-admin|security']], function () {
    Route::get('/admin/dashboard', [adminDashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    
});
//super-admin routes
Route::group(['middleware' => ['role:super-admin']], function () {
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionid}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleid}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleid}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleid}/give-permissions', [App\Http\Controllers\RoleController::class, 'updatePermissionToRole'])->name('roles.give-permissions');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userid}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

    Route::get('logs/{ticketid}/delete', [App\Http\Controllers\MealticketController::class, 'destroy']);

    Route::resource('companies', CompanyController::class);
    Route::get('companies/{companyid}/delete', [App\Http\Controllers\CompanyController::class, 'destroy']);

    Route::resource('sites', SitesController::class);
    Route::get('sites/{siteid}/delete', [App\Http\Controllers\SitesController::class, 'destroy']);

    Route::resource('printers', PrintersController::class);
    Route::get('printers/{printerid}/delete', [App\Http\Controllers\PrintersController::class, 'destroy']);

    Route::resource('shifts', ShiftController::class);
    Route::get('shifts/{shiftid}/delete', [App\Http\Controllers\ShiftController::class, 'destroy']);

    Route::post('/printers/{printer}/test', [MealSelectionController::class, 'printTest'])->name('printers.test');

    Route::post('/print-ticket', [MealticketController::class, 'printTicket'])->name('print.ticket');

    Route::resource('securities', SecurityMealTicket::class);

    // Route::get('/ticket', [MealticketController::class, 'index'])->name('ticket');

    // Route::get('/get-companies', [MealticketController::class, 'fetchCompanies'])->name('get.companies');
    // Route::get('/get-sites', [MealticketController::class, 'fetchSites'])->name('get.sites');
    // Route::get('/get-department', [MealticketController::class, 'fetchDepartments'])->name('get.department');

    
    
});




Route::group(['middleware' => ['role:admin|super-admin']], function () {
    Route::get('/fetch-companies', [ReportController::class, 'fetchCompanies'])->name('fetch.companies');
    Route::get('/fetch-sites', [ReportController::class, 'fetchSites'])->name('fetch.sites');
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::resource('guests', App\Http\Controllers\GuestController::class);
    Route::get('guests/{guestid}/delete', [App\Http\Controllers\GuestController::class, 'destroy']);
    
});

Route::group(['middleware' => ['role:security|super-admin']], function () {
   
    Route::get('/ticket', [MealticketController::class, 'index'])->name('ticket');
    
    Route::get('/get-sites', [MealticketController::class, 'fetchSites'])->name('get.sites');
    
    Route::post('/log-ticket', [SecurityMealTicket::class, 'logTicket'])->name('log.ticket');

    Route::resource('securities', SecurityMealTicket::class);

    // Other security routes...
});


//normal user routes
Route::group(['middleware' => ['role:user']], function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
Route::post('/selectMeal', [MealSelectionController::class, 'selectMeal'])->name("select-meal");
});

//admin login routes
Route::get('/admin-login', [UserController::class, 'adminLogin'])->name('login');
Route::post('/login-user', [UserController::class, 'loginUser'])->name('loginuser');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login-user');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Route::middleware('auth')->group(function () {
//     Route::group(['prefix' => 'admin'], function () {
//         Route::get('/printers', PrintersController::class . '@index')->name('printers.index');
//         Route::get('/printers/create', PrintersController::class . '@create')->name('printers.create');
//         Route::post('/', PrintersController::class . '@create')->name('printers.store');
//         Route::delete('/printers/{id}/delete', [App\Http\Controllers\PrintersController::class, 'destroy']);
//     });
// });

//Route::post('/login-user', [UserController::class, 'loginUser'])->name('loginuser');
// Route::post('/register-user', [UserController::class, 'register'])->name('register-user');
// Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');