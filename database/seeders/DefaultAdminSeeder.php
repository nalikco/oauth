<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::query()->count() > 0) return;
        
        $user = User::factory()->create([
            'email' => 'admin@nalik.by',
        ]);
        $user->syncRoles(['admin']);
    }
}
