<?php

class Kardex extends Eloquent {
	
	protected $table = 'kardex';

	protected $fillable = array('user_id', 'course_name', 'status', 'qualification');

	public $timestamps = false;

	public function student() {
		return $this->belongsTo('User');
	}
}