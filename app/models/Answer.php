<?php

class Answer extends Eloquent {

	protected $table = 'answers';

	protected $primaryKey = 'answer_id';

	protected $fillable = array('answer_text', 'is_correct');

	public $timestamps = false;

	public function question() {
		return $this->belongsTo('Question');
	}
}