<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\SettingTranslation;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        activity()->withoutLogs(function () {

            $settings = [
                [
                    'name' => 'logo',
                    'slug' => 'logo',
                    'content' => 'http://shop.globalsoft.az/frontend/img/logo.png'
                ],
                [
                    'name' => 'location',
                    'slug' => 'location',
                    'content' => 'Ünvan: Şərifzadə küç.19, Bakı, Azərbaycan, AZ1138'
                ],
                [
                    'name' => 'phone',
                    'slug' => 'phone',
                    'content' => '(+994 51) 804 04 08'
                ],
                [
                    'name' => 'email',
                    'slug' => 'email',
                    'content' => 'info@pressklub.az'
                ],
                [
                    'name' => 'instagram',
                    'slug' => 'location',
                    'content' => 'https://www.instagram.com/'
                ],
                [
                    'name' => 'facebook',
                    'slug' => 'facebook',
                    'content' => 'https://www.facebook.com/'
                ],
                [
                    'name' => 'linkedin',
                    'slug' => 'linkedin',
                    'content' => 'https://www.linkedin.com/'
                ],
                [
                    'name' => 'twitter',
                    'slug' => 'twitter',
                    'content' => 'https://twitter.com/'
                ]
            ];

            foreach ($settings as $item) {
                $setting = Setting::create(['name' => $item['name'],'slug' => $item['slug']]);

                SettingTranslation::create(
                    [
                        'setting_id' => $setting->id,
                        'content' => $item['content'],
                        'locale' => 'az'
                    ]);

                SettingTranslation::create(
                    [
                        'setting_id' => $setting->id,
                        'content' => $item['content'],
                        'locale' => 'en'
                    ]);

                SettingTranslation::create(
                    [
                        'setting_id' => $setting->id,
                        'content' => $item['content'],
                        'locale' => 'ru'
                    ]);
            }
        });

    }
}
