<?php

namespace App\Http\Resources\v1\Candidate;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
class CandidateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cards' => [
                'candidates_count' => Candidate::count(),
                'suitable_count' => Candidate::where('status','Suitable')->count(),
                'interview_count' => Candidate::where('status','Interview')->count(),
                'reject_count' => Candidate::where('status','Reject')->count(),
            ],
            'items' => IndexResource::collection($this->collection),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage(),
                'total' => $this->total(),
            ],
        ];
    }
}
