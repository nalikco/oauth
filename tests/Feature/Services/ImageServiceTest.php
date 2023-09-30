<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    /**
     * Test storing an image in the model.
     */
    public function testStoreInModel(): void
    {
        // Create an instance of the ImageService class
        $imageService = $this->app->make(ImageService::class);

        // Create a fake uploaded file with the name 'image.jpg' and the MIME type 'image/jpeg'
        $uploadedFile = UploadedFile::fake()->create('image.jpg', mimeType: 'image/jpeg');

        // Store the uploaded file using the image service and get the path
        $path = $imageService->store('clients', 1, $uploadedFile);

        // Assert that the file exists in the storage
        Storage::assertExists($path);

        // Delete the file from the storage
        Storage::delete($path);
    }
}
