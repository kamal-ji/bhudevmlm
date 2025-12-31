<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EmailSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('email_settings')->insert([
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_port' => '587',
            'smtp_username' => 'your_smtp_username',
            'smtp_password' => 'your_smtp_password',
            'smtp_encryption' => 'tls',
            'from_address' => 'example@domain.com',
            'from_name' => 'Your Application Name',
        ]);
    }
}
