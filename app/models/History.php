<?php

class History extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'history';

	protected $appends = array('color', 'icon');

	public function getColorAttribute()
	{
		$success = array(
			Config::get('history.EVENT_NEW_ACCOUNT'),
			Config::get('history.EVENT_NEW_POLL'),
			Config::get('history.EVENT_REOPEN_POLL'),
		);

		$danger = array(
			Config::get('history.EVENT_NEW_ACCOUNT'),
			Config::get('history.EVENT_CLOSE_POLL'),
			Config::get('history.EVENT_DELETE_POLL'),
		);

		if (in_array($this->attributes['type'], $success)) return 'text-success';

		if (in_array($this->attributes['type'], $danger)) return 'text-danger';

		return null;
	}

	public function getIconAttribute()
	{
		switch ($this->attributes['type'])
		{
			case Config::get('history.EVENT_NEW_ACCOUNT'): return 'plus';
			case Config::get('history.EVENT_LOGIN'): return 'log-in';
			case Config::get('history.EVENT_LOGOUT'): return 'log-out';
			case Config::get('history.EVENT_NEW_POLL'): return 'plus';
			case Config::get('history.EVENT_ANSWER_POLL'): return 'check';
			case Config::get('history.EVENT_CLOSE_POLL'): return 'remove-circle';
			case Config::get('history.EVENT_REOPEN_POLL'): return 'ok-circle';
			case Config::get('history.EVENT_DELETE_POLL'): return 'trash';
		}

		return 'bell';
	}

}
