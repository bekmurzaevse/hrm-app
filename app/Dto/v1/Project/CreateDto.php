<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public int $clientId,
        public int $vacancyId,
        public string $deadline,
        public ?string $contractNumber,
        public ?string $contractBudget,
        // public ?string $contractCurrency,
        public ?string $description,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            clientId: $request->input('client_id'),
            vacancyId: $request->input('vacancy_id'),
            deadline: $request->input('deadline'),
            contractNumber: $request->input('contract_number'),
            contractBudget: $request->input('contract_budget'),
            // contractCurrency: $request->input('contract_currency'),
            description: $request->input('description'),
            comment: $request->input('comment'),
        );
    }
}
