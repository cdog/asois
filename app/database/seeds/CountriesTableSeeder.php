<?php

class CountriesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('countries')->delete();

		$json = File::get(storage_path().'/data/countries.json');
		$countries = json_decode($json);

		foreach ($countries as $country) {
			Country::create(array('iso2' => $country->iso2, 'name' => $country->name));
		}
	}

}
