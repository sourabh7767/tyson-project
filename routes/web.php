<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('prevent-back-history')->group(function (){

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        
        return Redirect::back()->with('success', 'All cache cleared successfully.');
    });

    Auth::routes();

    Route::middleware('auth')->group(function(){
        Route::get('/company/edit/{id}', 'CompanyController@editCompany')->name('company.edit');
        Route::put('/company/update/{id}', 'CompanyController@updateCompany')->name('company.update');
        Route::delete('/company/{id}', 'CompanyController@deleteCompany')->name('company.delete');
        Route::get('/company', 'CompanyController@index')->name('company.index');
        Route::get('/company/add', 'CompanyController@add')->name('company.add');
        Route::post('/company/store', 'CompanyController@store')->name('company.store');
        Route::post('/booking/cancel', 'BookingController@cancelBooking')->name('booking.cancel');
        Route::get('/booking/{id}', 'BookingController@showBooking')->name('booking.index');
        Route::get('booking/add/{id}', 'BookingController@addBooking')->name('booking.add');
        Route::post('booking/store', 'BookingController@storeBooking')->name('booking.store');
        
        Route::get('/booking/csr/{id}', 'BookingController@showBookingCsr')->name('csr.booking.index');
        // Route::get('booking/store/{id}', 'BookingController@storeBooking')->name('booking.store');
        Route::get('get-slots', 'BookingController@getSlots')->name('booking.get.slots');
        Route::get('get-slots-number', 'BookingController@getSlotsNumber')->name('booking.get.slots.number');
        
        Route::delete('/time_slot/{id}', 'TimeSlotController@deleteTimeSlot')->name('time_slot.delete');
        Route::get('/time_slot', 'TimeSlotController@index')->name('time_slot.index');
        Route::get('/time_slot/create', 'TimeSlotController@create')->name('time_slot.create');
        Route::post('/time_slot/store', 'TimeSlotController@store')->name('time_slot.store');
        Route::get('/', 'HomeController@index')->name('user.home');
        Route::resource('users', 'UserController');
        Route::resource('role', 'RoleController');
        Route::get('/user/changeStatus/{id}','UserController@changeStatus')->name('user.changeStatus');
        Route::get('user/profile','UserController@profile')->name('user.profile');
        Route::get('user/update-profile','UserController@showUpdateProfileForm')->name('user.updateProfile');
        Route::post('user/update-profile','UserController@updateProfile')->name('user.updateProfile.submit');
        Route::get('user/change-password','UserController@changePasswordView')->name('user.changePassword');
        Route::post('user/change-password','UserController@changePassword')->name('user.changePassword.submit');

        Route::get('user/change-password/{id}','UserController@changeUserPasswordView')->name('user.changeUserPassword');
        Route::post('user/change-password/{id}','UserController@changeUserPassword')->name('user.changeUserPassword.submit');
        
        Route::resource('email-queue', 'EmailQueueController');

    });
});
