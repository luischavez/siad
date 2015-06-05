<?php

class UrlResource extends Eloquent {
	
	protected $table = 'url_resources';

	protected $primaryKey = 'resource_id';

	protected $fillable = array('url');

	public $timestamps = false;

	public function resource() {
		return $this->belongsTo('Resource');
	}
}