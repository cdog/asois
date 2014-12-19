<?php

class Poll extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'polls';

	protected $appends = array('answered');

	public function answers()
	{
		return $this->hasMany('Answer');
	}

	public function getAnsweredAttribute()
	{
		if ( ! Auth::check()) return false;

		$poll = Poll::findOrFail($this->attributes['id']);
		$userId = Auth::user()->id;

		foreach ($poll->answers as $answer) {
			if ($answer->users()->where('user_id', $userId)->exists())
			{
				return $answer->id;
			}
		}

		return false;
	}

}
