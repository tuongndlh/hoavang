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
	Route::get('/class', 'Declares\ClassController@index')->name('class');
	Route::get('class_ajax', 'Declares\ClassController@Get_Class');
	Route::get('get_code', 'Declares\ClassController@Get_Code');
	Route::post('add_class', 'Declares\ClassController@AddData')->name('add_class');
	Route::get('edit_class', 'Declares\ClassController@EditData')->name('edit_class');
	Route::get('delete_class', 'Declares\ClassController@DeleteData')->name('delete_class');

	//ReportAll
	Route::get('/reportall', 'Declares\ReportAllController@index')->name('reportall');
	Route::get('reportall_ajax', 'Declares\ReportAllController@Get_Report_All');
	Route::post('add_reportall', 'Declares\ReportAllController@AddData')->name('add_reportall');
	Route::get('edit_reportall', 'Declares\ReportAllController@EditData')->name('edit_reportall');
	Route::get('get_code_reportall', 'Declares\ReportAllController@Get_Code_reportall');
	Route::get('delete_reportall', 'Declares\ReportAllController@DeleteData')->name('delete_reportall');

	//Danh sách cháu
	Route::get('/child', 'Declares\ChildController@index')->name('child');
	Route::get('child_ajax', 'Declares\ChildController@Get_child');
	Route::get('view_child', 'Declares\ChildController@View_Child')->name('view_child');
	Route::post('add_child', 'Declares\ChildController@AddData_Child')->name('add_child');
	Route::get('child/{id}/edit_child','Declares\ChildController@EditData_Child');
	Route::get('delete', 'Declares\ChildController@Delete')->name('delete');

	// Nhập ngày nghỉ
	Route::get('/dayoff', 'Manager\DayoffController@index')->name('dayoff');
	Route::get('dayoff_ajax', 'Manager\DayoffController@Get_dayoff')->name('dayoff_ajax');
	Route::get('edit_dayoff', 'Manager\DayoffController@EditData_DayOff')->name('edit_dayoff');
	Route::post('add_dayoff', 'Manager\DayoffController@AddData')->name('add_dayoff');
	Route::get('edit_discount', 'Manager\DayoffController@EditData_Discount')->name('edit_discount');
	Route::post('add_discount', 'Manager\DayoffController@AddData_Discount')->name('add_discount');

	// Thống kê trong tháng
	Route::get('/sumary', 'Sumary\SumaryController@index')->name('sumary');
	Route::get('sumary_ajax', 'Sumary\SumaryController@Get_sumary')->name('sumary_ajax');

	// Thu tiền
	Route::post('add_data_total', 'Sumary\SumaryController@AddData_Total')->name('add_data_total');

	// Thống kê chung
	Route::get('/statistic', 'Statistic\StatisticController@index')->name('statistic');
	Route::get('statistic_ajax', 'Statistic\StatisticController@Get_sumary')->name('statistic_ajax');
	Route::post('Print_report', 'Statistic\StatisticController@Print_report')->name('Print_report');

	// In trước khi nộp tiền
	Route::get('/print', 'PrintChild\PrintController@index')->name('print');
	Route::get('Print_ajax', 'PrintChild\PrintController@Get_List_Print')->name('Print_ajax');
	Route::post('Print_report_before', 'PrintChild\PrintController@Print_report_before')->name('Print_report_before');

});
// Section Pages
Route::view('/sample/error404','errors.404')->name('error404');
Route::view('/sample/error500','errors.500')->name('error500');
