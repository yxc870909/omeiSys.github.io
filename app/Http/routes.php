<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::post('/login', 'Auth\AuthController@login');
Route::get('/logout', 'Auth\AuthController@logout');
Route::post('/doRegisterUser', 'PersonnelController@doRegisterUser');
Route::get('/AuthCode', 'Auth\AuthController@authCode');

//view
Route::get('/', function () {
	if(Auth::user() != null)
		return Redirect::to('/Calendar');
	return view('Login');
});

Route::get('/Register', function () {
	return view('Register');
});



Route::group(['middleware' => 'auth'], function() {

	Route::get('/Calendar', ['middleware' => 'auth', function () {
		return view('BKCalendar')->with('menu', \App\Support\Menu::setMenuList('Calendar'))
								 ->with('userInfo', \App\Models\User\Service\UserService::getUserBoxInfo());
	}]);

	Route::get('/Member', 'MemberController@MemberView');
	//ajax
	Route::post('/doEditprofile', 'MemberController@doEditprofile');
	Route::get('/doGetFaimly', 'MemberController@doGetFaimly');
	Route::post('/doChangePsw', 'Auth\PasswordController@ChangePsw');

	Route::get('/Temple', 'TempleController@TempleView');
	//ajax
	Route::post('/doAddTemple', 'TempleController@doAddTemple');
	Route::post('/doEditTemple', 'TempleController@doEditTemple');
	Route::get('/doGetTempleByArea', 'TempleController@doGetTempleByArea');
	Route::get('/doGetTemplInfo', 'TempleController@doGetTemplInfo');


	Route::get('/Personnel', 'PersonnelController@PersonnelView');
	//ajax
	Route::get('/doGetPersonnel_edit', 'PersonnelController@doGetPersonnel_edit');
	Route::post('/doGetUserData', 'PersonnelController@doGetUserData');
	Route::get('/doGetUserData2', 'PersonnelController@doGetUserData2');
	Route::post('/doSearchUser', 'PersonnelController@doSearchUser');
	Route::post('/doSavePersonnel_edit', 'PersonnelController@doSavePersonnel_edit');
	Route::get('/doAddUser_worker', 'PersonnelController@doAddUser_worker');
	Route::post('/doAddUser', 'PersonnelController@doAddUser');
	Route::post('/doAddGroup', 'GroupController@doAddGroup');
	Route::post('/doUpdateFaimly', 'PersonnelController@doUpdateFaimly');



	Route::get('/Agenda', 'AgendaController@AgendaView');
	//ajax
	Route::post('/doAddAgenda', 'AgendaController@doAddAgenda');
	Route::get('/doGetAgenda', 'AgendaController@doGetAgenda');

	Route::get('/CenterActivity', 'CenterActivityController@CenterActivityView');
	//ajax
	Route::post('/doAddCenterActivity', 'CenterActivityController@doAddCenterActivity');
	Route::get('/doGetCenterActivityLastTwoMonthData', 'CenterActivityController@doGetCenterActivityLastTwoMonthData');
	Route::get('/doGetCenterActivityUser', 'CenterActivityController@doGetCenterActivityUser');
	Route::delete('/doDeleteCenterActivityUser', 'CenterActivityController@doDeleteCenterActivityUser');
	Route::post('/doAddCenterActivityUser', 'CenterActivityController@doAddCenterActivityUser');
	Route::get('/doUpdateUserCenterStatus', 'CenterActivityController@doUpdateUserCenterStatus');

	Route::get('/CenterDetail', 'CenterActivityController@CenterDetailView');

	Route::get('/Activity', 'ActivityController@ActivityView');
	Route::get('/Clsmanag', 'ActivityController@ActivityManageView');
	Route::get('/ClsDetail', 'ActivityController@ActivityDetailView');
	//ajax
	Route::post('/doAddActivity', 'ActivityController@doAddActivity');
	Route::get('/doGetActivityData', 'ActivityController@doGetActivityData');
	Route::post('/doUpdateActivityData', 'ActivityController@doUpdateActivityData');
	Route::delete('/doDelActivity', 'ActivityController@doDelActivity');
	Route::get('/doGetLastActivityData', 'ActivityController@doGetLastActivityData');
	Route::get('/doGetActivityUser', 'ActivityController@doGetActivityUser');
	Route::delete('/doDeleteActivityUser', 'ActivityController@doDeleteActivityUser');
	Route::post('/doAddActivityUser', 'ActivityController@doAddActivityUser');
	Route::get('/dogetActivityLastTwoMonthData', 'ActivityController@dogetActivityLastTwoMonthData');
	Route::post('/doAddActivityAttend', 'ActivityController@doAddActivityAttend');
	

	Route::get('/BookBorrow', 'BooksController@BookBorrowView');
	//ajax
	Route::post('/doUploadPhoto', 'BooksController@doUploadPhoto');
	Route::delete('/doDelPhoto', 'BooksController@doDelPhoto');
	Route::post('/doAddBooks', 'BooksController@doAddBooks');
	Route::get('/doGetBooksData', 'BooksController@doGetBooksData');
	Route::post('/doEditBooks', 'BooksController@doEditBooks');
	Route::get('/doGetBorrowRecordData', 'BooksController@doGetBorrowRecordData');
	Route::post('/doGetBooksDataFromNumber', 'BooksController@doGetBooksDataFromNumber');
	Route::delete('/doDeleteTmpBorrow', 'BooksController@doDeleteTmpBorrow');
	Route::post('/doAddBorrow', 'BooksController@doAddBorrow');
	Route::post('/doEditBorrow', 'BooksController@doEditBorrow');
	Route::get('/doCountLocationBooks', 'BooksController@doCountLocationBooks');


	Route::get('/BookSubscription', 'BooksController@BookSubscriptionView');
	//ajax
	Route::get('/doGetSubscriptionType', 'BooksController@doGetSubscriptionType');
	Route::post('/doAddSubscriptionBooks', 'BooksController@doAddSubscriptionBooks');
	Route::get('/doGetSubscriptionData', 'BooksController@doGetSubscriptionData');
	Route::post('/doEditSubscription', 'BooksController@doEditSubscription');
	Route::post('/doAddSubApplication', 'SubApplicationController@doAddSubApplication');
	Route::get('/doGetSubscriptionRecordData', 'BooksController@doGetSubscriptionRecordData');
	Route::post('/doEditSubscriptionRecord', 'SubApplicationController@doEditSubscriptionRecord');
	Route::get('/doGetSubscriptionCount', 'BooksController@doGetSubscriptionCount');
	Route::post('/doSaveSubscriptionCount', 'BooksController@doSaveSubscriptionCount');
	Route::get('/doGetSubScriptionBookData', 'BooksController@doGetSubScriptionBookData');
	Route::post('/doSaveTempleReceive', 'BooksController@doSaveTempleReceive');


	Route::get('/BookReceive', 'BooksController@BookReceiveView');
	//ajax
	Route::get('/doGetReceiveData', 'BooksController@doGetReceiveData');
	Route::post('/doEditReceive', 'BooksController@doEditReceive');
	Route::post('/doAddRecvApplication', 'RecvApplicationController@doAddRecvApplication');
	Route::get('/doGetReceiveRecordData', 'BooksController@doGetReceiveRecordData');
	Route::post('/doEditReceiveRecord', 'RecvApplicationController@doEditReceiveRecord');
	Route::get('/doCountLocationRcevBooks', 'BooksController@doCountLocationRcevBooks');



	Route::get('/RecordGuarantor', 'RecordController@RecordGuarantorView');
	Route::get('/RecordIntroducer', 'RecordController@RecordIntroducerView');
	Route::get('/RecordAgenda', 'RecordController@RecordAgendaView');
	Route::get('/RecordJoin', 'RecordController@RecordJoinView');
	Route::get('/RecorGroup', 'RecordController@RecorGroupView');
	Route::get('/RecordActivity', 'RecordController@RecordActivityView');
	Route::get('/RecordTeatch', 'RecordController@RecordTeatchView');
	
});

Route::post('/doShowUsers', 'PersonnelController@doShowUsers');








