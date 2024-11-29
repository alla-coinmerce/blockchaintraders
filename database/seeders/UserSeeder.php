<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role' => Role::ADMIN->value,
            'firstname' => 'Michel',
            'lastname' => 'ter Stege',
            'email' => 'michel@wpextensio.com',
            'welcome_valid_until' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('test1234567890'), // password
            'active' => true
        ]);

        User::create([
            'role' => Role::ADMIN->value,
            'firstname' => 'Michiel',
            'lastname' => 'van der Steeg',
            'email' => 'm.vandersteeg@blockchaintraders.nl',
            'welcome_valid_until' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('test1234567890'), // password
            'active' => true
        ]);

        User::create([
            'role' => Role::ADMIN->value,
            'firstname' => 'Justin',
            'lastname' => 'Kool',
            'email' => 'j.kool@blockchaintraders.nl',
            'welcome_valid_until' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('test1234567890'), // password
            'active' => true
        ]);

        User::factory()
            ->count(20)
            ->create();

    }
}
