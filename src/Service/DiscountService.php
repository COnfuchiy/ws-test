<?php

namespace App\Service;

use App\Entity\Participant;
use App\Service\DiscountRules\ChildDiscountRule;
use App\Service\DiscountRules\EarlyBookingDiscountRule;
use Exception;

class DiscountService
{
    private ChildDiscountRule $childDiscountRule;
    private EarlyBookingDiscountRule $earlyBookingDiscountRule;

    public function __construct(
        ChildDiscountRule $childDiscountRule,
        EarlyBookingDiscountRule $earlyBookingDiscountRule
    ) {
        $this->childDiscountRule = $childDiscountRule;
        $this->earlyBookingDiscountRule = $earlyBookingDiscountRule;
    }

    /**
     * @throws Exception
     */
    public function calculateCostWithDiscount(Participant $participant): float
    {
        $costWithChildDiscount = $this->childDiscountRule->apply($participant);
        return $this->earlyBookingDiscountRule->apply($participant, $costWithChildDiscount);
    }
}