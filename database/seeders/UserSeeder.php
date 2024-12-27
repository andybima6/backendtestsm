<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $approvalRole = Role::where('name', 'approval')->first();

        User::create([
            'name' => 'Andy',
            'email' => 'waw@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        User::create([
            'name' => 'Brian Domani',
            'email' => 'brian@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'role_id' => $approvalRole->id, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
