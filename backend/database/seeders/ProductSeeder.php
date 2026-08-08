<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Floral Summer Dress',
                'slug' => 'floral-summer-dress',
                'price' => 49.99,
                'original_price' => 69.99,
                'discount' => 28.57,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=400',
                'images' => ['https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'badge' => 'Sale',
                'category' => 'Dresses',
                'description' => 'Beautiful floral pattern summer dress perfect for warm weather.',
            ],
            [
                'name' => 'Classic White T-Shirt',
                'slug' => 'classic-white-t-shirt',
                'price' => 19.99,
                'original_price' => null,
                'discount' => 0,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                'images' => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'badge' => null,
                'category' => 'Tops',
                'description' => 'Essential white t-shirt made from 100% organic cotton.',
            ],
            [
                'name' => 'Slim Fit Jeans',
                'slug' => 'slim-fit-jeans',
                'price' => 59.99,
                'original_price' => 79.99,
                'discount' => 25,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400',
                'images' => ['https://images.unsplash.com/photo-1542272604-787c3835535d?w=800'],
                'sizes' => ['28', '30', '32', '34', '36'],
                'badge' => 'Sale',
                'category' => 'Bottoms',
                'description' => 'Modern slim fit jeans with stretch for comfort.',
            ],
            [
                'name' => 'Leather Crossbody Bag',
                'slug' => 'leather-crossbody-bag',
                'price' => 39.99,
                'original_price' => null,
                'discount' => 0,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=400',
                'images' => ['https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800'],
                'sizes' => null,
                'badge' => 'New',
                'category' => 'Accessories',
                'description' => 'Genuine leather crossbody bag with adjustable strap.',
            ],
            [
                'name' => 'Elegant Evening Gown',
                'slug' => 'elegant-evening-gown',
                'price' => 129.99,
                'original_price' => 179.99,
                'discount' => 27.78,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=400',
                'images' => ['https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'badge' => 'Sale',
                'category' => 'Dresses',
                'description' => 'Stunning evening gown for special occasions.',
            ],
            [
                'name' => 'Casual Linen Shirt',
                'slug' => 'casual-linen-shirt',
                'price' => 34.99,
                'original_price' => null,
                'discount' => 0,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400',
                'images' => ['https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=800'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'badge' => 'New',
                'category' => 'Tops',
                'description' => 'Breathable linen shirt for a relaxed summer look.',
            ],
            [
                'name' => 'High-Waist Palazzo Pants',
                'slug' => 'high-waist-palazzo-pants',
                'price' => 54.99,
                'original_price' => 69.99,
                'discount' => 21.43,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=400',
                'images' => ['https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=800'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'badge' => 'Sale',
                'category' => 'Bottoms',
                'description' => 'Flowy palazzo pants with flattering high waist.',
            ],
            [
                'name' => 'Gold Chain Necklace',
                'slug' => 'gold-chain-necklace',
                'price' => 24.99,
                'original_price' => null,
                'discount' => 0,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400',
                'images' => ['https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=800'],
                'sizes' => null,
                'badge' => null,
                'category' => 'Accessories',
                'description' => 'Elegant gold-plated chain necklace.',
            ],
            [
                'name' => 'Winter Wool Coat',
                'slug' => 'winter-wool-coat',
                'price' => 149.99,
                'original_price' => 199.99,
                'discount' => 25,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1539533113208-f6df8cc8b543?w=400',
                'images' => ['https://images.unsplash.com/photo-1539533113208-f6df8cc8b543?w=800'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'badge' => 'Sale',
                'category' => 'Outerwear',
                'description' => 'Premium wool blend coat for cold weather.',
            ],
            [
                'name' => 'Strappy Heeled Sandals',
                'slug' => 'strappy-heeled-sandals',
                'price' => 64.99,
                'original_price' => 84.99,
                'discount' => 23.53,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=400',
                'images' => ['https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800'],
                'sizes' => ['36', '37', '38', '39', '40'],
                'badge' => 'Sale',
                'category' => 'Shoes',
                'description' => 'Chic strappy sandals with comfortable heel.',
            ],
            [
                'name' => 'Oversized Knit Sweater',
                'slug' => 'oversized-knit-sweater',
                'price' => 44.99,
                'original_price' => null,
                'discount' => 0,
                'stock' => 28,
                'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400',
                'images' => ['https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800'],
                'sizes' => ['S', 'M', 'L'],
                'badge' => 'New',
                'category' => 'Tops',
                'description' => 'Cozy oversized sweater perfect for layering.',
            ],
            [
                'name' => 'Canvas Sneakers',
                'slug' => 'canvas-sneakers',
                'price' => 34.99,
                'original_price' => 44.99,
                'discount' => 22.22,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=400',
                'images' => ['https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800'],
                'sizes' => ['36', '37', '38', '39', '40', '41', '42'],
                'badge' => 'Sale',
                'category' => 'Shoes',
                'description' => 'Classic canvas sneakers for everyday wear.',
            ],
        ];

        $categories = Category::pluck('id', 'slug');

        foreach ($products as $data) {
            $categorySlug = $data['category'];
            unset($data['category']);

            Product::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'uuid' => Str::uuid(),
                    'category_id' => $categories[$categorySlug] ?? null,
                ])
            );
        }
    }
}
