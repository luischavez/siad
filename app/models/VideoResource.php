<?php

class VideoResource extends Eloquent {
	
	protected $table = 'video_resources';

	protected $primaryKey = 'resource_id';

	protected $fillable = array('url');

	public $timestamps = false;

	public function getVideoIdAttribute() {
		if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $this->attributes['url'], $id)) {
			return $id[1];
		}

		return '';
	}

	public function resource() {
		return $this->belongsTo('Resource');
	}
}