<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PayRollDatesRequest
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Range(
            notInRangeMessage: 'The year must be between {{ min }} and {{ max }}',
            min: 2020,
            max: 2030
        )]
        public int|string $year,

        #[Assert\NotNull]
        #[Assert\Range(
            notInRangeMessage: 'The month must be between {{ min }} and {{ max }}',
            min: 1,
            max: 12
        )]
        public int|string $month,
    ) {
    }

    public function toTyped(): self
    {
        $this->year = (int) $this->year;
        $this->month = (int) $this->month;

        return $this;
    }
}
