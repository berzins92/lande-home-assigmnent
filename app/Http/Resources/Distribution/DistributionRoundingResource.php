<?php

namespace App\Http\Resources\Distribution;

use App\Models\Investment;
use App\Models\InvestmentDistribution;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Investment
 */
class DistributionRoundingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->investment_id,
            'roundings' => $this->transformRounding(),
            'total' => $this->calculateTotalRounding(),
        ];
    }

    /**
     * Calculate the total rounding reminders.
     *
     * @return int
     */
    protected function calculateTotalRounding(): int
    {
        return $this->distributions->sum(
            fn (InvestmentDistribution $distribution) => $distribution->rounding_reminder->getRoundingReminder()
        );
    }

    /**
     * Transform the distribution into the required format.
     *
     * @return array
     */
    protected function transformRounding(): array
    {
        return $this->distributions->mapWithKeys(fn (InvestmentDistribution $item) => [
            $item->investor_name => $item->rounding_reminder->getRoundingReminder(),
        ])->toArray();
    }
}
