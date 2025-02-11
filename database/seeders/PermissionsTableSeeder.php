<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
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
            0 => 
            array (
                'id' => 1,
                'name' => 'view_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'view_any_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'create_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'update_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'restore_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'restore_any_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'replicate_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'reorder_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'delete_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'delete_any_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'force_delete_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'force_delete_any_activity',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'view_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'view_any_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'create_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'update_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'restore_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'restore_any_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'replicate_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'reorder_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'delete_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'delete_any_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'force_delete_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'force_delete_any_adsb::data::aircraft',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'view_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'view_any_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'create_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'update_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'restore_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'restore_any_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'replicate_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'reorder_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'delete_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'delete_any_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'force_delete_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'force_delete_any_adsb::data::flight',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'view_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'view_any_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'create_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'update_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'restore_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'restore_any_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'replicate_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'reorder_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'delete_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'delete_any_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'force_delete_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'force_delete_any_adsb::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'view_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'view_any_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'create_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'update_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'restore_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'restore_any_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'replicate_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'reorder_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'delete_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'delete_any_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'force_delete_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'force_delete_any_ais::data::position',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:41',
                'updated_at' => '2023-12-14 11:05:41',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'view_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'view_any_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'create_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'update_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'delete_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'delete_any_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'publish_ais::data::vessel',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'view_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'view_any_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'create_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'update_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'restore_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'restore_any_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'replicate_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'reorder_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'delete_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'delete_any_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'force_delete_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'force_delete_any_data::transfer::log',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'view_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'view_any_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'create_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'update_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'restore_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'restore_any_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'replicate_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'reorder_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'delete_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'delete_any_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'force_delete_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'force_delete_any_datalogger',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'view_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'view_any_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'create_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'update_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'restore_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'restore_any_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'replicate_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'reorder_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'delete_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'delete_any_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'force_delete_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'force_delete_any_event',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'view_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'view_any_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'create_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'update_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'restore_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'restore_any_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'replicate_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'reorder_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'delete_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'delete_any_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'force_delete_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'force_delete_any_event::tracking',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'view_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'view_any_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'create_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'update_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'restore_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'restore_any_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'replicate_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'reorder_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'delete_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'delete_any_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'force_delete_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'force_delete_any_geofence',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'view_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'view_any_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'create_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'update_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'restore_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'restore_any_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'replicate_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'reorder_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'delete_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'delete_any_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'force_delete_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'force_delete_any_geofence::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'view_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'view_any_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'create_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'update_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'restore_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'restore_any_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'replicate_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'reorder_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'delete_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'delete_any_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'force_delete_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'force_delete_any_location',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'view_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'view_any_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'create_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'update_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'restore_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'restore_any_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'replicate_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'reorder_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'delete_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'delete_any_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'force_delete_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'force_delete_any_location::type',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'view_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'view_any_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'create_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'update_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'restore_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'restore_any_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'replicate_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'reorder_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'delete_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'delete_any_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'force_delete_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'force_delete_any_map::setting',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'view_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'view_any_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'create_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'update_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'restore_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'restore_any_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'replicate_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'reorder_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'delete_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'delete_any_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'force_delete_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'force_delete_any_radar::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'view_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'view_any_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'create_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'update_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'restore_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'restore_any_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'replicate_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'reorder_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'delete_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'delete_any_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'force_delete_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'force_delete_any_sensor',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'view_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'view_any_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'create_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'update_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'restore_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'restore_any_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'replicate_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'reorder_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'delete_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'delete_any_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'force_delete_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'force_delete_any_sensor::data',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'view_shield::role',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'view_any_shield::role',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'create_shield::role',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'update_shield::role',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'delete_shield::role',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'delete_any_shield::role',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'restore_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'replicate_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'reorder_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'page_Classifications',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'page_LiveMaps',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'widget_AisDataChart',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'widget_VesselTypeOverview',
                'guard_name' => 'web',
                'created_at' => '2023-12-14 11:05:42',
                'updated_at' => '2023-12-14 11:05:42',
            ),
        ));
        
        
    }
}