<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('languages')->delete();

        \DB::table('languages')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Azerbaijan',
                'code' => 'az',
                'default' => 1,
                'status' => 1,
                'created_at' => '2022-04-12 20:10:16',
                'updated_at' => '2022-04-12 20:10:16',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'English',
                'code' => 'en',
                'default' => 0,
                'status' => 1,
                'created_at' => '2022-04-12 20:10:16',
                'updated_at' => '2022-04-12 20:39:01',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Русский',
                'code' => 'ru',
                'default' => 0,
                'status' => 1,
                'created_at' => '2022-04-12 20:38:46',
                'updated_at' => '2022-04-12 20:39:06',
            ),
        ));


    }
}
