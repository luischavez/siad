<?php

class ProfileController extends BaseController {

	protected $layout = 'layouts.default';

	public function view() {
		$this->layout->content = View::make('profiles.view');
	}

	public function edit() {
		$this->layout->content = View::make('profiles.edit');
	}

	public function update() {
		$input = Input::only('first_name', 'last_name', 'email', 'password', 'new_password', 'new_password_confirmation');

		$user = Auth::user();

		$validator = Validator::make($input,
			array(
				'first_name' => 'alpha|min:4|max:20',
				'last_name' => 'alpha|min:4|max:20',
				'email' => "email|unique:users,email,$user->user_id,user_id",
				'password' => 'required',
				'new_password' => 'confirmed|min:5|max:20'
			)
		);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		if (!Hash::check($input['password'], $user->password)) {
			Session::push('messages', array('type' => 'danger', 'text' => 'Contraseña invalida!'));

			return Redirect::back()->withInput($input);
		}

		if ($input['new_password']) {
			$user->password = Hash::make($input['new_password']);
		}

		$user->update($input);

		return Redirect::route('profile.view');
	}
}