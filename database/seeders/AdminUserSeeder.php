<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@malfaurengineering.co.uk']);
        $admin->name = 'Malfaur Administrator';
        $admin->password = Hash::make('admin12345');
        $admin->save();

        // Also ensure fallback admin test user
        $testUser = User::firstOrNew(['email' => 'test@example.com']);
        $testUser->name = 'Admin';
        $testUser->password = Hash::make('admin12345');
        $testUser->save();
    }
}
