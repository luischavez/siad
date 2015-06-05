<?php

class Resource extends Eloquent {
	
	protected $table = 'resources';

	protected $primaryKey = 'resource_id';

	protected $fillable = array('title', 'description', 'type');

	public $timestamps = true;

	public function getAttachedAttribute() {
		switch ($this->type) {
			case 'video': return $this->toVideo->url;
			case 'file': return $this->toFile->file_name;
			case 'url': return $this->toUrl->url;
		}
	}

	public function is($type) {
		return $this->type === $type;
	}

	public function course() {
		return $this->belongsTo('Course');
	}

	public function toVideo() {
		return $this->is('video') ? $this->hasOne('VideoResource') : NULL;
	}

	public function toFile() {
		return $this->is('file') ? $this->hasOne('FileResource') : NULL;
	}

	public function toUrl() {
		return $this->is('url') ? $this->hasOne('UrlResource') : NULL;
	}
}