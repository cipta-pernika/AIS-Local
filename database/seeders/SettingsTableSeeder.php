<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group' => 'general',
                'name' => 'brand_name',
                'locked' => 0,
                'payload' => '"Aplikasi SOP BUNTUT KSOP Banjarmasin"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:44:33',
            ),
            1 => 
            array (
                'id' => 2,
                'group' => 'general',
                'name' => 'brand_logo',
                'locked' => 0,
                'payload' => '"sites/01J1EWV662SD4JAPP34W4G76EY.png"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:44:33',
            ),
            2 => 
            array (
                'id' => 3,
                'group' => 'general',
                'name' => 'brand_logoHeight',
                'locked' => 0,
                'payload' => '"3rem"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:44:33',
            ),
            3 => 
            array (
                'id' => 4,
                'group' => 'general',
                'name' => 'site_active',
                'locked' => 0,
                'payload' => 'true',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:44:33',
            ),
            4 => 
            array (
                'id' => 5,
                'group' => 'general',
                'name' => 'site_favicon',
                'locked' => 0,
                'payload' => '"sites/01J1EWV6677QXPZJMYCZA0YEDF.ico"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:44:33',
            ),
            5 => 
            array (
                'id' => 6,
                'group' => 'general',
                'name' => 'site_theme',
                'locked' => 0,
            'payload' => '{"gray": "rgb(107, 114, 128)", "info": "rgb(113, 12, 195)", "danger": "rgb(199, 29, 81)", "primary": "rgb(19, 83, 196)", "success": "rgb(12, 195, 178)", "warning": "rgb(255, 186, 93)", "secondary": "rgb(255, 137, 84)"}',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:44:33',
            ),
            6 => 
            array (
                'id' => 7,
                'group' => 'mail',
                'name' => 'from_address',
                'locked' => 0,
                'payload' => '"no-reply@starter-kit.com"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            7 => 
            array (
                'id' => 8,
                'group' => 'mail',
                'name' => 'from_name',
                'locked' => 0,
                'payload' => '"SuperDuper Starter Kit"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            8 => 
            array (
                'id' => 9,
                'group' => 'mail',
                'name' => 'driver',
                'locked' => 0,
                'payload' => '"smtp"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            9 => 
            array (
                'id' => 10,
                'group' => 'mail',
                'name' => 'host',
                'locked' => 0,
                'payload' => 'null',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            10 => 
            array (
                'id' => 11,
                'group' => 'mail',
                'name' => 'port',
                'locked' => 0,
                'payload' => '587',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            11 => 
            array (
                'id' => 12,
                'group' => 'mail',
                'name' => 'encryption',
                'locked' => 0,
                'payload' => '"tls"',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            12 => 
            array (
                'id' => 13,
                'group' => 'mail',
                'name' => 'username',
                'locked' => 0,
                'payload' => 'null',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            13 => 
            array (
                'id' => 14,
                'group' => 'mail',
                'name' => 'password',
                'locked' => 0,
                'payload' => 'null',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            14 => 
            array (
                'id' => 15,
                'group' => 'mail',
                'name' => 'timeout',
                'locked' => 0,
                'payload' => 'null',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
            15 => 
            array (
                'id' => 16,
                'group' => 'mail',
                'name' => 'local_domain',
                'locked' => 0,
                'payload' => 'null',
                'created_at' => '2024-06-28 07:18:57',
                'updated_at' => '2024-06-28 07:18:57',
            ),
        ));
        
        
    }
}