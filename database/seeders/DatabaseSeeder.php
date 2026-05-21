<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User — skip if already exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Regular users — skip any that already exist
        $users = [];
        $userNames = ['Priya Sharma', 'Rahul Mehta', 'Anika Singh', 'Vikram Patel', 'Sneha Joshi', 'Arjun Nair'];
        foreach ($userNames as $name) {
            $users[] = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@example.com'],
                [
                    'name'     => $name,
                    'password' => Hash::make('password'),
                    'is_admin' => false,
                ]
            );
        }

        // Categories — skip any that already exist
        $categoryData = [
            ['name' => 'Electronics',       'slug' => 'electronics',     'description' => 'Gadgets, phones, laptops and more'],
            ['name' => 'Fashion',           'slug' => 'fashion',         'description' => 'Clothing, footwear and accessories'],
            ['name' => 'Home & Kitchen',    'slug' => 'home-kitchen',    'description' => 'Furniture, appliances and decor'],
            ['name' => 'Books',             'slug' => 'books',           'description' => 'Bestsellers, textbooks and fiction'],
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors', 'description' => 'Fitness equipment and outdoor gear'],
            ['name' => 'Beauty & Health',   'slug' => 'beauty-health',   'description' => 'Skincare, wellness and grooming'],
        ];

        $catModels = [];
        foreach ($categoryData as $cat) {
            $catModels[] = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'description' => $cat['description']]
            );
        }

        // Products — only create if none exist yet
        $productModels = [];
        if (Product::count() === 0) {
            $products = [
                // Electronics
                ['category_id' => $catModels[0]->id, 'name' => 'Samsung Galaxy S24 Ultra',   'price' => 129999, 'stock' => 45,  'description' => 'The ultimate Android flagship with a built-in S Pen, 200MP camera, AI-enhanced photography, and a stunning 6.8-inch Dynamic AMOLED 2X display.'],
                ['category_id' => $catModels[0]->id, 'name' => 'Sony WH-1000XM5 Headphones', 'price' => 29990,  'stock' => 80,  'description' => 'Industry-leading noise cancelling headphones with 30-hour battery life, crystal clear hands-free calling, and Alexa/Google Assistant built-in.'],
                ['category_id' => $catModels[0]->id, 'name' => 'Apple MacBook Air M3',        'price' => 114900, 'stock' => 30,  'description' => 'Supercharged by the Apple M3 chip. Incredibly thin and light with an 18-hour battery, 15.3-inch Liquid Retina display, and up to 24GB unified memory.'],
                ['category_id' => $catModels[0]->id, 'name' => 'Logitech MX Master 3S Mouse', 'price' => 8995,   'stock' => 120, 'description' => 'The master of productivity. Ultra-fast scrolling, ergonomic design, 8K DPI precision, works on any surface including glass, connects to 3 devices.'],
                // Fashion
                ['category_id' => $catModels[1]->id, 'name' => 'Nike Air Max 270',            'price' => 11995,  'stock' => 60,  'description' => 'The first lifestyle Air Max shoe featuring Nike\'s largest heel Air unit yet for incredible all-day cushioning. Lightweight mesh upper.'],
                ['category_id' => $catModels[1]->id, 'name' => 'Levi\'s 511 Slim Fit Jeans',  'price' => 3499,   'stock' => 150, 'description' => 'The Levi\'s 511 sits below the waist and is slim through the thigh and leg. Classic 5-pocket styling in premium denim.'],
                ['category_id' => $catModels[1]->id, 'name' => 'Ray-Ban Classic Aviator',     'price' => 8990,   'stock' => 75,  'description' => 'Iconic Aviator sunglasses with polarised crystal glass lenses. Timeless metal frame in gold with green classic G-15 lenses. UV400 protection.'],
                // Home & Kitchen
                ['category_id' => $catModels[2]->id, 'name' => 'Philips Air Fryer HD9200',    'price' => 7995,   'stock' => 55,  'description' => 'Fry, bake, grill and roast with up to 90% less fat using Rapid Air technology. Perfect crispy results every time with little to no oil.'],
                ['category_id' => $catModels[2]->id, 'name' => 'Instant Pot Duo 7-in-1',      'price' => 9999,   'stock' => 40,  'description' => 'Replace 7 kitchen appliances: pressure cooker, slow cooker, rice cooker, steamer, sauté pan, yogurt maker, and warmer.'],
                ['category_id' => $catModels[2]->id, 'name' => 'IKEA KALLAX Shelf Unit',       'price' => 12990,  'stock' => 25,  'description' => 'Easy to adapt with inserts and boxes. Perfect as a TV bench, bookshelf or room divider. Can be placed vertically or horizontally.'],
                // Books
                ['category_id' => $catModels[3]->id, 'name' => 'Atomic Habits by James Clear','price' => 499,    'stock' => 200, 'description' => 'An easy and proven way to build good habits and break bad ones. Practical strategies that teach you exactly how to form good habits.'],
                ['category_id' => $catModels[3]->id, 'name' => 'The Alchemist by Paulo Coelho','price' => 299,   'stock' => 180, 'description' => 'A philosophical novel following Santiago on a journey from Spain to Egypt. A timeless masterpiece of world literature.'],
                // Sports
                ['category_id' => $catModels[4]->id, 'name' => 'Decathlon Kiprun Shoes',      'price' => 4499,   'stock' => 90,  'description' => 'Designed for recreational runners with optimal cushioning and a rocker system that promotes natural forward motion on roads.'],
                ['category_id' => $catModels[4]->id, 'name' => 'Yoga Mat Premium 6mm',        'price' => 1299,   'stock' => 200, 'description' => 'Extra thick 6mm eco-friendly TPE yoga mat with non-slip texture on both sides. Includes carrying strap for yoga and pilates.'],
                // Beauty
                ['category_id' => $catModels[5]->id, 'name' => 'The Ordinary Niacinamide 10%','price' => 599,    'stock' => 300, 'description' => 'High-strength vitamin and mineral blemish formula. Reduces blemishes and pore appearance while balancing visible sebum activity.'],
                ['category_id' => $catModels[5]->id, 'name' => 'Forest Essentials Face Cleanser','price' => 1850,'stock' => 85,  'description' => 'Ayurvedic brightening face wash with Sugarcane Juice and Honey. Deeply cleanses while maintaining the skin\'s natural moisture balance.'],
            ];

            foreach ($products as $p) {
                $p['slug']      = Str::slug($p['name']) . '-' . Str::random(4);
                $p['is_active'] = true;
                $productModels[] = Product::create($p);
            }
        } else {
            $productModels = Product::all()->values()->all();
        }

        // Reviews — only seed if none exist yet
        if (Review::count() === 0 && count($productModels) > 0) {
            $reviewData = [
                [5, 'Game Changer!',              'This phone is absolutely brilliant. The camera is insane for night shots, and the S-Pen is so handy for quick notes. Battery lasts all day. Worth every rupee!'],
                [4, 'Almost Perfect',             'The camera and display are top-notch. Performance is blazing fast. Only wish the battery was slightly bigger. Still my favourite phone in years.'],
                [5, 'Best noise cancelling',      'I travel a lot and these headphones have completely changed my commute. Noise cancellation is magical. Sound quality is rich and detailed.'],
                [4, 'Great headphones',           'Very comfortable for long sessions. ANC is impressive. My only gripe is the touch controls take getting used to. Audio quality is superb.'],
                [5, 'Incredible machine',         'The M3 chip is astonishingly fast. Opens everything instantly, the display is gorgeous, and 18-hour battery is no exaggeration.'],
                [3, 'Good but pricey',            'MacBook quality is undeniable but the price is hard to justify. For the money I expected more ports. Performance is excellent though.'],
                [5, 'Perfect mouse',              'Been using this for 3 months and my productivity has shot up. The scroll wheel is satisfying, customisable buttons save so much time.'],
                [5, 'Comfortable sneakers',       'Wore these to a theme park all day and my feet felt great. Cushioning is superb. Look stylish too. Sizing is accurate.'],
                [4, 'Stylish and durable',        'Great quality for the price. Leather looks premium after months of wear. A little stiff at first but softens quickly.'],
                [5, 'Air fryer changed my life',  'I use this every single day. Chips, chicken wings, fish — everything comes out perfect. So easy to clean.'],
                [4, 'Excellent appliance',        'The Instant Pot is incredibly versatile. Made biryani, soups, and yogurt all in one week. Results are outstanding.'],
                [5, 'Must-read book',             'Atomic Habits has genuinely changed how I approach goals. Clear writing, actionable advice, real-world examples. Recommended to everyone.'],
                [5, 'Timeless classic',           'Read this in one sitting. The story is simple yet profound. Every page feels like it holds a life lesson.'],
                [4, 'Great running shoes',        'Used these for my 5K training and they held up perfectly. Lightweight, good grip, and comfortable from the first run.'],
                [5, 'Best skincare product',      'My skin texture has visibly improved in just 3 weeks. Pores look smaller, skin is brighter, and breakouts have almost stopped.'],
                [4, 'Gentle and effective',       'Love the luxurious feel of this cleanser. Skin feels clean but not stripped. The scent is heavenly. Quality justifies the price.'],
            ];

            for ($i = 0; $i < count($productModels) && $i < count($reviewData); $i++) {
                $rd = $reviewData[$i];
                Review::create([
                    'user_id'     => $users[array_rand($users)]->id,
                    'product_id'  => $productModels[$i]->id,
                    'rating'      => $rd[0],
                    'title'       => $rd[1],
                    'comment'     => $rd[2],
                    'is_verified' => (bool) rand(0, 1),
                    'is_approved' => true,
                ]);

                // Add a second review to some products
                if ($i % 3 === 0) {
                    $second = $reviewData[($i + 3) % count($reviewData)];
                    Review::create([
                        'user_id'     => $users[($i + 1) % count($users)]->id,
                        'product_id'  => $productModels[$i]->id,
                        'rating'      => $second[0],
                        'title'       => $second[1],
                        'comment'     => $second[2],
                        'is_verified' => false,
                        'is_approved' => true,
                    ]);
                }

                $productModels[$i]->recalculateRating();
            }
        }
    }
}
