<?php

class FileResource extends Eloquent {
	
	protected $table = 'file_resources';

	protected $primaryKey = 'resource_id';

	protected $fillable = array('file_name', 'is_pdf');

	public $timestamps = false;

	public function resource() {
		return $this->belongsTo('Resource');
	}
}