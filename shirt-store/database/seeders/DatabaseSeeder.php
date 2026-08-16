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
            'email' => 'admin@shirtstore.com',
            'role' => 'admin',
            'phone' => '+1234567890',
        ]);

        // Create test customer
        User::factory()->create([
            'name' => 'John Customer',
            'email' => 'customer@shirtstore.com',
            'role' => 'customer',
            'phone' => '+0987654321',
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
