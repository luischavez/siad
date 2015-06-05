<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('user', 'User');
Route::model('course', 'Course');
Route::model('resource', 'Resource');
Route::model('test', 'Test');
Route::model('question', 'Question');

Route::group(array('prefix' => 'auth'), function() {
	Route::get('', array(
		'as' => 'login',
		'before' => 'guest',
		'uses' => 'AuthController@login'
	));
	Route::get('welcome', array(
		'as' => 'welcome',
		'before' => 'guest',
		'uses' => 'AuthController@welcome'
	));
	Route::get('register', array(
		'as' => 'register',
		'before' => 'guest',
		'uses' => 'AuthController@register'
	));
	Route::post('create', array(
		'as' => 'user.create',
		'before' => 'guest',
		'uses' => 'AuthController@create'
	));
	Route::post('login', array(
		'as' => 'do.login',
		'before' => 'guest',
		'uses' => 'AuthController@doLogin'
	));
	Route::get('logout', array(
		'as' => 'do.logout',
		'before' => 'auth',
		'uses' => 'AuthController@doLogout'
	));
});

Route::group(array('before' => 'welcome'), function() {
	
	View::share('user', Auth::user());

	View::composer('layouts.default', function($view) {
		$links = array(
			array('name' => 'Inicio', 'route' => 'dashboard'),
			array('name' => 'Perfil', 'route' => array(
				'profile.view',
				'profile.edit',
			)),
			array('name' => 'Cursos', 'route' => array(
				'course.lists',
				'course.register',
				'course.add',
				'course.edit',
				'course.manager',
				'course.view',
				'course.qualifications',
				'resource.add',
				'resource.edit',
				'resource.view',
				'test.add',
				'test.edit',
				'test.info',
				'test.view',
				'test.manager',
				'test.publish',
				'test.qualifications',
				'question.add',
				'question.edit',
			)),
			array('name' => 'Kardex', 'route' => 'kardex'),
		);

		$view->with('links', $links);
	});

	Route::get('', array(
		'as' => 'dashboard',
		'uses' => 'DashboardController@dashboard'
	));

	Route::get('kardex', array(
		'as' => 'kardex',
		'uses' => 'DashboardController@kardex'
	));

	Route::group(array('prefix' => 'profile'), function() {
		Route::get('', array(
			'as' => 'profile.view',
			'uses' => 'ProfileController@view'
		));
		Route::get('edit', array(
			'as' => 'profile.edit',
			'uses' => 'ProfileController@edit'
		));
		Route::post('update', array(
			'as' => 'profile.update',
			'uses' => 'ProfileController@update'
		));
	});

	Route::group(array('prefix' => 'courses'), function() {
		Route::get('', array(
			'as' => 'course.lists',
			'uses' => 'CourseController@lists'
		));
		Route::get('add', array(
			'as' => 'course.add',
			'uses' => 'CourseController@add'
		));
		Route::post('create', array(
			'as' => 'course.create',
			'uses' => 'CourseController@create'
		));
		Route::get('edit/{course}', array(
			'as' => 'course.edit',
			'before' => 'course.teacher|course.available',
			'uses' => 'CourseController@edit'
		));
		Route::post('update/{course}', array(
			'as' => 'course.update',
			'before' => 'course.teacher|course.available',
			'uses' => 'CourseController@update'
		));
		Route::get('register/{course}', array(
			'as' => 'course.register',
			'before' => 'course.candidat|course.available',
			'uses' => 'CourseController@register'
		));
		Route::post('subscribe/{course}', array(
			'as' => 'course.subscribe',
			'before' => 'course.candidat|course.available',
			'uses' => 'CourseController@subscribe'
		));
		Route::get('manager/{course}', array(
			'as' => 'course.manager',
			'before' => 'course.teacher',
			'uses' => 'CourseController@manager'
		));
		Route::get('cancel/{course}', array(
			'as' => 'course.cancel',
			'before' => 'course.teacher',
			'uses' => 'CourseController@cancel'
		));
		Route::get('start/{course}', array(
			'as' => 'course.start',
			'before' => 'course.teacher|course.available',
			'uses' => 'CourseController@start'
		));
		Route::get('close/{course}', array(
			'as' => 'course.close',
			'before' => 'course.teacher|course.started',
			'uses' => 'CourseController@close'
		));
		Route::get('view/{course}', array(
			'as' => 'course.view',
			'before' => 'course.student|course.started',
			'uses' => 'CourseController@view'
		));
		Route::get('unsubscribe/{course}', array(
			'as' => 'course.unsubscribe',
			'before' => 'course.student|course.started',
			'uses' => 'CourseController@unsubscribe'
		));
		Route::get('qualifications/{course}', array(
			'as' => 'course.qualifications',
			'before' => 'course.student|course.started',
			'uses' => 'CourseController@qualifications'
		));
	});

	Route::group(array('prefix' => 'resources'), function() {
		Route::get('{course}/add/{type}', array(
			'as' => 'resource.add',
			'before' => 'course.teacher',
			'uses' => 'ResourceController@add'
		))->where('type', 'video|file|url');
		Route::post('{course}/create', array(
			'as' => 'resource.create',
			'before' => 'course.teacher',
			'uses' => 'ResourceController@create'
		));
		Route::get('edit/{resource}', array(
			'as' => 'resource.edit',
			'before' => 'resource.teacher',
			'uses' => 'ResourceController@edit'
		));
		Route::post('update/{resource}', array(
			'as' => 'resource.update',
			'before' => 'resource.teacher',
			'uses' => 'ResourceController@update'
		));
		Route::get('delete/{resource}', array(
			'as' => 'resource.delete',
			'before' => 'resource.teacher',
			'uses' => 'ResourceController@delete'
		));
		Route::get('view/{resource}', array(
			'as' => 'resource.view',
			'before' => 'resource.both',
			'uses' => 'ResourceController@view'
		));
		Route::get('download/{resource}', array(
			'as' => 'resource.download',
			'before' => 'resource.both',
			'uses' => 'ResourceController@download'
		));
	});

	Route::group(array('prefix' => 'tests'), function() {
		Route::get('{course}/add', array(
			'as' => 'test.add',
			'before' => 'course.teacher',
			'uses' => 'TestController@add',
		));
		Route::post('{course}/create', array(
			'as' => 'test.create',
			'before' => 'course.teacher',
			'uses' => 'TestController@create',
		));
		Route::get('edit/{test}', array(
			'as' => 'test.edit',
			'before' => 'test.teacher|test.editable',
			'uses' => 'TestController@edit',
		));
		Route::post('update/{test}', array(
			'as' => 'test.update',
			'before' => 'test.teacher|test.editable',
			'uses' => 'TestController@update',
		));
		Route::get('delete/{test}', array(
			'as' => 'test.delete',
			'before' => 'test.teacher|test.editable',
			'uses' => 'TestController@delete',
		));
		Route::get('manager/{test}', array(
			'as' => 'test.manager',
			'before' => 'test.teacher|test.editable',
			'uses' => 'TestController@manager',
		));
		Route::get('{course}/publish/{test}', array(
			'as' => 'test.publish',
			'before' => 'test.teacher|test.editable|test.filled|course.started',
			'uses' => 'TestController@publish',
		));
		Route::post('{course}/publish/{test}', array(
			'as' => 'test.do.publish',
			'before' => 'test.teacher|test.editable|test.filled|course.started',
			'uses' => 'TestController@doPublish',
		));
		Route::get('info/{test}', array(
			'as' => 'test.info',
			'before' => 'test.student',
			'uses' => 'TestController@info'
		));
		Route::get('view/{test}', array(
			'as' => 'test.view',
			'before' => 'test.student|test.valid',
			'uses' => 'TestController@view'
		));
		Route::post('submit/{test}', array(
			'as' => 'test.submit',
			'before' => 'test.student|test.valid',
			'uses' => 'TestController@submit'
		));
		Route::get('qualifications/{test}', array(
			'as' => 'test.qualifications',
			'before' => 'test.teacher|test.finalized',
			'uses' => 'TestController@qualifications'
		));
	});

	Route::group(array('prefix' => 'questions'), function() {
		Route::get('{test}/add/{type}', array(
			'as' => 'question.add',
			'before' => 'test.teacher|test.editable',
			'uses' => 'QuestionController@add'
		))->where('type', 'open|choice|multiple');
		Route::post('{test}/create', array(
			'as' => 'question.create',
			'before' => 'test.teacher|test.editable',
			'uses' => 'QuestionController@create'
		));
		Route::get('{test}/edit/{question}', array(
			'as' => 'question.edit',
			'before' => 'test.teacher|test.editable',
			'uses' => 'QuestionController@edit'
		));
		Route::post('{test}/update/{question}', array(
			'as' => 'question.update',
			'before' => 'test.teacher|test.editable',
			'uses' => 'QuestionController@update'
		));
		Route::get('{test}/delete/{question}', array(
			'as' => 'question.delete',
			'before' => 'test.teacher|test.editable',
			'uses' => 'QuestionController@delete'
		));
	});
});