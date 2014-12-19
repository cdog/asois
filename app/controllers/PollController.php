<?php

class PollController extends BaseController {

	public function getPolls()
	{
		$polls = Poll::orderBy('created_at', 'DESC')->get();
		$showing = $polls->count();
		$count = Poll::count();

		return View::make('polls.index', array('polls' => $polls, 'showing' => $showing, 'count' => $count));
	}

	public function getOpenPolls()
	{
		$polls = Poll::where('open', true)->orderBy('created_at', 'DESC')->get();
		$showing = $polls->count();
		$count = Poll::count();

		return View::make('polls.index', array('polls' => $polls, 'showing' => $showing, 'count' => $count));
	}

	public function getClosedPolls()
	{
		$polls = Poll::where('open', false)->orderBy('created_at', 'DESC')->get();
		$showing = $polls->count();
		$count = Poll::count();

		return View::make('polls.index', array('polls' => $polls, 'showing' => $showing, 'count' => $count));
	}

	public function getNewPoll()
	{
		$str = 'answer_';
		$len = strlen($str);
		$answers = array();

		foreach (array_keys(Input::old()) as $key) {
			if (substr($key, 0, $len) !== $str) continue;

			if (in_array($key, array('answer_id', 'answer_0', 'answer_1'))) continue;

			$answers[] = $key;
		}

		return View::make('polls.create', array('answers' => $answers));
	}

	public function postNewPoll()
	{
		$input = Input::all();
		$hasError = false;
		$poll = new Poll;
		$str = 'answer_';
		$len = strlen($str);

		foreach ($input as $value)
		{
			if (empty($value)) $hasError = true;
		}

		if ($hasError)
		{
			return Redirect::back()->withInput()->with('alert_danger', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
		}

		$poll->question = $input['question'];
		$poll->open = true;
		$poll->save();

		foreach ($input as $key => $value) {
			if (substr($key, 0, $len) !== $str) continue;

			if ($key == 'answer_id') continue;

			$answer = new Answer;

			$answer->answer = $value;
			$answer->poll_id = $poll->id;

			$answer->save();
		}

		$history = new History;
		$history->type = Config::get('history.EVENT_NEW_POLL');
		$history->event = '<strong>'.Auth::user()->name.'</strong> created the <a href="'.URL::route('poll', array($poll->id)).'">'.$poll->question.'</a> poll.';
		$history->save();

		return Redirect::route('poll', array($poll->id));
	}

	public function getPoll($id)
	{
		$poll = Poll::findOrFail($id);
		$answers = Answer::where('poll_id', $id)->get();

		Event::fire('polls.view', array($poll));

		return View::make('polls.poll', array('poll' => $poll, 'answers' => $answers));
	}

	public function postPoll($id)
	{
		$poll = Poll::findOrFail($id);
		$hasError = false;

		if ( ! $poll->open || $poll->answered) $hasError = true;

		if ( ! Input::has('answer')) $hasError = true;

		$answerId = Input::get('answer');

		if ( ! Answer::where('id', $answerId)->exists()) $hasError = true;

		if ($hasError)
		{
			return Redirect::back()->withInput()->with('alert_danger', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
		}

		Auth::user()->answers()->attach($answerId);

		$history = new History;
		$history->type = Config::get('history.EVENT_ANSWER_POLL');
		$history->event = '<strong>'.Auth::user()->name.'</strong> answered the <a href="'.URL::route('poll', array($poll->id)).'">'.$poll->question.'</a> poll.';
		$history->save();

		return Redirect::route('poll', array($id));
	}

	public function getPollResults($id)
	{
		$poll = Poll::findOrFail($id);
		$answers = Answer::where('poll_id', $id)->get();

		return View::make('polls.results', array('poll' => $poll, 'answers' => $answers));
	}

	public function getPollStatistics($id)
	{
		$poll = Poll::findOrFail($id);
		$answers = Answer::where('poll_id', $id)->get();
		$statistics = array();

		foreach ($answers as $answer) {
			$statistics[$answer->id] = array();

			foreach ($answer->statistics as $iso2 => $count) {
				array_push($statistics[$answer->id], array('id' => $iso2, 'value' => $count));
			}
		}

		return View::make('polls.statistics', array('poll' => $poll, 'answers' => $answers, 'statistics' => json_encode($statistics)));
	}

	public function getClosePoll($id)
	{
		$poll = Poll::findOrFail($id);
		$poll->open = false;
		$poll->save();

		$history = new History;
		$history->type = Config::get('history.EVENT_CLOSE_POLL');
		$history->event = '<strong>'.Auth::user()->name.'</strong> closed the <a href="'.URL::route('poll', array($poll->id)).'">'.$poll->question.'</a> poll.';
		$history->save();

		return Redirect::route('poll', array($id));
	}

	public function getOpenPoll($id)
	{
		$poll = Poll::findOrFail($id);
		$poll->open = true;
		$poll->save();

		$history = new History;
		$history->type = Config::get('history.EVENT_REOPEN_POLL');
		$history->event = '<strong>'.Auth::user()->name.'</strong> reopened the <a href="'.URL::route('poll', array($poll->id)).'">'.$poll->question.'</a> poll.';
		$history->save();

		return Redirect::route('poll', array($id));
	}

	public function getDeletePoll($id)
	{
		$poll = Poll::findOrFail($id);

		$history = new History;
		$history->type = Config::get('history.EVENT_DELETE_POLL');
		$history->event = '<strong>'.Auth::user()->name.'</strong> deleted the <a href="'.URL::route('poll', array($poll->id)).'">'.$poll->question.'</a> poll.';
		$history->save();

		$poll->delete();

		return Redirect::to('/');
	}

}
