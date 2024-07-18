<?php

namespace App\Tests\Service;

use App\Entity\Participant;
use App\Service\DiscountRules\ChildDiscountRule;
use App\Service\DiscountRules\EarlyBookingDiscountRule;
use App\Service\DiscountService;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class DiscountServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCalculateCostWithDiscount(): void
    {
        $childDiscountRule = new ChildDiscountRule();
        $earlyBookingDiscountRule = new EarlyBookingDiscountRule();
        $calculator = new DiscountService($childDiscountRule, $earlyBookingDiscountRule);

        $participant = new Participant(
            10000,
            new DateTime('2010-03-04'),
            new DateTime('2027-01-15'),
            new DateTime('2026-09-29')
        );

        $costWithDiscount = $calculator->calculateCostWithDiscount($participant);

        $this->assertIsFloat($costWithDiscount);
        $this->assertEquals(8550, $costWithDiscount);
    }
}