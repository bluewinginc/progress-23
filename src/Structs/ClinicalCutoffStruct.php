<?php

namespace Bluewing\Progress23\Structs;

class ClinicalCutoffStruct
{
    public float $value = 0.0;
    public string $valueAsString = '0.0';
    public float|null $firstRatingScore = null;
    public string|null $firstRatingScoreAsString = null;
    public bool $isAbove = false;

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'valueAsString' => $this->valueAsString,
            'firstRatingScore' => $this->firstRatingScore,
            'firstRatingScoreAsString' => $this->firstRatingScoreAsString,
            'isAbove' => $this->isAbove
        ];
    }
}