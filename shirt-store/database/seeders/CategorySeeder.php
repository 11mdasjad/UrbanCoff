<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Formal Shirts',
                'slug' => 'formal-shirts',
                'description' => 'Elevate your professional wardrobe with our collection of premium formal shirts. Perfect for the boardroom, business meetings, and special occasions.',
                'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=800&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Casual Shirts',
                'slug' => 'casual-shirts',
                'description' => 'Effortlessly stylish casual shirts for everyday wear. Comfortable fabrics meet contemporary designs for a relaxed yet refined look.',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=800&q=80',
                'sort_order' => 2,
            ],
            [
                'name' => 'Party Wear',
                'slug' => 'party-wear',
                'description' => 'Make a statement at every event with our party wear collection. Bold designs and premium fabrics that ensure you stand out.',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80',
                'sort_order' => 3,
            ],
            [
                'name' => 'Denim Shirts',
                'slug' => 'denim-shirts',
                'description' => 'Timeless denim shirts that never go out of style. From light washes to deep indigo, find your perfect denim companion.',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80',
                'sort_order' => 4,
            ],
            [
                'name' => 'Printed Shirts',
                'slug' => 'printed-shirts',
                'description' => 'Express your personality with our range of printed shirts. From subtle patterns to bold graphics, there\'s something for everyone.',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=800&q=80',
                'sort_order' => 5,
            ],
            [
                'name' => 'Linen Shirts',
                'slug' => 'linen-shirts',
                'description' => 'Stay cool and sophisticated with our linen shirt collection. Perfect for warm weather and resort-style dressing.',
                'image' => 'https://images.unsplash.com/photo-1621072156002-e2fccdc0b176?w=800&q=80',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
