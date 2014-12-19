<?php

class Answer extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'answers';

	protected $appends = array('results', 'statistics');

	public function poll()
	{
		return $this->belongsTo('Poll');
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}

	public function getResultsAttribute()
	{
		$answers = DB::table('answer_user')
			->join('answers', 'answer_user.answer_id', '=', 'answers.id')
			->join('polls', 'answers.poll_id', '=', 'polls.id')
			->where('polls.id', $this->attributes['poll_id']);

		$total = $answers->count();

		if ( ! $total) return 0;

		$count = $answers->where('answers.id', $this->attributes['id'])->count();

		return (int) ($count / $total * 100);
	}

	public function getStatisticsAttribute()
	{
		$answers = DB::table('answer_user')
			->join('answers', 'answer_user.answer_id', '=', 'answers.id')
			->join('polls', 'answers.poll_id', '=', 'polls.id')
			->where('polls.id', $this->attributes['poll_id'])
			->where('answers.id', $this->attributes['id'])
			->get();

		$statistics = array();

		foreach ($answers as $answer) {
			$iso2 = User::find($answer->user_id)->country->iso2;

			if (isset($statistics[$iso2]))
			{
				$statistics[$iso2]++;
			}
			else
			{
				$statistics[$iso2] = 1;
			}
		}

		return $statistics;
	}

}
