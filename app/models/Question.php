<?php

class Question extends Eloquent {

	protected $table = 'questions';

	protected $primaryKey = 'question_id';

	protected $fillable = array('question_text', 'type', 'points');

	public $timestamps = false;

	public function is($type) {
		return $this->type === $type;
	}
	
	public function test() {
		return $this->belongsTo('Test');
	}

	public function answers() {
		return $this->hasMany('Answer');
	}

	public function students() {
		return $this->belongsToMany('User', 'users_questions')->withPivot('answer_text');
	}
}