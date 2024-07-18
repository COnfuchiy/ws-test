<?php

// src/Entity/Participant.php
namespace App\Entity;

use DateTimeInterface;

class Participant
{
    private float $baseCost;
    private DateTimeInterface $birthdate;
    private ?DateTimeInterface $tripStartDate;
    private ?DateTimeInterface $paymentDate;

    public function __construct(
        float $baseCost,
        DateTimeInterface $birthdate,
        ?DateTimeInterface $tripStartDate = null,
        ?DateTimeInterface $paymentDate = null
    ) {
        $this->baseCost = $baseCost;
        $this->birthdate = $birthdate;
        $this->tripStartDate = $tripStartDate;
        $this->paymentDate = $paymentDate;
    }

    public function getBaseCost(): float
    {
        return $this->baseCost;
    }

    public function setBaseCost(float $baseCost): void
    {
        $this->baseCost = $baseCost;
    }

    public function getBirthdate(): DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTimeInterface $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function getTripStartDate(): ?DateTimeInterface
    {
        return $this->tripStartDate;
    }

    public function setTripStartDate(?DateTimeInterface $tripStartDate): void
    {
        $this->tripStartDate = $tripStartDate;
    }

    public function getPaymentDate(): ?DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?DateTimeInterface $paymentDate): void
    {
        $this->paymentDate = $paymentDate;
    }
}
