<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the first administrator account.
     *
     * Credentials come from the environment so no password is committed to
     * GitHub (SRS 8.2). Set ADMIN_EMAIL and ADMIN_PASSWORD before seeding.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@greenexe.local');
        $password = env('ADMIN_PASSWORD');

        if (blank($password)) {
            $this->command?->warn('ADMIN_PASSWORD is not set — skipping admin user seed.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'GreenExE Administrator'),
                'password' => Hash::make($password),
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );

        $this->command?->info("Administrator ready: {$email}");
    }
}
