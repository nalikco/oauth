<?php

namespace Database\Seeders;

use App\Models\Passport\Client;
use App\Models\User;
use Database\Factories\Passport\ClientFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class PassportTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $clients = Client::all();
        if ($users->count() == 0) $users = collect([User::factory()->create()->fresh()]);
        if ($clients->count() == 0) $clients = collect([ClientFactory::new()
            ->create()]);

        collect(range(1, 20))->each(function () use ($users, $clients) {
            Passport::token()
                ->newQuery()
                ->create([
                    'id' => Str::random(100),
                    'user_id' => $users->random()->id,
                    'client_id' => $clients->random()->id,
                    'name' => 'Web',
                    'scopes' => ['*'],
                    'revoked' => false,
                    'expires_at' => now()->addYear(),
                ]);
        });
    }
}
