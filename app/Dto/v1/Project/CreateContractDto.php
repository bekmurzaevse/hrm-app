<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\CreateContractRequest;

readonly class CreateContractDto
{
    public function __construct(
        public ?string $contractNumber,
        public ?string $contractBudget,
        // public ?string $contractCurrency,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\CreateContractRequest $request
     * @return CreateContractDto
     */
    public static function from(CreateContractRequest $request): self
    {
        return new self(
            contractNumber: $request->contract_number,
            contractBudget: $request->contract_budget,
            // contractCurrency: $request->contract_currency,
        );
    }
}
