<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('custom_fields')->insert([
            'name' => 'Type',
            'type' => 'select',
            'required' => 0,
            'status' => 1,
        ]);
    }
}
