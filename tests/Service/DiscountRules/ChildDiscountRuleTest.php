<?php

namespace App\Tests\Service\DiscountRules;

use App\Entity\Participant;
use App\Service\DiscountRules\ChildDiscountRule;
use DateTime;
use PHPUnit\Framework\TestCase;

class ChildDiscountRuleTest extends TestCase
{

    private array $testCases = [];

    public function setUp(): void
    {
    $this->testCases = [
      [
        'participant' => new Participant(
            10000,
            new DateTime('2010-03-04'),
            new DateTime('2024-01-01'),
            new DateTime('2024-01-01')
        ),
        'expectedCost' => 9000
      ],
      [
        'participant' => new Participant(
            10000,
            new DateTime('2019-03-04'),
            new DateTime('2024-01-01'),
            new DateTime('2024-01-01')
        ),
        'expectedCost' => 2000
      ],
      [
        'participant' => new Participant(
            10000,
            new DateTime('2016-03-04'),
            new DateTime('2024-01-01'),
            new DateTime('2024-01-01')
        ),
        'expectedCost' => 7000
      ],
      [
        'participant' => new Participant(
            20000,
            new DateTime('2016-03-04'),
            new DateTime('2024-01-01'),
            new DateTime('2024-01-01')
        ),
        'expectedCost' => 15500
      ],
      [
        'participant' => new Participant(
            10000,
            new DateTime('2000-03-04'),
            new DateTime('2024-01-01'),
            new DateTime('2024-01-01')
        ),
        'expectedCost' => 10000
      ],

    ];

    }

    public function testApply(): void
    {
        $rule = new ChildDiscountRule();

        foreach ($this->testCases as $testCase) {
            $discount = $rule->apply($testCase['participant']);
            $this->assertEquals($testCase['expectedCost'], $discount);
        }

    }
}