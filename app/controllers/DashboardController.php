<?php

class DashboardController extends BaseController {

	protected $layout = 'layouts.default';

	public function dashboard() {
		$user = Auth::user();

		$courses = Course::where('teacher_id', '!=', $user->user_id)
			->whereNull('started_at')
			->orderBy('created_at', 'DESC')
			->take(10)
			->get();

		$this->layout->content = View::make('dashboard')
			->with('courses', $courses);
	}

	public function kardex() {
		$this->layout->content = View::make('kardex');
	}
}