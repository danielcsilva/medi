<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if (env('SUPERADMIN_NAME') == '' || env('SUPERADMIN_EMAIL') == '' || env('SUPERADMIN_PASSWORD') == '') {
            $this->command->alert('ERRO: O Super Admin não está configurado no arquivo .env');
        }

        $user = User::create([
                'name' => env('SUPERADMIN_NAME'),
                'email' => env('SUPERADMIN_EMAIL'),
                'email_verified_at' => now(),
                'password' => Hash::make(env('SUPERADMIN_PASSWORD')), // password
                'remember_token' =>  Str::random(10),
        ]);

        $user->assignRole('SuperAdmin');
    }
}
