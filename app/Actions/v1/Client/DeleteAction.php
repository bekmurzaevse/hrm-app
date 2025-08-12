<?php

namespace App\Actions\v1\Client;

use App\Exceptions\ApiResponseException;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    use ResponseTrait;

    public function __invoke(int $id)
    {
        try {
            $client = Client::findOrFail($id);

            $client->files()->delete();

            Storage::disk('public')->deleteDirectory("clients/$client->id");

            $client->delete();

            return static::toResponse(
                message: "$id - id li client o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Client Not Found', 404);
        }
    }

}
