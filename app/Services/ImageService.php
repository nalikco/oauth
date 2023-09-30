<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Store an uploaded image file.
     *
     * @param  string  $path The path where the image will be stored.
     * @param  string|int  $id The ID of the image.
     * @param  UploadedFile  $image The uploaded image file.
     * @return string The URL of the stored image.
     */
    public function store(string $path, string|int $id, UploadedFile $image): string
    {
        $fileName = $id.'-'.$image->getClientOriginalName();
        $image->storePubliclyAs($path, $fileName);

        return $path.'/'.$fileName;
    }
}
