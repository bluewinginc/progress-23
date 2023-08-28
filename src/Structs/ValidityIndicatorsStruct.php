<?php

namespace Bluewing\Progress23\Structs;

class ValidityIndicatorsStruct
{
    public ClinicalCutoffStruct|null $clinicalCutoff = null;
    public bool $firstRatingAbove32 = false;
    public SawtoothPatternStruct|null $sawtoothPattern = null;
    public bool $zeroOrOneMeetings = true;

    public function toArray(): array
    {
        return [
            'clinicalCutoff' => $this->clinicalCutoff->toArray(),
            'firstRatingAbove32' => $this->firstRatingAbove32,
            'sawtoothPattern' => $this->sawtoothPattern->toArray(),
            'zeroOrOneMeetings' => $this->zeroOrOneMeetings
        ];
    }
}