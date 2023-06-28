<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddBusRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BusRouteController;
use App\Http\Controllers\UserShowController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;
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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function(){

    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.user.login')->name('login');
          Route::view('/register','dashboard.user.register')->name('register');
          Route::post('/create',[UserController::class,'create'])->name('create');
          Route::post('/check',[UserController::class,'check'])->name('check');
    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
          Route::view('/home','dashboard.user.home')->name('home');

        Route::get('/profile',[UserController::class,'profile'])->name('profile');
          Route::post('/logout',[UserController::class,'logout'])->name('logout');
          Route::get('/add-new',[UserController::class,'add'])->name('add');
          Route::get('/prev/bookings',[BookingController::class,'prevBookings'])->name('prevBookings');
        Route::get('/future/bookings',[BookingController::class,'futureBookings'])->name('futureBookings');
        Route::get('/users1/seats/{booking_id}',[AdminController::class,'individualBookinUserSeats'])->name('booking.seats');
    });

});


Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.admin.login')->name('login');
          Route::post('/check',[AdminController::class,'check'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
        Route::get('/profile', function () {
            return view('dashboard.admin.profile');
        })->name('profile');
        Route::get('/dashboard1/admin/', [AdminController::class, 'showDashboard'])->name('dashboard');
        Route::get('/all/staff/show',[AdminController::class,'showAllStaff'])->name('allStaff');
        Route::get('/staff/{id}', [AdminController::class, 'showAllStaff'])->name('showStaff');
        Route::get('Individual/user/{id}', [AdminController::class, 'individualUserAllDetails'])->name('individualUserAllDetails');
       // Route::get('/User/all/aa/{id}',[AdminController::class, 'individualUserAllDetails'])->name('individualUserAll1Details');
        Route::get('/user11112/individual/{id}', [AdminController::class, 'showIndividualUsergTrip'])->name('showIndividualUsergTrip');

        Route::get('/user11/all/atrips/{id}', [AdminController::class, 'showIndividualUsergAllTrip'])->name('showAllUser');
        Route::get('/staff/individual/details/{id}', [AdminController::class, 'showIndividualStaffDetails'])->name('showIndividualStaffDetails');
        Route::get('/staff/individual/details/completed/trips/{id}', [AdminController::class, 'showIndividualAllStaff'])->name('showIndividualAllStaff');
        Route::get('/user/upcoming/details/{id}', [AdminController::class, 'showIndividualUserUpcomingTrip'])->name('showIndividualUserUpcomingTrip');
        Route::get('/staff/upcoming/details/{id}', [AdminController::class, 'showIndividualStaffUpcomingTrip'])->name('showIndividualStaffUpcomingTrip');
        Route::get('/users/all',[UserShowController::class,'fulllist'])->name('allUser');
        Route::get('/users/{id}',[UserShowController::class,'fulllist'])->name('showUser');
        Route::get('/all/bookings',[AdminController::class,'AllBookins'])->name('allBookings');

        Route::get('/all/Upcoming/bookings',[AdminController::class,'allUpcomingBookings'])->name('allUpcomingBookings');
        Route::get('/admin/booking/details/{travel_id}',[AdminController::class,'individualBookin'])->name('booking.details');
        Route::get('/staf/{travel_id}',[AdminController::class,'individualBookinStaff'])->name('booking.staff');
        Route::get('/Allusers/{travel_id}',[AdminController::class,'individualBookinUser'])->name('booking.passengers1');
        Route::get('/users/seats/{booking_id}',[AdminController::class,'individualBookinUserSeats'])->name('booking.seats');
                Route::get('/otherInfo/{travel_id}',[AdminController::class,'OtherInfo'])->name('booking.others');
                Route::get('/individual1/agency/{id}',[AdminController::class,'indivdualAgency'])->name('individualAgency1');
                Route::get('/individual1/bus/{id}',[AdminController::class,'indivdualBus'])->name('individual.bus.details');
    });


});
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/buses/reserve', [AddBusRoute::class, 'reserve'])->name('buses.reserve');
    Route::post('/admin/buses/reserve/save', [AddBusRoute::class, 'save'])->name('buses.save');

    Route::get('/users/booking',[UserShowController::class,'allbookings'])->name('list.user.booking');
    Route::get('/allocate-trip',[AdminController::class,'AllocateTripPage'])->name('buses.trip.create');
    Route::get('/allocate-fixed-trip',[AdminController::class,'AllocateFixedTripPage'])->name('buses.fixed.trip.create');
    Route::get('/buses/trip/create/allocate', [AdminController::class,'freeBusSearch'])->name('buses.trip.create.allocate');
    Route::get('/buses/trip/fixed/create/allocate', [AdminController::class,'freeFixedBusSearch'])->name('buses.fixed.trip.create.allocate');
    Route::get('/buses/trip/Staff/search', [AdminController::class,'freeStaffSearch'])->name('buses.trip.create.freeStaff');
    Route::get('/buses/trip/FIxed/Staff/search', [AdminController::class,'freeFixedStaffSearch'])->name('buses.trip.fixed.create.freeStaff');

    Route::post('/allocate-trip/create',[AdminController::class,'AlocateTrip'])->name('buses.trip.create.added');

    Route::post('/allocate-fixed-trip/create',[AdminController::class,'AlocateFixedTrip'])->name('buses.fixed.trip.create.added');
    Route::get('/agency/list',[AdminController::class,'agency_list'])->name('admin.agency.list');
    Route::get('/agency/add',[AdminController::class,'add_agency'])->name('agency.add');
    Route::post('/agency/added',[AdminController::class,'storeAgency'])->name('agencies.store');



});
Route::middleware(['auth:admin'])->group(function () {

   // Route::middleware(['admin'])->group(function () {
        Route::resource('/products', ProductController::class);
   // });
});



