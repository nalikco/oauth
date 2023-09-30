<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\Client\StoreDto;
use App\Dto\Client\UpdateDto;
use App\Models\Passport\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Laravel\Passport\ClientRepository as PassportClientRepository;

class ClientRepository
{
    private readonly string $locale;

    public function __construct(
        private readonly PassportClientRepository $passportRepository,
    )
    {
        $this->locale = App::getLocale();
    }

    /**
     * Retrieves a paginated list of clients.
     *
     * @param int $page The page number to retrieve.
     * @param int $perPage The number of items per page (default: 10).
     * @return LengthAwarePaginator The paginated list of clients.
     */
    public function getWithPaginate(int $page, int $perPage = 10): LengthAwarePaginator
    {
        return Client::query()
            ->where('personal_access_client', false)
            ->where('password_client', false)
            ->where('revoked', false)
            ->latest('created_at')
            ->paginate(perPage: $perPage, page: $page);
    }

    /**
     * Store a new client.
     *
     * @param int $userId The ID of the user.
     * @param StoreDto $dto The data transfer object containing the client details.
     * @return Client The newly created client.
     */
    public function store(int $userId, StoreDto $dto): Client
    {
        $client = $this->passportRepository->create(
            userId: $userId,
            name: $dto->name[$this->locale],
            redirect: $dto->redirect,
        );
        $client->update($dto->toArray());

        return $client;
    }

    /**
     * Update a client with the given data.
     *
     * @param Client $client The client to update.
     * @param UpdateDto $dto The data to update the client with.
     * @return Client The updated client.
     */
    public function update(Client $client, UpdateDto $dto): Client
    {
        $data = $dto->toArray();
        $data['name'] = $dto->name[$this->locale];
        $client->update($data);

        return $client;
    }

    /**
     * Updates the image field of a client.
     *
     * @param Client $client The client to update the image field for.
     * @param string $image The new image value.
     * @return Client The updated client object.
     */
    public function updateImageField(Client $client, string $image): Client
    {
        $client->update([
            'image' => $image,
        ]);

        return $client;
    }

    /**
     * Destroy a client.
     *
     * @param Client $client The client to be destroyed.
     */
    public function destroy(Client $client): void
    {
        $client->delete();
    }
}
