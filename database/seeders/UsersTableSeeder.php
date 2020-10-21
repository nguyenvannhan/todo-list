<?php

namespace Database\Seeders;

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
        User::factory(10)->create();

        User::create([
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'name' => 'Admin',
            'role_id' => User::ROLE_ADMIN
        ]);
    }
}
