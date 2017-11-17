<?php

Auth::routes();

Route::get('/', function () {
	if (Auth::check()){
		return redirect('home');
	} else {
    	return redirect('p-home');
	}
});

Route::get('/p-home', 'DashboardController@index')->name('p-home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('institutions', 'pub\InstitutionController@index');
Route::get('institutions/{slug}', 'pub\InstitutionController@show');

Route::get('persons', 'pub\PersonController@index');
Route::get('persons/{slug}', 'pub\PersonController@show');

Route::get('students', 'pub\StudentController@index');
Route::get('students/{slug}', 'pub\StudentController@show');

Route::get('achievements', 'pub\AchievementController@index');
Route::get('achievements/{slug}', 'pub\AchievementController@show');




























Route::group(['prefix'=>'admin'], function() {	
	
	Route::get('achievements', 'admin\AchievementController@index');
	Route::get('data/block-achievement-statistic/{ins}', 'admin\AchievementController@achievementStatistic');
	Route::post('achievements/ajax/create','admin\AchievementController@ajaxCreate');
	Route::post('achievements/ajax/update','admin\AchievementController@ajaxUpdate');
	Route::post('achievements/ajax/delete','admin\AchievementController@ajaxDelete');


	Route::resource('users', 'admin\UserController', [
		'names'=>[
			'index'=>'user.index'
		]
	]);

	Route::resource('almaruf_transactions', 'admin\AlmarufTransactionController');
	Route::get('data/block-almaruftransaction-statistic', 'admin\AlmarufTransactionController@AlmarufTransactionStatistic');
	Route::post('transactions/ajax/create','admin\AlmarufTransactionController@ajaxCreate');
	Route::post('transactions/ajax/update','admin\AlmarufTransactionController@ajaxUpdate');
	Route::post('transactions/ajax/delete','admin\AlmarufTransactionController@ajaxDelete');


	Route::post('persons/ajax/update','admin\PersonController@ajaxUpdate');
	Route::post('persons/ajax/create','admin\PersonController@ajaxCreate');
	Route::post('persons/ajax/delete','admin\PersonController@ajaxDelete');
	Route::resource('persons', 'admin\PersonController');
	Route::get('persons/{slug}','admin\PersonController@show');	
	
	
	Route::resource('institutions', 'admin\InstitutionController');
	
	Route::post('institutions/ajax/update','admin\InstitutionController@ajaxUpdate');
	Route::post('institutions/ajax/create','admin\InstitutionController@ajaxCreate');
	Route::post('institutions/ajax/delete','admin\InstitutionController@ajaxDelete');

	Route::get('institutions/{slug}','admin\InstitutionController@show');


	Route::resource('class-groups', 'admin\ClassGroupController');
	
	Route::get('data/block-student-statistic', 'admin\StudentController@studentStatistic');
	Route::post('students/ajax/update','admin\StudentController@ajaxUpdate');
	Route::post('students/ajax/create','admin\StudentController@ajaxCreate');
	Route::post('students/ajax/delete','admin\StudentController@ajaxDelete');
	
	Route::get('students','admin\StudentController@index');
	Route::get('students/{slug}','admin\StudentController@show');
	
	//Route::resource('students', 'admin\StudentController');
});
	

Route::get('data/i-teachers','DashboardController@institutionTeacher');
Route::get('data/i-students','DashboardController@institutionStudent');
Route::get('data/i-achievements','DashboardController@institutionAchievement');

Route::get('data/almaruf-transactions/{arg}','admin\AlmarufTransactionController@indexData');

Route::get('data/achievements/{ins}/{stg}/{group}', [ 'uses'=>'admin\AchievementController@indexData' ]);

Route::get('data/student/{student_id}', 'admin\StudentController@student');
Route::get('data/student-achievements/{student_id}', 'admin\StudentController@studentAchievements');
Route::get('data/student-transactions/{student_id}', 'admin\StudentController@studentTransactions');

Route::get('pub/data/persons','pub\PersonController@dataIndex');	
Route::get('pub/data/students','pub\StudentController@dataIndex');	
Route::get('data/persons','admin\PersonController@data');
Route::get('data/students/{ins}/{group}/{status}','admin\StudentController@dataIndex');

Route::get('coba', function(){
	return View::make('public.include.last_achievement');
});
Route::post('upload','TesController@upload');

Route::get('/convert/togregorian/{hijri}','HijriController@toGregorian');


Route::get('/setroles', function(){

//Bouncer::disallow('admin')->to(['manage-class_groups']);
	
	// Bouncer::allow('user')->to([
	// 	'manage-persons',
	// 	'manage-students',
	// 	'manage-achievements'
	// ]);

	// Bouncer::allow('admin')->to([
	// 	'manage-users',
	// 	'manage-class_groups',
	// 	'manage-institutions',
	// 	'manage-persons',
	// 	'manage-students',
	// 	'manage-achievements'
	// ]);

	 App\User::find(13)->allow('view-almaruf_transaction_stat');
	 //App\User::find(13)->allow('manage-almaruf_transactions');
	// App\User::find(14)->assign('user');


	//Bouncer::allow('admin')->to('manage-institution');


	//Bouncer::retract($user)->everything();
	//$user->retract('admin');
	//$user->disallow('manage-users');
	//$user->assign('admin');
	//Bouncer::sync($user)->roles('admin');
	//Bouncer::sync($user)->abilities($abilities);
});
	
	Route::get('/umi', function(){
		$s = App\Student::where('institution_id','9')->where('group_id','=','3')->orderBy('fullname','asc')->get();
		foreach ($s as $v) {
			echo $v->fullname.",".$v->birth_place.",".optional($v->birth_date)->format('d-m-Y').",".$v->parent.",".$v->address."<br>";
		}
	});

	Route::get('/tes', function(){

        $a = App\Achievement::join('stages', 'achievements.stage_id', '=', 'stages.id')
        ->select('achievements.*')
        ->whereStudent_id(2027)->orderBy('stages.weight','asc')->get();
		
        // $b->each(function($item){
        // 	$item->setAttribute('asd','asdas');
        // });
		 

		dd($a);

	});
