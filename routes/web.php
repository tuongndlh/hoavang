<?php

Auth::routes();
/* CoreUI templates */

  Route::middleware('auth')->group(function() {
	Route::view('/', 'panel.blank');

	Route::resource('user','Account\UserController');
	Route::get('/user', 'Account\UserController@index')->name('user');
	Route::get('getlist_user', 'Account\UserController@Get_User');
	Route::get('changelock_user/{id}/{lock}', 'Account\UserController@ChangeLock')->name('changelock_user');

	//User manager
	Route::get('user/view/{id}','Account\UserAssignController@Get_View_User')->name('View_User');
	Route::get('getlist_user_manager/{id}', 'Account\UserAssignController@Get_User_Manager')->name('manager');

	Route::get('user/add-detail/{id}','Account\UserAssignController@Get_View_Add_Detail')->name('View_Add_Detail');
	Route::get('list_user_add_manager/{id}', 'Account\UserAssignController@List_User_Add_Manager')->name('list_user_add_manager');

	Route::post('add_user_detail', 'Account\UserAssignController@AddUser')->name('Add_User_Manager');
	Route::get('delete_user_manager', 'Account\UserAssignController@DeleteData')->name('delete_user_manager');


// hoavang

	Route::get('/', 'Account\UserController@blank')->name('/');

	//Lớp
	Route::get('/class', 'Declares\ViewReportAllController@index')->name('class');
	Route::get('view_reportall_ajax', 'Declares\ViewReportAllController@Get_Report_All');
	Route::get('get_code', 'Declares\ViewReportAllController@Get_Code');

	//ReportAll
	Route::get('/reportall', 'Declares\ReportAllController@index')->name('reportall');
	Route::get('reportall_ajax', 'Declares\ReportAllController@Get_Report_All');
	Route::post('add_reportall', 'Declares\ReportAllController@AddData')->name('add_reportall');
	Route::get('edit_reportall', 'Declares\ReportAllController@EditData')->name('edit_reportall');
	Route::get('get_code_reportall', 'Declares\ReportAllController@Get_Code_reportall');
	Route::get('delete_reportall', 'Declares\ReportAllController@DeleteData')->name('delete_reportall');



});
// Section Pages
Route::view('/sample/error404','errors.404')->name('error404');
Route::view('/sample/error500','errors.500')->name('error500');
