<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'VERONICA10',
                'type' => 'percentage',
                'value' => 10,
                'min_order' => 0,
                'usage_limit' => 100,
            ],
            [
                'code' => 'SALE20',
                'type' => 'percentage',
                'value' => 20,
                'min_order' => 50,
                'usage_limit' => 50,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(
                ['code' => $coupon['code']],
                $coupon
            );
        }
    }
}
