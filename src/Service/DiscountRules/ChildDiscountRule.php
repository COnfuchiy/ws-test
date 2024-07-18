<?php

namespace App\Service\DiscountRules;

use App\Entity\Participant;
use DateTimeInterface;

class ChildDiscountRule
{
    const AGE_OF_MAJORITY = 18;

    public function apply(Participant $participant): float
    {
        if ($participant->getPaymentDate() === null) {
            return 0;
        }

        $tripStartDate = $participant->getTripStartDate();
        $birthdate = $participant->getBirthdate();

        $ageAtTripStart = $this->calculateAge($birthdate, $tripStartDate);

        $baseCost = $participant->getBaseCost();

        $discount = $this->calculateDiscount($baseCost, $ageAtTripStart);

        return $baseCost - $discount;
    }

    private function calculateAge(DateTimeInterface $dateOfBirth, DateTimeInterface $tripStartDate): int
    {
        $interval = $dateOfBirth->diff($tripStartDate);
        return $interval->y;
    }

    private function calculateDiscount(float $baseCost, int $age): float
    {
        if ($age > 3 && $age < self::AGE_OF_MAJORITY) {
            if ($age < 6) {
                return $baseCost * 0.8;
            }

            if ($age < 12) {
                $discount = $baseCost * 0.3;
                return min($discount, 4500);
            }

            return $baseCost * 0.1;
        }
        return 0;
    }
}