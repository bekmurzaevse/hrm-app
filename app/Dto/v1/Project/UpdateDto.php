<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
        public int $clientId,
        public int $vacancyId,
        public ?array $performers,
        public string $deadline,
        public ?string $contractNumber,
        public ?string $contractBudget,
        // public ?string $contractCurrency,
        public ?string $description,
        public ?string $comment,
    ) {
    }


    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->title,
            clientId: $request->client_id,
            vacancyId: $request->vacancy_id,
            performers: $request->performers,
            deadline: $request->deadline,
            contractNumber: $request->contract_number,
            contractBudget: $request->contract_budget,
            // contractCurrency: $request->contract_currency,
            description: $request->description,
            comment: $request->comment,
        );
    }
}
