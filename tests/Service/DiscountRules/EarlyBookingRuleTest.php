<?php

namespace App\Tests\Service\DiscountRules;

use App\Entity\Participant;
use App\Service\DiscountRules\ChildDiscountRule;
use App\Service\DiscountRules\EarlyBookingDiscountRule;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class EarlyBookingRuleTest extends TestCase
{

    private array $testCases = [];

    public function setUp(): void
    {
        $this->testCases = [
            [
                'participant' => new Participant(
                    100,
                    new DateTime('2000-01-01'),
                    new DateTime('2027-05-01'),
                    new DateTime('2026-11-29')
                ),
                'expectedCost' => 93
            ],
            [
                'participant' => new Participant(
                    100,
                    new DateTime('2000-01-01'),
                    new DateTime('2027-05-01'),
                    new DateTime('2026-12-29')
                ),
                'expectedCost' => 95
            ],
            [
                'participant' => new Participant(
                    100,
                    new DateTime('2000-01-01'),
                    new DateTime('2027-05-01'),
                    new DateTime('2027-01-29')
                ),
                'expectedCost' => 97
            ],
 [
                'participant' => new Participant(
                    100,
                    new DateTime('2000-01-01'),
                    new DateTime('2027-01-15'),
                    new DateTime('2026-08-30')
                ),
                'expectedCost' => 93
            ],
            [
                'participant' => new Participant(
                    100,
                    new DateTime('2000-01-01'),
                    new DateTime('2027-01-15'),
                    new DateTime('2026-09-29')
                ),
                'expectedCost' => 95
            ],
            [
                'participant' => new Participant(
                    100,
                    new DateTime('2000-01-01'),
                    new DateTime('2027-01-15'),
                    new DateTime('2026-10-30')
                ),
                'expectedCost' => 97
            ],

        ];
    }

    /**
     * @throws Exception
     */
    public function testApply(): void
    {
        $rule = new EarlyBookingDiscountRule();

        for ($testCaseIndex = 0; $testCaseIndex < count($this->testCases); $testCaseIndex++) {
            echo "Test case: $testCaseIndex" . PHP_EOL;
            $testCase = $this->testCases[$testCaseIndex];
            $discount = $rule->apply($testCase['participant']);
            $this->assertEquals($testCase['expectedCost'], $discount);
        }
    }
}