<?php

class HistoryTableSeeder extends Seeder {

	public function run()
	{
		DB::table('history')->delete();

		$history = new History;
		$history->type = Config::get('history.EVENT_NEW_ACCOUNT');
		$history->event = '<strong>admin</strong> created an account.';
		$history->save();

		$history = new History;
		$history->type = Config::get('history.EVENT_NEW_ACCOUNT');
		$history->event = '<strong>analist</strong> created an account.';
		$history->save();
	}

}
