<?php
namespace Domain\Distribution\Services;

use Domain\Distribution\Entities\Distribution;
use Domain\Distribution\Entities\InvestmentDistribution;
use Domain\Distribution\ValueObjects\AmountValueObject;
use Domain\Distribution\ValueObjects\RatesValueObject;
use Exception;

class InvestmentDistributionBase implements InvestmentDistributionServiceInterface
{

    /**
     * Calculate and distribute invested amount through investors.
     *
     * @throws Exception
     */
    public function calculateInvestmentDistribution(AmountValueObject $amountValueObject, RatesValueObject $ratesValueObject): Distribution
    {
        /** @var Distribution $distribution */
        $distribution = app(Distribution::class, [
            'amount' => $amountValueObject->getAmount(),
            'rates' => $ratesValueObject->getRates()
        ]);

        foreach ($distribution->getRates() as $rate) {
            $totalRawInvestedAmount = $rate->getRate() * $amountValueObject->getAmount(); // Amount in cents
            $roundedDownAmountToDistribute = (int) floor($totalRawInvestedAmount);

            /** @var InvestmentDistribution $investment */
            $investment = app(InvestmentDistribution::class, [
                'investor' => $rate->getInvestor(),
                'distributedAmount' => $roundedDownAmountToDistribute,
                'distribution' => $rate->getRate(),
            ]);

            $investment->setRoundingReminderInCents($totalRawInvestedAmount);
            $distribution->addInvestment($investment);
        }

        if ($distribution->getTotalInvested() !== $amountValueObject->getAmount()) {
            throw new Exception('Total amount and total remainders are not equal');
        }

        return $distribution;
    }
}
