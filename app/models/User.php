<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $table = 'users';

	protected $primaryKey = 'user_id';

	protected $hidden = array('password');

	protected $fillable = array('first_name', 'last_name', 'email', 'user_name', 'password');

	public $timestamps = false;

	public function getAvatarAttribute() {
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?d=mm";
	}

	public function getAnswer(Question $question) {
		if ($this->questions->contains($question->question_id)) {
			return $this->questions->find($question->question_id)->pivot->answer_text;
		}

		return '';
	}

	public function hasAnswer(Question $question, $answer_text) {
		foreach ($this->questions as $userQuestion) {
			if ($question->question_id === $userQuestion->question_id) {
				if ($userQuestion->pivot->answer_text == $answer_text) {
					return true;
				}
			}
		}

		return false;
	}

	public function setUserNameAttribute($value) {
		$this->attributes['user_name'] = strtolower($value);
	}

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

	public function getFullNameAttribute() {
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getAuthIdentifier() {
		return $this->getKey();
	}

	public function getAuthPassword() {
		return $this->password;
	}

	public function getReminderEmail() {
		return $this->email;
	}

	public function teacherCourses() {
		return $this->hasMany('Course', 'teacher_id');
	}

	public function studentCourses() {
		return $this->belongsToMany('Course', 'users_courses');
	}

	public function kardex() {
		return $this->hasMany('kardex');
	}

	public function questions() {
		return $this->belongsToMany('Question', 'users_questions')->withPivot('answer_text');
	}

	public function tests() {
		return $this->belongsToMany('Test', 'users_tests')->withPivot('started_at', 'is_finished', 'qualification');
	}
}