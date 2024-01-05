<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class   PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
//            0 =>
//            array (
//                'id' => 1,
//                'name' => 'admins index',
//                'guard_name' => 'admin',
//                'created_at' => '2022-02-07 05:37:45',
//                'updated_at' => '2022-02-07 05:37:45',
//            ),
//            1 =>
//            array (
//                'id' => 2,
//                'name' => 'admins create',
//                'guard_name' => 'admin',
//                'created_at' => '2022-02-07 05:37:45',
//                'updated_at' => '2022-02-07 05:37:45',
//            ),
//            2 =>
//            array (
//                'id' => 3,
//                'name' => 'admins edit',
//                'guard_name' => 'admin',
//                'created_at' => '2022-02-07 05:37:45',
//                'updated_at' => '2022-02-07 05:37:45',
//            ),
//            3 =>
//            array (
//                'id' => 4,
//                'name' => 'admins delete',
//                'guard_name' => 'admin',
//                'created_at' => '2022-02-07 05:37:45',
//                'updated_at' => '2022-02-07 05:37:45',
//            ),

//-----------------------------------------------------------------------------------------------


            4 =>
                array (
                    'id' => 5,
                    'name' => 'news index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'news create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'news edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'news delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),


//-----------------------------------------------------------------------------------------------


            8 =>
                array (
                    'id' => 9,
                    'name' => 'writers index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'writers create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'writers edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'writers delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),

//-----------------------------------------------------------------------------------------------



            12 =>
                array (
                    'id' => 13,
                    'name' => 'writings index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'writings create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'writings edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'writings delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),

//-----------------------------------------------------------------------------------------------


            16 =>
                array (
                    'id' => 17,
                    'name' => 'categories index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'categories create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'categories edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            19 =>
                array (
                    'id' => 20,
                    'name' => 'categories delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),

//-----------------------------------------------------------------------------------------------


            20 =>
                array (
                    'id' => 21,
                    'name' => 'packages index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            21 =>
                array (
                    'id' => 22,
                    'name' => 'packages create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            22 =>
                array (
                    'id' => 23,
                    'name' => 'packages edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            23 =>
                array (
                    'id' => 24,
                    'name' => 'packages delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
//-----------------------------------------------------------------------------------------------


            24 =>
                array (
                    'id' => 25,
                    'name' => 'faqs index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            25 =>
                array (
                    'id' => 26,
                    'name' => 'faqs create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            26 =>
                array (
                    'id' => 27,
                    'name' => 'faqs edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            27 =>
                array (
                    'id' => 28,
                    'name' => 'faqs delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
//-----------------------------------------------------------------------------------------------


            28 =>
                array (
                    'id' => 29,
                    'name' => 'settings index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            29 =>
                array (
                    'id' => 30,
                    'name' => 'settings create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            30 =>
                array (
                    'id' => 31,
                    'name' => 'settings edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            31 =>
                array (
                    'id' => 32,
                    'name' => 'settings delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),


//-----------------------------------------------------------------------------------------------


            32 =>
                array (
                    'id' => 33,
                    'name' => 'languages index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            33 =>
                array (
                    'id' => 34,
                    'name' => 'languages create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            34 =>
                array (
                    'id' => 35,
                    'name' => 'languages edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            35 =>
                array (
                    'id' => 36,
                    'name' => 'languages delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
//-----------------------------------------------------------------------------------------------


            36 =>
                array (
                    'id' => 37,
                    'name' => 'translations index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            37 =>
                array (
                    'id' => 38,
                    'name' => 'translations create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            38 =>
                array (
                    'id' => 39,
                    'name' => 'translations edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            39 =>
                array (
                    'id' => 40,
                    'name' => 'translations delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),



//-----------------------------------------------------------------------------------------------


            40 =>
                array (
                    'id' => 41,
                    'name' => 'contacts index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            42 =>
                array (
                    'id' => 43,
                    'name' => 'contacts create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            43 =>
                array (
                    'id' => 44,
                    'name' => 'contacts edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            44 =>
                array (
                    'id' => 45,
                    'name' => 'contacts delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),


//-----------------------------------------------------------------------------------------------


            45 =>
                array (
                    'id' => 46,
                    'name' => 'donations index',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            46 =>
                array (
                    'id' => 47,
                    'name' => 'donations create',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            47 =>
                array (
                    'id' => 48,
                    'name' => 'donations edit',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
            48 =>
                array (
                    'id' => 49,
                    'name' => 'donations delete',
                    'guard_name' => 'admin',
                    'created_at' => '2022-02-07 05:37:45',
                    'updated_at' => '2022-02-07 05:37:45',
                ),
        ));

        //admine butun icz=azeleri vermek ucun
        $permissions = Permission::all();
        $data = [];
        foreach ($permissions as $permission){
            $data[]=[ 'permission_id' => $permission->id, 'role_id' => 1];
        }
        \DB::table('role_has_permissions')->delete();

        \DB::table('role_has_permissions')->insert($data);


    }
}
