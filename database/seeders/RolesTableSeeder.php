<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'panel_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:46',
                'updated_at' => '2023-12-14 11:05:46',
            ),
        ));
        
        
    }
}