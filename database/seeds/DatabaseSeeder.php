<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = (new User)->create([
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => bcrypt('admin'),
            'first_name' => 'Mr.',
            'last_name'  => 'admin'
        ]);
    }
}
