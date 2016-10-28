<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Company::class, 5)->create()->each(function($company) {
            $company->properties()->saveMany(factory(App\Property::class,2)->make());
        });
    }
}
