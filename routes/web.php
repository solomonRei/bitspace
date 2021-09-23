<?php

use Illuminate\Support\Facades\Route;


Route::get('/doAuth', 'LoginController@doAuth');

Route::get('/', function () {
    return redirect()->route('home-locale', app()->getLocale());
})->name('home');

Route::get('/login', 'LoginController@index')->name('login');
Route::get('/about', 'AboutController@index')->name('about');
Route::get('/profile/{id}', 'ProfileController@profileShow')->name('profileUser.show');
Route::post('/questions', 'IndexController@questions')->name('questions.store');

// Route::get('/specialists', 'IndexController@specialists')->name('specialists');
Route::get('/filter/{category?}', 'IndexController@filter')->name('filter.all');

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
    Route::get('/', 'IndexController@index')->name('home-locale');
});

Route::group(['prefix' => 'blog'], function() {
    Route::get('/', 'BlogController@index')->name('blog.index.show');
    Route::get('/article/{id}', 'BlogController@show')->name('blog.article.show');
    Route::get('/tag/{slug}', 'BlogController@tag')->name('blog.tag.show');
});

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function() {
    Route::get('/', 'ProfileController@index')->name('profile.index');

    Route::get('/contact-information', 'SettingsController@showContactForm')->name('profile.contacts.show');
    Route::post('/contact-information/update', 'SettingsController@updateContactForm')->name('profile.contacts.update');

    Route::get('/summary', 'SettingsController@showSummaryForm')->name('profile.summary.show');
    Route::post('/summary/update', 'SettingsController@updateSummaryForm')->name('profile.summary.update');

    Route::get('/reviews', 'SettingsController@showReviews')->name('profile.reviews.show');
    Route::get('/reviews/complain/{id}', 'SettingsController@complainReview')->name('profile.reviews.complain');

    Route::get('/events', 'EventController@index')->name('profile.events.show');

    Route::get('/full-calender', 'FullCalenderController@index')->name('profile.calendar.show');
    Route::post('/full-calender/action', 'FullCalenderController@action')->name('profile.calendar.update');

    Route::get('/media-files', 'SettingsController@showMediaForm')->name('profile.media.showUser');
    Route::post('/media-files/update', 'SettingsController@updateMediaForm')->name('profile.media.update');
    Route::post('/media-presentation/update', 'SettingsController@updatePresentationForm')->name('profile.presentation.update');
    Route::post('/media-files/delete', 'SettingsController@deleteMediaForm')->name('profile.media.delete');

    Route::get('/settings', 'SettingsController@index')->name('profile.settings');
    Route::post('settings/update', 'SettingsController@update')->name('profile.update');
    Route::get('settings/2fa', 'SettingsController@include2FAQuery')->name('profile.2fa');
    Route::get('settings/delete-profile', 'SettingsController@deleteProfile')->name('profile.delete');

    Route::get('logout', 'LoginController@logout')->name('profile.logout');
});

