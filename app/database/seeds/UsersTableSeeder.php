<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$readEvents = new Permission;
		$readEvents->name = 'read_events';
		$readEvents->display_name = 'Read Events';
		$readEvents->save();

		$createPolls = new Permission;
		$createPolls->name = 'create_polls';
		$createPolls->display_name = 'Create Polls';
		$createPolls->save();

		$deletePolls = new Permission;
		$deletePolls->name = 'delete_polls';
		$deletePolls->display_name = 'Delete Polls';
		$deletePolls->save();

		$editPolls = new Permission;
		$editPolls->name = 'edit_polls';
		$editPolls->display_name = 'Edit Polls';
		$editPolls->save();

		$readPollResults = new Permission;
		$readPollResults->name = 'read_poll_results';
		$readPollResults->display_name = 'Read Poll Results';
		$readPollResults->save();

		$readPollStatistics = new Permission;
		$readPollStatistics->name = 'read_poll_statistics';
		$readPollStatistics->display_name = 'Read Poll Statistics';
		$readPollStatistics->save();

		$administrator = new Role;
		$administrator->name = 'Administrator';
		$administrator->save();
		$administrator->perms()->sync(array($readEvents->id, $createPolls->id, $deletePolls->id, $editPolls->id, $readPollResults->id, $readPollStatistics->id));

		$analyst = new Role;
		$analyst->name = 'Analyst';
		$analyst->save();
		$analyst->perms()->sync(array($readPollResults->id, $readPollStatistics->id));

		$subscriber = new Role;
		$subscriber->name = 'Subscriber';
		$subscriber->save();

		$country = Country::where('iso2', 'RO')->first();

		$user = User::create(array('name' => 'admin', 'password' => Hash::make('admin'), 'country_id' => $country->id));
		$user->attachRole($administrator);

		$user = User::create(array('name' => 'analist', 'password' => Hash::make('analist'), 'country_id' => $country->id));
		$user->attachRole($analyst);
	}

}
