<?php

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
        DB::table('users')->insert(array(
            array(
                'username' => 'admin',
                'password' => bcrypt('admin1234'),
                'email' => 'admin@admin.com',
                'remember_token' => '',
                'avatar' => null,
                'alias' => 'admin',
                'last_logined_ip' => '0',
                'last_logined_at' => \Carbon\Carbon::now(),
                'logined_counts' => 0,
                'status' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            array(
                'username' => 'stephen',
                'password' => bcrypt('stephen1234'),
                'email' => 'stephenbeats@outlook.com',
                'remember_token' => '',
                'avatar' => null,
                'alias' => 'Stephen',
                'last_logined_ip' => '0',
                'last_logined_at' => \Carbon\Carbon::now(),
                'logined_counts' => 0,
                'status' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
    }
}
