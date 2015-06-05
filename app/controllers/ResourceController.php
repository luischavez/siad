<?php

class ResourceController extends BaseController {

	protected $layout = 'layouts.default';

	public function add(Course $course, $type) {
		$this->layout->content = View::make('resources.add')
			->with('course', $course)
			->with('type', $type);
	}

	private function createVideoResource(Course $course) {
		$input = Input::only('title', 'description', 'type', 'url');

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500',
			'url' => array('required', 'url', "regex:/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/")
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$resource = new Resource($input);

		$course->resources()->save($resource);

		$videoResource = new VideoResource($input);

		$resource->toVideo()->save($videoResource);

		return Redirect::route('course.manager', $course->course_id);
	}

	private function createFileResource(Course $course) {
		$input = Input::only('title', 'description', 'type');
		$input = array_add($input, 'file', Input::file('upload'));

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500',
			'file' => 'required|max:10240'
		));

		if ($validator->fails()) {
			$input = array_forget($input, 'file');

			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$resource = new Resource($input);

		$course->resources()->save($resource);

		$file = Input::file('upload');

		$fileResource = new FileResource(array(
			'file_name' => $file->getClientOriginalName(),
			'is_pdf' => 'application/pdf' === $file->getMimeType()
		));

		if ($file->move('uploads/resources', $resource->resource_id)) {
			$resource->toFile()->save($fileResource);
		} else {
			$resource->delete();
		}		

		return Redirect::route('course.manager', $course->course_id);
	}

	private function createUrlResource(Course $course) {
		$input = Input::only('title', 'description', 'type', 'url');

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500',
			'url' => 'required|url'
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$resource = new Resource($input);

		$course->resources()->save($resource);

		$urlResource = new UrlResource($input);

		$resource->toUrl()->save($urlResource);

		return Redirect::route('course.manager', $course->course_id);
	}

	public function create(Course $course) {
		if (Input::has('type')) {
			switch (Input::get('type')) {
				case 'video':
					return $this->createVideoResource($course);
				case 'file':
					return $this->createFileResource($course);
				case 'url':
					return $this->createUrlResource($course);
			}
		}

		return Redirect::route('course.manager', $course->course_id);
	}

	public function edit(Resource $resource) {
		$this->layout->content = View::make('resources.edit')
			->with('course', $resource->course)
			->with('resource', $resource);
	}

	private function updateVideoResource(Resource $resource) {
		$input = Input::only('title', 'description', 'attached');

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500',
			'attached' => array('required', 'url', "regex:/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/")
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$resource->update($input);

		$resource->toVideo()->update(array(
			'url' => Input::get('attached')
		));

		return Redirect::route('course.manager', $resource->course->course_id);
	}

	private function updateFileResource(Resource $resource) {
		$input = Input::only('title', 'description');
		$input = array_add($input, 'file', Input::file('upload'));
		
		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500',
			'file' => 'max:10240'
		));

		if ($validator->fails()) {
			$input = array_forget($input, 'file');

			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$resource->update($input);

		if (Input::hasFile('upload')) {
			$file = Input::file('upload');

			if (File::exists('uploads/resources/' . $resource->resource_id)) {
				File::delete('uploads/resources/' . $resource->resource_id);
			}

			$resource->toFile()->update(array(
				'file_name' => $file->getClientOriginalName(),
				'is_pdf' => 'application/pdf' === $file->getMimeType()
			));

			$file->move('uploads/resources', $resource->resource_id);
		}

		return Redirect::route('course.manager', $resource->course->course_id);
	}

	private function updateUrlResource(Resource $resource) {
		$input = Input::only('title', 'description', 'attached');

		$validator = Validator::make($input, array(
			'title' => 'required|min:5|max:120',
			'description' => 'max:500',
			'attached' => 'required|url'
		));

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$resource->update($input);

		$resource->toUrl()->update(array(
			'url' => Input::get('attached')
		));

		return Redirect::route('course.manager', $resource->course->course_id);
	}

	public function update(Resource $resource) {
		switch ($resource->type) {
			case 'video':
				return $this->updateVideoResource($resource);
			case 'file':
				return $this->updateFileResource($resource);
			case 'url':
				return $this->updateUrlResource($resource);
		}
	}

	public function delete(Resource $resource) {
		if (File::exists('uploads/resources/' . $resource->resource_id)) {
			File::delete('uploads/resources/' . $resource->resource_id);
		}
		
		$resource->delete();

		return Redirect::route('course.manager', $resource->course->course_id);
	}

	public function view(Resource $resource) {
		$this->layout->content = View::make('resources.view')
			->with('course', $resource->course)
			->with('resource', $resource);
	}

	public function download(Resource $resource) {
		if ($resource->is('file')) {
			return Response::download('uploads/resources/' . $resource->resource_id, $resource->toFile->file_name);
		}

		return Redirect::route('course.view', $resource->course->course_id);
	}
}