<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $user = User::firstOrCreate([
            'email' => 'webmaster@nosuchagency.dk'
        ], [
            'name' => 'webmaster',
            'password' => 'password12',
            'role_id' => Role::where('name', 'admin')->first()->id
        ]);

        activity()->enableLogging();
    }
}
