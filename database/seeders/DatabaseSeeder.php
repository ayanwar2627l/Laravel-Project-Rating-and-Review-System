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
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Regular users
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

        // Categories
        $categories = [
            ['name' => 'Electronics',      'slug' => 'electronics',    'description' => 'Gadgets, phones, laptops and more'],
            ['name' => 'Fashion',          'slug' => 'fashion',        'description' => 'Clothing, footwear and accessories'],
            ['name' => 'Home & Kitchen',   'slug' => 'home-kitchen',   'description' => 'Furniture, appliances and decor'],
            ['name' => 'Books',            'slug' => 'books',          'description' => 'Bestsellers, textbooks and fiction'],
            ['name' => 'Sports & Outdoors','slug' => 'sports-outdoors','description' => 'Fitness equipment and outdoor gear'],
            ['name' => 'Beauty & Health',  'slug' => 'beauty-health',  'description' => 'Skincare, wellness and grooming'],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
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
                ['category_id' => $catModels[0]->id, 'name' => 'Samsung Galaxy S24 Ultra',    'price' => 129999, 'stock' => 45,  'description' => 'The ultimate Android flagship with a built-in S Pen, 200MP camera, AI-enhanced photography, and a stunning 6.8-inch Dynamic AMOLED 2X display. Experience desktop-class performance in your pocket.'],
                ['category_id' => $catModels[0]->id, 'name' => 'Sony WH-1000XM5 Headphones',  'price' => 29990,  'stock' => 80,  'description' => 'Industry-leading noise cancelling headphones with 30-hour battery life, crystal clear hands-free calling, and Alexa/Google Assistant built-in. The quietest listening experience ever.'],
                ['category_id' => $catModels[0]->id, 'name' => 'Apple MacBook Air M3',         'price' => 114900, 'stock' => 30,  'description' => 'Supercharged by the Apple M3 chip. Incredibly thin and light with an 18-hour battery, 15.3-inch Liquid Retina display, and up to 24GB unified memory. Work anywhere, all day.'],
                ['category_id' => $catModels[0]->id, 'name' => 'Logitech MX Master 3S Mouse',  'price' => 8995,   'stock' => 120, 'description' => 'The master of productivity. Ultra-fast scrolling, ergonomic design, 8K DPI precision, works on any surface including glass, and connects to up to 3 devices seamlessly.'],
                // Fashion
                ['category_id' => $catModels[1]->id, 'name' => 'Nike Air Max 270',             'price' => 11995,  'stock' => 60,  'description' => 'The first lifestyle Air Max shoe featuring Nike\'s largest heel Air unit yet for incredible cushioning. Lightweight mesh upper and foam midsole ensure all-day comfort.'],
                ['category_id' => $catModels[1]->id, 'name' => 'Levi\'s 511 Slim Fit Jeans',   'price' => 3499,   'stock' => 150, 'description' => 'The Levi\'s 511 sits below the waist and is slim through the thigh and leg. Classic 5-pocket styling in premium denim.'],
                ['category_id' => $catModels[1]->id, 'name' => 'Ray-Ban Classic Aviator',      'price' => 8990,   'stock' => 75,  'description' => 'Iconic Aviator sunglasses with polarised crystal glass lenses offering the purest vision. Timeless metal frame in gold with green classic G-15 lenses. UV400 protection.'],
                // Home & Kitchen
                ['category_id' => $catModels[2]->id, 'name' => 'Philips Air Fryer HD9200',     'price' => 7995,   'stock' => 55,  'description' => 'Fry, bake, grill and roast with up to 90% less fat. The Philips Rapid Air technology circulates hot air to fry with little to no oil. Perfect crispy results every time.'],
                ['category_id' => $catModels[2]->id, 'name' => 'Instant Pot Duo 7-in-1',       'price' => 9999,   'stock' => 40,  'description' => 'Replace 7 kitchen appliances in one: pressure cooker, slow cooker, rice cooker, steamer, sauté, yogurt maker, and warmer. Cooks 2–6x faster than traditional methods.'],
                ['category_id' => $catModels[2]->id, 'name' => 'IKEA KALLAX Shelf Unit',        'price' => 12990,  'stock' => 25,  'description' => 'A favourite with many people since it is easy to adapt with inserts and boxes. Perfect as a TV bench, bookshelf or room divider.'],
                // Books
                ['category_id' => $catModels[3]->id, 'name' => 'Atomic Habits by James Clear', 'price' => 499,    'stock' => 200, 'description' => 'An easy and proven way to build good habits and break bad ones. Learn practical strategies that will teach you exactly how to form good habits and break bad ones.'],
                ['category_id' => $catModels[3]->id, 'name' => 'The Alchemist by Paulo Coelho','price' => 299,    'stock' => 180, 'description' => 'A philosophical novel that follows Santiago, a shepherd boy who travels from Spain to Egypt in search of a worldly treasure. A timeless masterpiece.'],
                // Sports
                ['category_id' => $catModels[4]->id, 'name' => 'Decathlon Kiprun Shoes',       'price' => 4499,   'stock' => 90,  'description' => 'Designed for recreational runners, the Kiprun features optimal cushioning and a rocker system that promotes natural forward motion. Ideal for road running.'],
                ['category_id' => $catModels[4]->id, 'name' => 'Yoga Mat Premium 6mm',         'price' => 1299,   'stock' => 200, 'description' => 'Extra thick 6mm eco-friendly TPE yoga mat with non-slip texture on both sides. Includes carrying strap. Perfect for yoga, pilates and meditation.'],
                // Beauty
                ['category_id' => $catModels[5]->id, 'name' => 'The Ordinary Niacinamide 10%', 'price' => 599,    'stock' => 300, 'description' => 'A high-strength vitamin and mineral blemish formula. Niacinamide (Vitamin B3) reduces blemishes and pore appearance while balancing visible sebum activity.'],
                ['category_id' => $catModels[5]->id, 'name' => 'Forest Essentials Face Cleanser','price' => 1850, 'stock' => 85,  'description' => 'Ayurvedic brightening face wash with pure Sugarcane Juice and Honey. Deeply cleanses while maintaining the skin\'s natural moisture balance.'],
            ];

            foreach ($products as $p) {
                $p['slug']      = Str::slug($p['name']) . '-' . Str::random(4);
                $p['is_active'] = true;
                $productModels[] = Product::create($p);
            }
        } else {
            $productModels = Product::all()->all();
        }

        // Reviews — only seed if none exist yet
        if (Review::count() === 0 && count($productModels) > 0) {
            $reviewData = [
                [5, 'Game Changer!',             'This phone is absolutely brilliant. The camera is insane for night shots, and the S-Pen is so handy for quick notes. Battery lasts all day even with heavy use. Worth every rupee!'],
                [4, 'Almost Perfect',            'The camera and display are top-notch. Performance is blazing fast. Only wish the battery was slightly bigger. Still, my favourite phone in years.'],
                [5, 'Best noise cancelling',     'I travel a lot and these headphones have completely changed my commute. Noise cancellation is magical — can\'t hear anything on the metro. Sound quality is rich and detailed.'],
                [4, 'Great headphones',          'Very comfortable for long listening sessions. ANC is impressive. My only gripe is the touch controls take some getting used to. Audio quality is superb.'],
                [5, 'Incredible machine',        'The M3 chip is astonishingly fast. Opens everything instantly, the display is gorgeous, and 18-hour battery is no exaggeration. Lightest laptop I\'ve ever carried.'],
                [3, 'Good but pricey',           'MacBook quality is undeniable but the price is hard to justify. For the money I expected more ports. Performance is excellent though, very smooth for my design work.'],
                [5, 'Perfect mouse',             'Been using this for 3 months now and my productivity has shot up. The scroll wheel is satisfying, customisable buttons save so much time. Ergonomics are excellent.'],
                [5, 'Comfortable sneakers',      'Wore these to a theme park all day and my feet felt great. Cushioning is superb. Look stylish too. Sizing is accurate, order your usual size.'],
                [4, 'Stylish and durable',       'Great quality for the price. Leather looks premium and holds up well after months of wear. A little stiff at first but softens quickly. Classic look.'],
                [5, 'Air fryer changed my life', 'I use this every single day. Chips, chicken wings, fish — everything comes out perfect. So easy to clean. I\'ve lost weight just by switching from deep frying!'],
                [4, 'Excellent appliance',       'The Instant Pot is incredibly versatile. Made biryani, soups, and yogurt all in one week. Learning curve is small but the results are outstanding.'],
                [5, 'Must-read book',            'Atomic Habits has genuinely changed how I approach goals. Clear writing, actionable advice, real-world examples. I\'ve recommended it to everyone I know.'],
                [5, 'Timeless classic',          'Read this in one sitting. The story is simple yet profound. Every page feels like it holds a life lesson. A book I will re-read many times.'],
                [4, 'Great running shoes',       'Used these for my 5K training and they held up perfectly. Lightweight, good grip, and comfortable from the first run. Great value for money.'],
                [5, 'Best skincare product',     'My skin texture has visibly improved in just 3 weeks. Pores look smaller, skin is brighter, and the occasional breakouts have almost stopped. Must-have!'],
                [4, 'Gentle and effective',      'Love the luxurious feel of this cleanser. Skin feels clean but not stripped. The scent is heavenly. A bit pricey but the quality justifies it.'],
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

                if ($i % 3 === 0) {
                    $secondReview = $reviewData[($i + 3) % count($reviewData)];
                    Review::create([
                        'user_id'     => $users[($i + 1) % count($users)]->id,
                        'product_id'  => $productModels[$i]->id,
                        'rating'      => $secondReview[0],
                        'title'       => $secondReview[1],
                        'comment'     => $secondReview[2],
                        'is_verified' => false,
                        'is_approved' => true,
                    ]);
                }

                $productModels[$i]->recalculateRating();
            }
        }
    }
}
