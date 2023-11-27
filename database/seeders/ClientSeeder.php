<?php

namespace Database\Seeders;

use Database\Factories\Passport\ClientFactory;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientFactory::new()
            ->count(20)
            ->create();
    }
}
