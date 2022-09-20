<?php

use Illuminate\Database\Seeder;
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
        $user=[
            'name'=>'govind',
            'email'=>'test@gmail.com',
            'password'=>bcrypt('govind123')
        ];
        
        User::create($user);
    }
}
