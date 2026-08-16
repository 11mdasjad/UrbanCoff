<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $colors = ['White', 'Black', 'Blue', 'Navy', 'Grey', 'Green', 'Beige', 'Brown'];

        $products = [
            // ── Formal Shirts ───────────────────────────────
            [
                'category' => 'formal-shirts',
                'name' => 'Classic White Oxford Shirt',
                'description' => 'A timeless white Oxford shirt crafted from premium 100% Egyptian cotton. Features a button-down collar, single-needle stitching, and a tailored fit that transitions seamlessly from the boardroom to evening events. The fabric has a subtle texture that adds depth and character to any outfit.',
                'short_description' => 'Premium Egyptian cotton Oxford with tailored fit',
                'price' => 89.99,
                'sale_price' => null,
                'sku' => 'FRM-OXF-WHT-001',
                'brand' => 'ShirtStore Originals',
                'material' => '100% Egyptian Cotton',
                'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=800&q=80',
                'featured' => true,
                'colors' => ['White', 'Blue', 'Grey'],
            ],
            [
                'category' => 'formal-shirts',
                'name' => 'Navy Pinstripe Dress Shirt',
                'description' => 'Sophisticated navy dress shirt with subtle pinstripe detailing. Made from Italian-milled cotton with a spread collar and French cuff option. Perfect for making a lasting impression at business meetings and formal dinners.',
                'short_description' => 'Italian cotton dress shirt with subtle pinstripes',
                'price' => 119.99,
                'sale_price' => 99.99,
                'sku' => 'FRM-PIN-NVY-002',
                'brand' => 'ShirtStore Premium',
                'material' => '100% Italian Cotton',
                'image' => 'https://images.unsplash.com/photo-1620012253295-c15cc3e65df4?w=800&q=80',
                'featured' => true,
                'colors' => ['Navy', 'Black', 'White'],
            ],
            [
                'category' => 'formal-shirts',
                'name' => 'Light Blue Slim Fit Shirt',
                'description' => 'A modern slim-fit light blue shirt that brings fresh energy to your formal wardrobe. Crafted from wrinkle-resistant cotton blend with a semi-spread collar and adjustable cuffs. The slightly stretchy fabric ensures comfort throughout your busiest days.',
                'short_description' => 'Wrinkle-resistant slim fit for the modern professional',
                'price' => 79.99,
                'sale_price' => null,
                'sku' => 'FRM-SLM-BLU-003',
                'brand' => 'ShirtStore Originals',
                'material' => '97% Cotton, 3% Elastane',
                'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736c10?w=800&q=80',
                'featured' => false,
                'colors' => ['Blue', 'White', 'Grey'],
            ],
            [
                'category' => 'formal-shirts',
                'name' => 'Charcoal Executive Shirt',
                'description' => 'Command authority with this charcoal executive shirt. Features a structured collar, double-button barrel cuffs, and a luxury twill weave that catches the light beautifully. Designed for leaders who demand the best.',
                'short_description' => 'Luxury twill weave executive shirt',
                'price' => 129.99,
                'sale_price' => 109.99,
                'sku' => 'FRM-EXC-CHR-004',
                'brand' => 'ShirtStore Premium',
                'material' => '100% Supima Cotton',
                'image' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?w=800&q=80',
                'featured' => false,
                'colors' => ['Grey', 'Black', 'Navy'],
            ],

            // ── Casual Shirts ───────────────────────────────
            [
                'category' => 'casual-shirts',
                'name' => 'Weekend Flannel Check Shirt',
                'description' => 'Your perfect weekend companion. This soft brushed flannel shirt features a classic check pattern in warm earth tones. Relaxed fit with a straight hem that can be worn tucked or untucked. Double chest pockets add a rugged touch.',
                'short_description' => 'Soft brushed flannel with classic check pattern',
                'price' => 69.99,
                'sale_price' => 54.99,
                'sku' => 'CAS-FLN-BRN-005',
                'brand' => 'ShirtStore Casual',
                'material' => '100% Brushed Cotton',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=800&q=80',
                'featured' => true,
                'colors' => ['Brown', 'Green', 'Navy'],
            ],
            [
                'category' => 'casual-shirts',
                'name' => 'Cotton Poplin Camp Shirt',
                'description' => 'Channel retro-cool vibes with this camp collar shirt in crisp cotton poplin. The relaxed boxy fit and open collar create an effortlessly stylish silhouette. Perfect for brunch dates and coastal weekends.',
                'short_description' => 'Retro camp collar in crisp cotton poplin',
                'price' => 59.99,
                'sale_price' => null,
                'sku' => 'CAS-CMP-BEI-006',
                'brand' => 'ShirtStore Casual',
                'material' => '100% Cotton Poplin',
                'image' => 'https://images.unsplash.com/photo-1589310243389-96a5483213a8?w=800&q=80',
                'featured' => true,
                'colors' => ['Beige', 'White', 'Blue'],
            ],
            [
                'category' => 'casual-shirts',
                'name' => 'Henley Neck Casual Shirt',
                'description' => 'A modern take on the classic henley. This casual shirt features a three-button placket, rolled-up sleeve tabs, and a relaxed fit. The garment-washed fabric has a soft, lived-in feel from the first wear.',
                'short_description' => 'Modern henley with garment-washed finish',
                'price' => 49.99,
                'sale_price' => null,
                'sku' => 'CAS-HNL-GRN-007',
                'brand' => 'ShirtStore Casual',
                'material' => '100% Cotton Jersey',
                'image' => 'https://images.unsplash.com/photo-1618517351616-38fb9c5210c6?w=800&q=80',
                'featured' => false,
                'colors' => ['Green', 'Grey', 'Black'],
            ],

            // ── Party Wear ──────────────────────────────────
            [
                'category' => 'party-wear',
                'name' => 'Midnight Satin Shirt',
                'description' => 'Turn heads in this lustrous satin shirt with a subtle sheen that catches every light. Features a slim silhouette, concealed button placket, and mandarin collar. The premium satin weave drapes beautifully for a sophisticated evening look.',
                'short_description' => 'Lustrous satin with mandarin collar',
                'price' => 139.99,
                'sale_price' => 119.99,
                'sku' => 'PTY-STN-BLK-008',
                'brand' => 'ShirtStore Luxe',
                'material' => '100% Silk-Blend Satin',
                'image' => 'https://images.unsplash.com/photo-1621072156002-e2fccdc0b176?w=800&q=80',
                'featured' => true,
                'colors' => ['Black', 'Navy', 'White'],
            ],
            [
                'category' => 'party-wear',
                'name' => 'Velvet Touch Evening Shirt',
                'description' => 'Make every entrance memorable with this velvet-touch evening shirt. The rich texture and deep color create a luxurious statement piece. Features a point collar, single cuffs, and a tailored fit that flatters every frame.',
                'short_description' => 'Rich velvet-touch fabric for memorable evenings',
                'price' => 159.99,
                'sale_price' => null,
                'sku' => 'PTY-VLV-NVY-009',
                'brand' => 'ShirtStore Luxe',
                'material' => 'Velvet-Touch Blend',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80',
                'featured' => false,
                'colors' => ['Navy', 'Black', 'Green'],
            ],
            [
                'category' => 'party-wear',
                'name' => 'Embroidered Celebration Shirt',
                'description' => 'Celebrate in style with this intricately embroidered shirt. Delicate tone-on-tone embroidery covers the front panel, creating a textured masterpiece. Ideal for weddings, galas, and festive occasions.',
                'short_description' => 'Intricate tone-on-tone embroidery for celebrations',
                'price' => 179.99,
                'sale_price' => 149.99,
                'sku' => 'PTY-EMB-WHT-010',
                'brand' => 'ShirtStore Luxe',
                'material' => '100% Premium Cotton',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80',
                'featured' => true,
                'colors' => ['White', 'Beige', 'Black'],
            ],

            // ── Denim Shirts ────────────────────────────────
            [
                'category' => 'denim-shirts',
                'name' => 'Classic Indigo Denim Shirt',
                'description' => 'The ultimate denim essential. This classic indigo shirt is crafted from premium selvedge denim that develops beautiful character with every wear. Features western-inspired snap buttons and a slightly tailored fit.',
                'short_description' => 'Premium selvedge denim with snap buttons',
                'price' => 99.99,
                'sale_price' => null,
                'sku' => 'DNM-CLS-BLU-011',
                'brand' => 'ShirtStore Denim',
                'material' => '100% Selvedge Denim',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80',
                'featured' => true,
                'colors' => ['Blue', 'Navy'],
            ],
            [
                'category' => 'denim-shirts',
                'name' => 'Light Wash Denim Shirt',
                'description' => 'A summer-ready light wash denim shirt with a relaxed, lived-in aesthetic. The soft, broken-in denim provides exceptional comfort while maintaining a sharp, put-together look. Pair with chinos or layer over a tee.',
                'short_description' => 'Summer-ready light wash with lived-in feel',
                'price' => 89.99,
                'sale_price' => 74.99,
                'sku' => 'DNM-LTW-BLU-012',
                'brand' => 'ShirtStore Denim',
                'material' => '98% Cotton, 2% Elastane Denim',
                'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=800&q=80',
                'featured' => false,
                'colors' => ['Blue', 'Grey'],
            ],
            [
                'category' => 'denim-shirts',
                'name' => 'Black Denim Western Shirt',
                'description' => 'A bold black denim shirt with western-inspired detailing. Features pointed yoke, pearl snap buttons, and slightly curved hem. This shirt bridges the gap between rugged and refined.',
                'short_description' => 'Bold western-inspired black denim',
                'price' => 109.99,
                'sale_price' => null,
                'sku' => 'DNM-WST-BLK-013',
                'brand' => 'ShirtStore Denim',
                'material' => '100% Black Denim',
                'image' => 'https://images.unsplash.com/photo-1620012253295-c15cc3e65df4?w=800&q=80',
                'featured' => false,
                'colors' => ['Black'],
            ],

            // ── Printed Shirts ──────────────────────────────
            [
                'category' => 'printed-shirts',
                'name' => 'Tropical Palm Print Shirt',
                'description' => 'Bring vacation energy to any occasion with this vibrant tropical palm print. Made from lightweight cotton voile for breathability, featuring a camp collar and relaxed fit. The all-over print is perfectly scaled for a stylish, not overwhelming, look.',
                'short_description' => 'Lightweight cotton voile with tropical palms',
                'price' => 74.99,
                'sale_price' => 59.99,
                'sku' => 'PRT-TRP-GRN-014',
                'brand' => 'ShirtStore Prints',
                'material' => '100% Cotton Voile',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=800&q=80',
                'featured' => true,
                'colors' => ['Green', 'Blue', 'Beige'],
            ],
            [
                'category' => 'printed-shirts',
                'name' => 'Geometric Abstract Shirt',
                'description' => 'A contemporary geometric print shirt for the design-conscious dresser. Abstract shapes in complementary tones create an eye-catching yet sophisticated pattern. Slim fit cut from premium cotton sateen.',
                'short_description' => 'Contemporary geometric print in cotton sateen',
                'price' => 84.99,
                'sale_price' => null,
                'sku' => 'PRT-GEO-NVY-015',
                'brand' => 'ShirtStore Prints',
                'material' => '100% Cotton Sateen',
                'image' => 'https://images.unsplash.com/photo-1589310243389-96a5483213a8?w=800&q=80',
                'featured' => false,
                'colors' => ['Navy', 'Grey', 'White'],
            ],
            [
                'category' => 'printed-shirts',
                'name' => 'Micro Floral Print Shirt',
                'description' => 'A delicate micro floral print that adds subtle personality to your outfit. The small-scale pattern works beautifully in both casual and smart-casual settings. Cotton-blend fabric with a touch of stretch for all-day comfort.',
                'short_description' => 'Delicate micro floral for versatile styling',
                'price' => 69.99,
                'sale_price' => null,
                'sku' => 'PRT-FLR-BLU-016',
                'brand' => 'ShirtStore Prints',
                'material' => '97% Cotton, 3% Elastane',
                'image' => 'https://images.unsplash.com/photo-1618517351616-38fb9c5210c6?w=800&q=80',
                'featured' => false,
                'colors' => ['Blue', 'White', 'Beige'],
            ],

            // ── Linen Shirts ────────────────────────────────
            [
                'category' => 'linen-shirts',
                'name' => 'Pure Linen Resort Shirt',
                'description' => 'The quintessential summer shirt. Crafted from 100% European linen, this resort shirt offers unparalleled breathability and a naturally relaxed drape. Features a band collar, chest pocket, and side slits for easy movement.',
                'short_description' => 'European linen with band collar for summer',
                'price' => 109.99,
                'sale_price' => 89.99,
                'sku' => 'LIN-RST-WHT-017',
                'brand' => 'ShirtStore Linen',
                'material' => '100% European Linen',
                'image' => 'https://images.unsplash.com/photo-1621072156002-e2fccdc0b176?w=800&q=80',
                'featured' => true,
                'colors' => ['White', 'Beige', 'Blue'],
            ],
            [
                'category' => 'linen-shirts',
                'name' => 'Linen-Cotton Blend Shirt',
                'description' => 'The best of both worlds — the breathability of linen and the softness of cotton. This blend shirt maintains the relaxed linen aesthetic while minimizing wrinkling. Regular fit with a classic collar and barrel cuffs.',
                'short_description' => 'Breathable linen-cotton blend, less wrinkling',
                'price' => 89.99,
                'sale_price' => null,
                'sku' => 'LIN-BLD-BEI-018',
                'brand' => 'ShirtStore Linen',
                'material' => '55% Linen, 45% Cotton',
                'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736c10?w=800&q=80',
                'featured' => false,
                'colors' => ['Beige', 'White', 'Green'],
            ],
            [
                'category' => 'linen-shirts',
                'name' => 'Washed Linen Weekend Shirt',
                'description' => 'Pre-washed for an incredibly soft hand feel from day one. This linen shirt has a relaxed, lived-in character that elevates casual dressing. The stone-wash process creates subtle color variations for added visual interest.',
                'short_description' => 'Pre-washed linen with lived-in character',
                'price' => 99.99,
                'sale_price' => 79.99,
                'sku' => 'LIN-WSH-GRY-019',
                'brand' => 'ShirtStore Linen',
                'material' => '100% Washed Linen',
                'image' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?w=800&q=80',
                'featured' => false,
                'colors' => ['Grey', 'Blue', 'Brown'],
            ],
            [
                'category' => 'casual-shirts',
                'name' => 'Brushed Twill Utility Shirt',
                'description' => 'A rugged yet refined utility shirt in brushed twill cotton. Features dual chest pockets with button flaps, reinforced elbows, and a straight hem. The heavyweight fabric is built to last while keeping you comfortable.',
                'short_description' => 'Heavy brushed twill with utility details',
                'price' => 79.99,
                'sale_price' => 64.99,
                'sku' => 'CAS-UTL-GRY-020',
                'brand' => 'ShirtStore Casual',
                'material' => '100% Brushed Twill Cotton',
                'image' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?w=800&q=80',
                'featured' => false,
                'colors' => ['Grey', 'Brown', 'Green'],
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category'])->first();
            $productColors = $productData['colors'];

            unset($productData['category'], $productData['colors']);

            $product = Product::create(array_merge($productData, [
                'category_id' => $category->id,
                'slug' => \Illuminate\Support\Str::slug($productData['name']),
                'status' => true,
            ]));

            // Create variants for each size/color combination
            foreach ($productColors as $color) {
                foreach ($sizes as $size) {
                    // Vary stock based on size popularity
                    $stock = match ($size) {
                        'M', 'L' => rand(15, 30),
                        'S', 'XL' => rand(8, 20),
                        'XS', 'XXL' => rand(3, 10),
                    };

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'color' => $color,
                        'stock' => $stock,
                    ]);
                }
            }
        }
    }
}
