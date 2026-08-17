<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@urbancoff.com',
            'role' => 'admin',
            'phone' => '+91 98765 43210',
        ]);

        // Create test customer
        User::factory()->create([
            'name' => 'Rahul Sharma',
            'email' => 'customer@urbancoff.com',
            'role' => 'customer',
            'phone' => '+91 98765 12345',
        ]);

        // Create additional customers
        User::factory(8)->create([
            'role' => 'customer',
        ]);

        // Seed categories and products
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
