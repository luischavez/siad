<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request) {
});


App::after(function($request, $response) {
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function() {
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function() {
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function() {
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function() {
	if (Session::token() != Input::get('_token')) {
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('welcome', function() {
	if (!Auth::check()) {
		return Redirect::route('welcome');
	}
});

Route::filter('course.teacher', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('course');

	if (!$user->teacherCourses->contains($course->course_id)) {
		return Redirect::route('course.lists');
	}
});
Route::filter('course.student', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('course');

	if (!$user->studentCourses->contains($course->course_id)) {
		return Redirect::route('course.lists');
	}
});
Route::filter('course.candidat', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('course');

	if ($user->teacherCourses->contains($course->course_id)) {
		return Redirect::route('course.manager', $course->course_id);
	}

	if ($user->studentCourses->contains($course->course_id)) {
		return Redirect::route('course.view', $course->course_id);
	}
});
Route::filter('course.available', function($route) {
	$course = $route->getParameter('course');

	if ($course->started_at) {
		return Redirect::route('course.lists');
	}
});
Route::filter('course.closed', function($route) {
	$course = $route->getParameter('course');

	if (NULL != $course->closed_at) {
		Session::push('messages', array(
			'type' => 'info',
			'text' => "El curso '$course->course_name' todavia no termina"
		));
		
		return Redirect::route('course.lists');
	}
});
Route::filter('course.started', function($route) {
	$course = $route->getParameter('course');

	if (!$course->started_at) {
		Session::push('messages', array(
			'type' => 'info',
			'text' => "El curso '$course->course_name' todavia no inicia"
		));
		
		return Redirect::route('course.lists');
	}
});

Route::filter('resource.both', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('resource')->course;

	if (!$user->teacherCourses->contains($course->course_id)) {
		if (!$user->studentCourses->contains($course->course_id)) {
			return Redirect::route('course.lists');
		}

		if (!$course->started_at) {
			return Redirect::route('course.lists');
		}
	}
});
Route::filter('resource.teacher', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('resource')->course;

	if (!$user->teacherCourses->contains($course->course_id)) {
		return Redirect::route('course.lists');
	}
});
Route::filter('resource.student', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('resource')->course;

	if (!$user->studentCourses->contains($course->course_id)) {
		return Redirect::route('course.lists');
	}

	if (!$course->started_at) {
		return Redirect::route('course.lists');
	}
});

Route::filter('test.teacher', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('test')->course;

	if (!$user->teacherCourses->contains($course->course_id)) {
		return Redirect::route('course.lists');
	}
});
Route::filter('test.student', function($route) {
	$user = Auth::user();

	$course = $route->getParameter('test')->course;

	if (!$user->studentCourses->contains($course->course_id)) {
		return Redirect::route('course.lists');
	}

	if (!$course->started_at) {
		return Redirect::route('course.lists');
	}
});
Route::filter('test.valid', function($route) {
	$test = $route->getParameter('test');

	if (!$test->canStart(Auth::user())) {
		return Redirect::route('test.info', $test->test_id);
	}
});
Route::filter('test.editable', function($route) {
	$test = $route->getParameter('test');

	if (!$test->isEditable()) {
		return Redirect::route('course.manager', $test->course->course_id);
	}
});
Route::filter('test.finalized', function($route) {
	$test = $route->getParameter('test');

	if (!$test->isFinalized()) {
		return Redirect::route('course.manager', $test->course->course_id);
	}
});
Route::filter('test.filled', function($route) {
	$test = $route->getParameter('test');

	if (!$test->hasQuestions()) {
		return Redirect::route('course.manager', $test->course->course_id);
	}
});