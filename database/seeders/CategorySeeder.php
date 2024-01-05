<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('categories')->delete();

        $categories = [
            [
                'id' => 1,
                'name' => 'Xəbər',
                'code' => 'news',
                'slug' => 'xəbər',
                'status' => '1',
                'created_at' => '2022-04-15 12:08:18',
                'updated_at' => '2022-11-13 13:09:42',
            ],
            [
                'id' => 2,
                'name' => 'Analitika',
                'code' => 'analytics',
                'slug' => 'analitika',
                'status' => '1',
                'created_at' => '2022-04-15 12:08:18',
                'updated_at' => '2022-04-15 12:08:18',
            ],
            [
                'id' => 4,
                'name' => 'Reportaj',
                'code' => 'report',
                'slug' => 'reportaj',
                'status' => '1',
                'created_at' => '2022-04-15 12:08:18',
                'updated_at' => '2022-11-13 13:17:57',
            ],
            [
                'id' => 5,
                'name' => 'Araşdırma',
                'code' => 'research',
                'slug' => 'araşdırma',
                'status' => '1',
                'created_at' => '2022-04-15 12:08:18',
                'updated_at' => '2022-11-13 13:22:23',
            ],
            [
                'id' => 6,
                'name' => 'Müsahibə',
                'code' => 'interview',
                'slug' => 'müsahibə',
                'status' => '1',
                'created_at' => '2022-04-15 12:08:18',
                'updated_at' => '2022-11-13 13:09:42',
            ],
            [
                'id' => 7,
                'name' => 'İcmal',
                'code' => 'overview',
                'slug' => 'icmal',
                'status' => '1',
                'created_at' => '2022-04-15 12:08:18',
                'updated_at' => '2022-11-13 13:09:42',
            ]
        ];

        foreach ($categories as $category) {
            $cat = Category::create([
                'id' => $category['id'],
                'code' => $category['code'],
                'slug' => $category['slug'],
                'status' => $category['status']
            ]);

            CategoryTranslation::create(
                [
                    'category_id' => $cat->id,
                    'name' => $category['name'],
                    'description' => $category['name'],
                    'meta_title' => $category['name'],
                    'meta_description' => $category['name'],
                    'meta_keywords' => $category['name'],
                    'locale' => 'az'
                ]);

            CategoryTranslation::create(
                [
                    'category_id' => $cat->id,
                    'name' => $category['name'],
                    'description' => $category['name'],
                    'meta_title' => $category['name'],
                    'meta_description' => $category['name'],
                    'meta_keywords' => $category['name'],
                    'locale' => 'en'
                ]);

            CategoryTranslation::create(
                [
                    'category_id' => $cat->id,
                    'name' => $category['name'],
                    'description' => $category['name'],
                    'meta_title' => $category['name'],
                    'meta_description' => $category['name'],
                    'meta_keywords' => $category['name'],
                    'locale' => 'ru'
                ]);
        }
    }
}
