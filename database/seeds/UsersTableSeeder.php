<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user                 = new User;
        $user->name           = 'Admin';
        $user->email          = 'admin@admin.oo';
        $user->password       = bcrypt('123456');
        $user->remember_token = str_random(10);
        $user->save();
    }
}
