<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\User::class)->create([
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => bcrypt('admin'),
            'first_name' => 'Mr',
            'last_name'  => 'admin'
        ]);
    }
}
