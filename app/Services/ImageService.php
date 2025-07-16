<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected UploadedFile $file;

    /**
     * Store a file locally and update the model's file attribute using Laravel's store method.
     *
     * @param Model $model
     * @param string $file_attribute
     * @param UploadedFile $file
     * @param string $folder
     * @return bool
     */
    public function storeLocal(Model $model, string $file_attribute, UploadedFile $file, string $folder = 'profile_images')
    {
        $imageUrl = $file->store($folder, 'public');
        $model->$file_attribute = $imageUrl;
        return $model->save();
    }

    /**
     * Update a file locally and update the model's file attribute using Laravel's store method.
     *
     * @param Model $model
     * @param string $file_attribute
     * @param UploadedFile $file
     * @param string $folder
     * @return bool
     */
    public function updateLocal(Model $model, string $file_attribute, UploadedFile $file, string $folder = 'profile_images')
    {
        Storage::disk('public')->delete($model->$file_attribute);
        return $this->storeLocal($model, $file_attribute, $file, $folder);
    }

    public function deleteLocal(Model $model, $file_attribute)
    {
        return Storage::disk('public')->delete($model->$file_attribute);
    }
}
