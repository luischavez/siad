<?php

class Course extends Eloquent {
	
	protected $table = 'courses';

	protected $primaryKey = 'course_id';

	protected $fillable = array('course_name', 'description', 'password', 'created_at');

	public $timestamps = false;

	public function getTestsAttribute() {
		return $this->tests()->getQuery()->orderBy('start_date', 'ASC')->get();
	}

	public function getResourcesAttribute() {
		return $this->resources()->getQuery()->orderBy('created_at', 'ASC')->get();
	}

	public function teacher() {
		return $this->belongsTo('User', 'teacher_id');
	}

	public function students() {
		return $this->belongsToMany('User', 'users_courses');
	}

	public function tests() {
		return $this->hasMany('Test');
	}

	public function resources() {
		return $this->hasMany('Resource');
	}
}