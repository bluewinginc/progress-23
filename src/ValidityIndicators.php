<?php

namespace Bluewing\Progress23;

use Bluewing\Algorithms23\BonAlgorithm;
use Bluewing\Progress23\Structs\ClinicalCutoffStruct;
use Bluewing\Progress23\Structs\SawtoothPatternStruct;
use Bluewing\Progress23\Structs\ValidityIndicatorsStruct;
use Exception;

class ValidityIndicators
{
    protected ValidityIndicatorsStruct|null $data = null;
    protected BonAlgorithm|null $algorithm = null;
    protected RatingCollection|null $ratings = null;

    /**
     * @throws Exception
     */
    public function __construct(BonAlgorithm $algorithm, RatingCollection $ratings)
    {
        $this->data = new ValidityIndicatorsStruct;

        $this->algorithm = $algorithm;
        $this->ratings = $ratings;

        $this->data->clinicalCutoff = $this->clinicalCutoff();
        $this->data->sawtoothPattern = $this->sawtoothPattern();
        $this->data->firstRatingAbove32 = $this->firstRatingAbove32();
        $this->data->zeroOrOneMeetings = $this->zeroOrOneMeetings();
    }

    public function data(): ValidityIndicatorsStruct
    {
        return $this->data;
    }

    private function clinicalCutoff(): ClinicalCutoffStruct
    {
        $cc = new ClinicalCutoff($this->algorithm, $this->ratings);
        return $cc->data();
    }

    private function firstRatingAbove32(): bool
    {
        if ($this->ratings->count() === 0) return false;

        return $this->ratings->first()->data()->score > 32.0;
    }

    /**
     * @throws Exception
     */
    private function sawtoothPattern(): SawtoothPatternStruct
    {
        $stp = new SawtoothPattern($this->ratings);

        return $stp->data();
    }

    private function zeroOrOneMeetings(): bool
    {
        return ($this->ratings->count() < 2);
    }
}