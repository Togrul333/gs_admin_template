<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\News;
use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('faqs')->delete();
        $model = Faq::create([
            'id' => 1,
        ]);
        foreach (Cache::get('active_langs') as $lang) {
            $model->translations()->create([
                'locale' => $lang->code,
                'question' => 'Abunəlik nə üçündür?',
                'answer' => 'Təəssüflər olsun ki ödənişi geri qaytarmaq mümkün deyil. Əgər abunəliyinizi dayandırmaq istəyirsinizsə yenilənməyəcək və sizdən bir daha ödəniş tutulmayacaqdır',
            ]);
        }

        $model = Faq::create([
            'id' => 2,
        ]);
        foreach (Cache::get('active_langs') as $lang) {
            $model->translations()->create([
                'locale' => $lang->code,
                'question' => 'Paket nə üçündür?',
                'answer' => 'Təəssüflər olsun ki ödənişi geri qaytarmaq mümkün deyil. Əgər abunəliyinizi dayandırmaq istəyirsinizsə yenilənməyəcək və sizdən bir daha ödəniş tutulmayacaqdır',
            ]);
        }

        $model = Faq::create([
            'id' => 3,
        ]);
        foreach (Cache::get('active_langs') as $lang) {
            $model->translations()->create([
                'locale' => $lang->code,
                'question' => 'Əlave ödəniş nə üçündür?',
                'answer' => 'Təəssüflər olsun ki ödənişi geri qaytarmaq mümkün deyil.
                 Əgər abunəliyinizi dayandırmaq istəyirsinizsə yenilənməyəcək və sizdən bir daha ödəniş tutulmayacaqdır',
            ]);
        }
    }
}
