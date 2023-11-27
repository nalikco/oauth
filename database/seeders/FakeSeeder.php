<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DatabaseSeeder::class,
            ClientSeeder::class,
            UserSeeder::class,
            PassportTokenSeeder::class,
        ]);
    }
}
