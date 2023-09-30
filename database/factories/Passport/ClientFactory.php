<?php

declare(strict_types=1);

namespace Database\Factories\Passport;

use App\Models\Passport\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $locale = App::getLocale();
        $name = $this->faker->company();

        return $this->ensurePrimaryKeyIsSet([
            'user_id' => null,
            'name' => $name,
            'name_translated' => [$locale => $name],
            'brand' => [$locale => $this->faker->company()],
            'description' => [$locale => $this->faker->text()],
            'link' => $this->faker->url(),
            'image' => null,
            'secret' => Str::random(40),
            'redirect' => $this->faker->url(),
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ]);
    }

    /**
     * Ensure the primary key is set on the model when using UUIDs.
     */
    protected function ensurePrimaryKeyIsSet(array $data): array
    {
        if (Passport::clientUuids()) {
            $keyName = (new $this->model)->getKeyName();

            $data[$keyName] = (string) Str::orderedUuid();
        }

        return $data;
    }

    /**
     * Use as Password Client.
     *
     * @return $this
     */
    public function asPasswordClient(): static
    {
        return $this->state([
            'personal_access_client' => false,
            'password_client' => true,
        ]);
    }

    /**
     * Use as Client Credentials.
     *
     * @return $this
     */
    public function asClientCredentials(): static
    {
        return $this->state([
            'personal_access_client' => false,
            'password_client' => false,
        ]);
    }
}
