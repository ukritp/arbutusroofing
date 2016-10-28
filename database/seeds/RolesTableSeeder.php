<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'This is for office admins';
        $role_admin->save();

        $role_worker = new Role();
        $role_worker->name = 'Worker';
        $role_worker->description = 'This is for worker';
        $role_worker->save();

        $role_client = new Role();
        $role_client->name = 'Client';
        $role_client->description = 'This is for client';
        $role_client->save();
    }
}
