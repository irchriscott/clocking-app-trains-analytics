<?php

//Authentication and Home Routes

Route::get('/', 'UserController@login')->name('login');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


//Users Routes With admin middleware

Route::get('/user/all', 'UserController@index')->name('users')->middleware('admin');
Route::delete('/user/{id}/delete', 'UserController@destroy')->name('user.delete')->middleware('admin');
Route::get('/user/{id}/edit', 'UserController@edit')->name('user.edit')->middleware('admin');
Route::put('/user/{id}/update', 'UserController@update')->name('user.update')->middleware('admin');

//User Checkins and Report Routes

Route::post('/user/checkin', 'UserController@checkin')->name('checkin');
Route::get('/reports/all', 'UserController@reports')->name('reports')->middleware('auth');
Route::get('/user/{id}/reports', 'UserController@userReports')->name('user.reports')->middleware('auth');

//Export User Data in Excel File

Route::get('/user/reports/export/excel', 'ExportController@exportExcelFile')->name('reports.export.excel')->middleware('admin');
Route::get('/user/reports/export/csv', 'ExportController@exportCSVFile')->name('reports.export.csv')->middleware('admin');