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
        $data = [
            [
                'name' => 'Nguyen Chi',
                'email' => 'abc@gmail.com',
                'phone' => '123456789',
                'password' => bcrypt('123456'),
                'address' => strtolower(str_random(20)),
                'role_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Bach Nguyen',
                'email' => 'bach@gmail.com',
                'phone' => '123456789',
                'password' => bcrypt('123456'),
                'address' => strtolower(str_random(20)),
                'role_id' => 1,
                'active' => 1
            ]
        ];

        for ($i = 0 ; $i < 2 ; $i++) {
            $user = [
                'name' => str_random(6),
                'phone' => '123456789',
                'email' => strtolower(str_random(6)).'@gmail.com',
                'password' => bcrypt('123456'),
                'address' => strtolower(str_random(20)),
                'role_id' => rand(2,3),
                'active' => 1
            ];
            $data[] = $user;
        }

        DB::table('users')->insert($data);
    }
}
