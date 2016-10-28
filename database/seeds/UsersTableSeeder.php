<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_admin = Role::where('name','Admin')->first();
        $role_worker = Role::where('name','Worker')->first();
        $role_client = Role::where('name','Client')->first();

        $admin = new User;
        $admin->first_name = 'Admin';
        $admin->last_name = 'Lastname';
        $admin->email = 'admin@example.com';
        $admin->password = 'admin';
        $admin->save();
        $admin->roles()->attach($role_admin);

        $worker = new User;
        $worker->first_name = 'Worker';
        $worker->last_name = 'Lastname';
        $worker->email = 'worker@example.com';
        $worker->password = 'worker';
        $worker->save();
        $worker->roles()->attach($role_worker);

        $client = new User;
        $client->first_name = 'Client';
        $client->last_name = 'Lastname';
        $client->email = 'client@example.com';
        $client->password = 'client';
        $client->save();
        $client->roles()->attach($role_client);

        $admin = new User;
        $admin->first_name = 'Ukrit';
        $admin->last_name = 'Pornpatanapaisarnkul';
        $admin->email = 'upornpatanapaisarnkul@castlecs.com';
        $admin->password = 'castlecs';
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->first_name   = 'Albina';
        $admin->last_name    = 'Beresnyeva';
        $admin->email        = 'albina@castlecs.com';
        $admin->password     = 'castlecs';
        $admin->phone_number = '6046700520';
        $admin->address      = '#101 - 1220 West 6th Avenue';
        $admin->city         = 'Vancouver';
        $admin->province     = 'BC';
        $admin->postalcode   = 'V6H1A5';
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->first_name   = 'Mike';
        $admin->last_name    = 'Okada';
        $admin->email        = 'mike@castlecs.com';
        $admin->password     = 'castlecs';
        $admin->phone_number = '6041111111';
        $admin->address      = '111 Main st';
        $admin->city         = 'Vancouver';
        $admin->province     = 'BC';
        $admin->postalcode   = 'V1A1A1';
        $admin->status       = 0;
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
