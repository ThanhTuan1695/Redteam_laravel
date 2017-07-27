<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'role' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'username' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('user123'),
            'role' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_user')->insert([
            'user_first_id' => 1,
            'user_second_id' => 2,
        ]);

        DB::table('rooms')->insert([
            'name' => 'room1',
            'user_id' => 1,
            'description' => "Lorem",
            'type' => 'public',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_room')->insert([
            'user_id' => 1,
            'room_id' => 1,
        ]);

        DB::table('user_room')->insert([
            'user_id' => 2,
            'room_id' => 1,
        ]);
    }
}
