<?php

namespace App\Http\Resources\Distribution;

use App\Models\InvestmentDistribution;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin InvestmentDistribution
 */
class InvestmentDistributionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->investor_name => $this->distributed_amount,
        ];
    }
}
