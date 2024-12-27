<?php

namespace Domain\Distribution\Services;

use Domain\Distribution\Entities\Distribution;
use Domain\Distribution\ValueObjects\AmountValueObject;
use Domain\Distribution\ValueObjects\RatesValueObject;

class InvestmentDistributionService implements InvestmentDistributionServiceInterface
{

    public function __construct(private readonly InvestmentDistributionServiceInterface $distributionService)
    {

    }

    public function calculateInvestmentDistribution(
        AmountValueObject $amountValueObject,
        RatesValueObject $ratesValueObject
    ): Distribution
    {
        return $this->distributionService->calculateInvestmentDistribution($amountValueObject, $ratesValueObject);
    }
}
