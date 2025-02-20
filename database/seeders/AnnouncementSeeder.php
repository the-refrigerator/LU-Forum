<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('threads')->insert([
            [
                'id' => 1,
                'name' => 'Announcements',
                'description' => 'Important announcements and updates.',
            ]
        ]);
    }
}
