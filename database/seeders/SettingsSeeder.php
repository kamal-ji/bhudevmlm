<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('settings')->insert([
            ['name' => 'api_base_url', 'value' => 'https://erp.tiarasoftwares.in/'],
            ['name' => 'name', 'value' => 'Tiarass'],
            ['name' => 'appid', 'value' => 'Tiara_Falcon'],
            ['name' => 'image_url', 'value' => 'https://tiarasoftwares.co.in/uploads/client/tiara/'],
            ['name' => 'logo_url', 'value' => 'https://tiarasoftwares.co.in/uploads/client/tiara/...'],
            ['name' => 'firebase_auth_domain', 'value' => 'tiara-adb0a.firebaseapp.com'],
            ['name' => 'firbase_apiKey', 'value' => 'AIzaSyCCpefxXHckoxYQfEFEI0qpVokZ5HCRGMI'],
            ['name' => 'copyright', 'value' => 'Tiara@2025'],
            ['name' => 'x-apikey', 'value' => 'x/QjD7YtffAyWBb2ie/kgXpHobQNpP8e4Ts01nk/FHrDZioRMC...'],
            ['name' => 'uuid', 'value' => '0bb9497b-2681-49df-95d7-fbe44c983876'],
            ['name' => 'db_state', 'value' => 'online'],
            ['name' => 'emailid', 'value' => 'naren@tiarasoftwares.com'],
            ['name' => 'username', 'value' => 'clouderp'],
            ['name' => 'password', 'value' => '123456'],
            ['name' => 'firebase_project_id', 'value' => 'tiara-adb0a'],
            ['name' => 'firebase_storage_bucket', 'value' => 'tiara-adb0a.firebasestorage.app'],
            ['name' => 'firebase_messaging_sender_id', 'value' => '424284680643'],
            ['name' => 'firebase_app_id', 'value' => '1:424284680643:web:8e3b6bc8067073cf0b8d76'],
            ['name' => 'firebase_measurement_id', 'value' => 'G-B0FQY3FCD1'],
        ]);
    }
}
