<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\KnowledgeBase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmailTemplateTableSeed::class);
        $this->call(GeneralSettingTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(TestimonialsTableSeeder::class);
        $this->call(SocialLinkTableSeeder::class);
        $this->call(HowWorkTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        // install for customer
        $name = Cache::get('username');
        $email = Cache::get('email');
        $password = Cache::get('password');

        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => 1,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'User Smith',
            'email' => 'user@demo.com',
            'password' => Hash::make('12345678'),
        ]);

        DB::table('departments')->insert([
            'title' => 'IT',
            'description' => 'Lorem Ipsum is simply dummy text text',
        ]);
        DB::table('departments')->insert([
            'title' => 'Domain',
            'description' => 'Lorem Ipsum is simply dummy text text',
        ]);

        DB::table('departments')->insert([
            'title' => 'Hosting',
            'description' => 'Lorem Ipsum is simply dummy text text',
        ]);
        DB::table('departments')->insert([
            'title' => 'Web Development',
            'description' => 'Lorem Ipsum is simply dummy text text',
        ]);

        DB::table('departments')->insert([
            'title' => 'Home Delivery',
            'description' => 'Lorem Ipsum is simply dummy text text',
        ]);

        $count = 5;
        factory(KnowledgeBase::class, $count)->create();
    }
}
