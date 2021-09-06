<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CustomField;

class FieldsOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields_options')->insert([
            'field_id' => CustomField::where('name','Type')->pluck('id')->first(),
            'value' => 'Critical',
        ]);
        DB::table('fields_options')->insert([
            'field_id' => CustomField::where('name','Type')->pluck('id')->first(),
            'value' => 'Enhancement',
        ]);
        DB::table('fields_options')->insert([
            'field_id' => CustomField::where('name','Type')->pluck('id')->first(),
            'value' => 'Bug',
        ]);
        DB::table('fields_options')->insert([
            'field_id' => CustomField::where('name','Type')->pluck('id')->first(),
            'value' => 'Customer Facing',
        ]);
    }
}
