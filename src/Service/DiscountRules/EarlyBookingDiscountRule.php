<?php

namespace App\Service\DiscountRules;

use App\Entity\Participant;
use DateTime;
use DateTimeInterface;
use Exception;

class EarlyBookingDiscountRule
{
    /**
     * @throws Exception
     */
    public function apply(Participant $participant, float $costWithChildDiscount = null): float
    {
        if ($participant->getPaymentDate() === null) {
            return 0;
        }

        $tripStartDate = $participant->getTripStartDate();
        $dateOfPayment = $participant->getPaymentDate();

        $baseCost = $costWithChildDiscount ?? $participant->getBaseCost();

        $discount = $this->calculateDiscount($tripStartDate, $dateOfPayment, $baseCost);

        return $baseCost - min($discount, 1500);
    }

    /**
     * @throws Exception
     */
    private function calculateDiscount(
        DateTimeInterface $tripStartDate,
        DateTimeInterface $dateOfPayment,
        float $baseCost
    ): float {
        $discountPercentage = 0;
        $immutableTripStartDate = \DateTimeImmutable::createFromInterface($tripStartDate);

        // The start date trip april 1 - september 30 next year
        if ($this->isInDateRange($tripStartDate, 1, 4, 0, 30, 9, 0)) {
            if ($dateOfPayment <= $immutableTripStartDate->modify('last day of November previous year')) {
                $discountPercentage = 0.07;
            } elseif ($dateOfPayment <= $immutableTripStartDate->modify('last day of December previous year')) {
                $discountPercentage = 0.05;
            } elseif ($dateOfPayment <= $immutableTripStartDate->modify('last day of January this year')) {
                $discountPercentage = 0.03;
            }
        // The start date trip october 1 current year - january 14 next year
        } elseif ($this->isInDateRange($tripStartDate, 1, 10, -1, 14, 1, 0)) {
            if ($dateOfPayment <= $immutableTripStartDate->modify('last day of March previous year')) {
                $discountPercentage = 0.07;
            } elseif ($dateOfPayment <= $immutableTripStartDate->modify('last day of April previous year')) {
                $discountPercentage = 0.05;
            } elseif ($dateOfPayment <= $immutableTripStartDate->modify('last day of May previous year')) {
                $discountPercentage = 0.03;
            }
        // The start date trip from january 1 next year and beyond
        } elseif ($this->isInDateRange($tripStartDate, 15, 1, 0, 1, 1, 9999)) {
            if ($dateOfPayment <= $immutableTripStartDate->modify('last day of August previous year')) {
                $discountPercentage = 0.07;
            } elseif ($dateOfPayment <= $immutableTripStartDate->modify('last day of September previous year')) {
                $discountPercentage = 0.05;
            } elseif ($dateOfPayment <= $immutableTripStartDate->modify('last day of October previous year')) {
                $discountPercentage = 0.03;
            }
        }

        return $baseCost * $discountPercentage;
    }

    /**
     * @throws Exception
     */
    private function isInDateRange(
        DateTimeInterface $date,
        int $startDay,
        int $startMonth,
        int $startYearAdjustment,
        int $endDay,
        int $endMonth,
        int $endYearAdjustment
    ): bool {
        $currentYear = $date->format('Y');
        $startDate = new DateTime((int)$currentYear + $startYearAdjustment . "-$startMonth-$startDay");
        $endDate = new DateTime(min((int)$currentYear + $endYearAdjustment, 9999) . "-$endMonth-$endDay");

        return $date >= $startDate && $date <= $endDate;
    }
}