Route::prefix('staff')->name('staff.')->group(function(){

    Route::middleware(['guest:staff','PreventBackHistory'])->group(function(){
        Route::view('/login','dashboard.staff.login')->name('login');
        Route::view('/register','dashboard.staff.register')->name('register');
        Route::post('/create',[StaffController::class,'create'])->name('create');
        Route::post('/check',[StaffController::class,'check'])->name('check');

    });

    Route::middleware(['auth:staff','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.staff.home')->name('home');
        Route::get('/profile',[StaffController::class,'profile'])->name('profile');
        Route::post('logout',[StaffController::class,'logout'])->name('logout');
        Route::get('/staff/assigned/trips',[StaffController::class,'assignedTrips'])->name('assignedTrip');
        Route::get('/staff/assigned/trips/completed',[StaffController::class,'completed'])->name('CompletedassignedTrip');
        Route::get('/prev/bookings',[StaffController::class,'prevBookings'])->name('prevAssignedTrip');
        Route::get('/Maintences',[StaffController::class,'maintenance'])->name('maintenance');
        Route::post('/post/Maintences',[StaffController::class,'maintenanceRecord'])->name('maintenanceRecord');

    });

});



Route::get('/', function () {
    return view('transit_pro_home_page');
})->name('home');

Route::get('/bus-routes', [BusRouteController::class, 'index'])->name('bus-routes.index');
Route::post('/bus-routes/search', [BusRouteController::class, 'search'])->name('bus-routes.search');

Route::middleware('auth.booking')->post('/bookings', [BookingController::class, 'create'])->name('bookings.create');

Route::post('/bookings/seats', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/bus', function () {
    return view('dashboard.user.SearchRoute');
})->name('bus-routes1.search');

Route::get('/generate-pdf', [PdfController::class, 'generate_pdf']);
Route::get('/download-pdf', [PdfController::class, 'download_pdf']);

Route::get('/tickets Booked/{id}',[PdfController::class,'generate_pdf'])->name('user.thanks');
