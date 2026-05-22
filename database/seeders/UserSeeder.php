<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cpata.com.ar'],
            [
                'name'     => 'Administrador Cpata',
                'email'    => 'admin@cpata.com.ar',
                'password' => Hash::make('admin1234'),
            ]
        );
    }
}
