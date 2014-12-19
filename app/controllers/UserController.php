<?php

class UserController extends BaseController {

	public function getJoin()
	{
		$countries = Country::orderBy('name')->lists('name', 'id');

		return View::make('users.join')->with('countries', $countries);
	}

	public function postJoin()
	{
		$input = Input::all();
		$hasError = false;
		$user = new User;

		foreach ($input as $value)
		{
			if (empty($value)) $hasError = true;
		}

		if (User::where('name', $input['name'])->exists())
		{
			$hasError = true;
		}
		else
		{
			$user->name = $input['name'];
		}

		if ($input['password'] == $input['password_confirmation'])
		{
			$user->password = Hash::make($input['password']);
		}
		else
		{
			$hasError = true;
		}

		if (Country::where('id', $input['country'])->exists())
		{
			$user->country_id = $input['country'];
		}
		else
		{
			$hasError = true;
		}

		if ($hasError)
		{
			return Redirect::back()->withInput()->with('alert_danger', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
		}

		$user->save();

		$subscriber = Role::where('name', 'Subscriber')->first();

		$user->attachRole($subscriber);

		$history = new History;
		$history->type = Config::get('history.EVENT_NEW_ACCOUNT');
		$history->event = '<strong>'.$user->name.'</strong> created an account.';
		$history->save();

		return Redirect::to('login')->withInput($input)->with('alert_success', '<strong>Well done!</strong> You successfully read this important alert message.');
	}

	public function getLogin()
	{
		return View::make('users.login');
	}

	public function postLogin()
	{
		$input = Input::all();

		if (Auth::attempt(array('name' => $input['name'], 'password' => $input['password'])))
		{
			$history = new History;
			$history->type = Config::get('history.EVENT_LOGIN');
			$history->event = '<strong>'.Auth::user()->name.'</strong> signed in.';
			$history->save();

			return Redirect::intended('/');
		}

		return Redirect::back()->withInput()->with('alert_danger', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
	}

	public function getLogout()
	{
		Session::forget('polls.history');

		$history = new History;
		$history->type = Config::get('history.EVENT_LOGOUT');
		$history->event = '<strong>'.Auth::user()->name.'</strong> signed out.';
		$history->save();

		Auth::logout();

		return Redirect::to('/');
	}

}
