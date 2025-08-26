<?php

namespace App\Actions\v1\Candidate\Contact;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteContactAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $contactId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $contactId): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $contact   = $candidate->contacts()->findOrFail($contactId);

            $contactName = $contact->name ?? "Контакт #{$contactId}";
            $contact->delete();

            logActivity(
                "Контакт удалён!",
                "У кандидата {$candidate->first_name} {$candidate->last_name} (ID {$candidate->id}) был удалён контакт: {$contactName} (ID {$contactId})."
            );

            return static::toResponse(
                message: "$id - id li Contact o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
