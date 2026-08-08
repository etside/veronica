<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'storeName', 'value' => 'Veronica', 'type' => 'string'],
            ['key' => 'currency', 'value' => 'USD', 'type' => 'string'],
            ['key' => 'currencySymbol', 'value' => '$', 'type' => 'string'],
            ['key' => 'shippingFreeThreshold', 'value' => '100', 'type' => 'number'],
            ['key' => 'shippingCost', 'value' => '9.99', 'type' => 'number'],
            ['key' => 'taxRate', 'value' => '0', 'type' => 'number'],
            ['key' => 'whatsapp', 'value' => '+1234567890', 'type' => 'string'],
            ['key' => 'email', 'value' => 'support@veronica.com', 'type' => 'string'],
            ['key' => 'announcementText', 'value' => 'Free shipping on orders over $100!', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
