<?php

class AuthController extends BaseController {

	protected $layout = 'layouts.guest';

	public function welcome() {
		$this->layout->content = View::make('auth.welcome');
	}

	public function register() {
		$this->layout->content = View::make('auth.register');
	}

	public function login() {
		$this->layout->content = View::make('auth.login');
	}

	public function create() {
		$input = Input::only('first_name', 'last_name', 'email', 'user_name', 'password', 'password_confirmation');

		$validator = Validator::make($input,
			array(
				'first_name' => 'required|alpha|min:4|max:20',
				'last_name' => 'required|alpha|min:4|max:20',
				'email' => "required|email|unique:users",
				'user_name' => 'required|alpha_dash|min:5|max:15|unique:users',
				'password' => 'required|confirmed|min:5|max:20'
			)
		);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		if (User::create($input)) {
			Session::push('messages', array('type' => 'info', 'text' => 'Usuario registrado correctamente!'));

			return Redirect::route('login');
		}

		Session::push('messages', array('type' => 'danger', 'text' => 'No se puede completar el registro!'));

		return Redirect::back()->withInput($input);
	}

	public function doLogin() {
		$input = Input::only('user_name', 'password');

		$validator = Validator::make($input,
			array(
				'user_name' => 'required',
				'password' => 'required'
			)
		);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput($input);
		}

		$input['user_name'] = strtolower($input['user_name']);

		if (!Auth::attempt($input, Input::has('remember'))) {
			Session::push('messages', array('type' => 'danger', 'text' => 'Usuario/Contraseña invalido[s]!'));

			return Redirect::back()->withInput($input);
		}

		return Redirect::route('dashboard');
	}

	public function doLogout() {
		if (Auth::logout()) {
			return Redirect::route('welcome');
		}

		return Redirect::back();
	}
}