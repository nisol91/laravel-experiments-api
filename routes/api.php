<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// test routes
// Route::get('bookables', 'Api\BookableController@index');
// Route::get('bookables/{id}', 'Api\BookableController@show');
// Route::get('/httptest', 'Api\HttpController@getTest');
Route::get('/test', 'Api\TestController@test');



// il middleware auth:api permette che le chiamate http (in questo caso axios) funzionino solo se si genera un bearer token
// al login. cosi chi non sa il bearer non puo fare chiamate. è una protezione. se voglio fare una chiamata da postman basta che
// metta il Authorization: bearer token come header.
// mentre da browser, finche il token generato al login è salvato in sessione le chiamate vanno, se lo cancello invece non vanno più
Route::group(["middleware" => "auth:api"], function () {

    // test route
    // Route::get('/test', 'Api\TestController@test');


    // laravelbnb
    Route::apiResource('bookables', 'Api\BookableController');
    Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')->name('bookables.availability.show');
    Route::get('/bookables/{bookable}/reviews', 'Api\BookableReviewController')->name('bookables.reviews.show');
    Route::get('/bookables/{bookable}/price', 'Api\BookablePriceController')->name('bookables.price.show');
    Route::apiResource('review', 'Api\ReviewController');
    Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController');
    Route::post('/checkout', 'Api\CheckoutController')->name('checkout');

    // edit user profile
    Route::post('/change-password', 'Api\UserController@changePassword');
    Route::post('/change-details', 'Api\UserController@changeDetails');
    // user settings
    Route::post('/save-user-settings', 'Api\UserSettingsController@saveUserSettings');
    Route::get('/get-user-settings', 'Api\UserSettingsController@getUserSettings');
    Route::post('/save-file', 'Api\UserSettingsController@saveFile');

    // crud categories
    Route::get('/categories', 'Api\UserSettingsController@getCategories');
    Route::get('/categories-all', 'Api\UserSettingsController@getAllCategories');
    Route::post('/remove-category', 'Api\UserSettingsController@removeCategory');
    Route::post('/delete-category', 'Api\UserSettingsController@deleteCategory');
    Route::post('/edit-category', 'Api\UserSettingsController@editCategory');
    Route::post('/add-category', 'Api\UserSettingsController@addCategory');
    Route::post('/add-selected-category', 'Api\UserSettingsController@addSelectedCategory');


    // toccavino
    Route::apiResource('wine-events', 'Api\WineEventController');
});

//  portfolio
Route::get('/get-projects', 'Api\PortfolioController@getProjects');
Route::get('/get-project/{id}', 'Api\PortfolioController@getProject');


// admin routes


// auth routes (le routes Auth sono quelle prefatte di laravel, quelle Api sono custom)
Auth::routes();

// api custom routes for auth
Route::get('/email-verification', 'Api\EmailVerificationController@verify');
Route::post('/forgot-password', 'Api\ForgotPasswordControllerApi@sendResetLinkEmail');
Route::post('/reset-password', 'Api\ResetPasswordControllerApi@reset');
Route::get('/get-user-role', 'Api\GetUserRole');


Route::middleware('auth')->get('/user', function (Request $request) {

    if ($request->user()->isUserAdmin()) {
        return response()->json(
            [
                "user_data" => $request->user(),
                "user_roles" => $request->user()->roles,
                "isuseradmin" => "true"
            ]
        );
    } else {
        return response()->json(
            [
                "user_data" => $request->user(),
                "user_roles" => $request->user()->roles,
                "isuseradmin" => "false"
            ]
        );
    }
});
