<?php

class EventController extends BaseController {

	public function getEvents()
	{
		$events = History::orderBy('created_at', 'DESC')->get();

		return View::make('events.index', array('events' => $events));
	}

}
