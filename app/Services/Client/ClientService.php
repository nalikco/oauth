<?php

declare(strict_types=1);

namespace App\Services\Client;

use App\Dto\Client\CreateDto;
use App\Dto\Client\Factories\CreateStoreDtoFactory;
use App\Dto\Client\Factories\CreateUpdateDtoFactory;
use App\Models\Passport\Client;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;

readonly class ClientService
{
    public function __construct(
        private ClientRepository $repository,
        private ImageService     $imageService,
    )
    {
    }

    /**
     * Store a new client in the database.
     *
     * @param User $user The user object.
     * @param CreateDto $dto The data transfer object for creating a client.
     * @return Client The newly created client.
     */
    public function store(User $user, CreateDto $dto): Client
    {
        $client = $this->repository->store(
            $user->id,
            CreateStoreDtoFactory::createFromCreateDto($dto),
        );

        if ($dto->image != null) {
            $client = $this->repository->updateImageField(
                $client,
                $this->storeImageAndGetPath($client, $dto->image),
            );
        }

        return $client;
    }

    /**
     * Updates a client with the provided data.
     *
     * @param Client $client The client to update.
     * @param CreateDto $dto The data to update the client with.
     * @return Client The updated client.
     */
    public function update(Client $client, CreateDto $dto): Client
    {
        $imagePath = null;
        if ($dto->image != null) {
            $imagePath = $this->storeImageAndGetPath($client, $dto->image);
        }

        return $this->repository->update(
            $client,
            CreateUpdateDtoFactory::createFromCreateDto($dto, $imagePath),
        );
    }

    /**
     * Destroy a client.
     *
     * @param Client $client The client to be destroyed.
     */
    public function destroy(Client $client): void
    {
        $this->repository->destroy($client);
    }

    /**
     * Store an image and get the path.
     *
     * @param Client $client The client object.
     * @param UploadedFile $image The uploaded image.
     * @return string The path of the stored image.
     */
    private function storeImageAndGetPath(Client $client, UploadedFile $image): string
    {
        return $this->imageService->store('clients', $client->id, $image);
    }
}
