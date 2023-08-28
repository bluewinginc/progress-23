<?php

namespace Bluewing\Progress23;

use Bluewing\Algorithms23\BonAlgorithm;
use Bluewing\Progress23\Structs\ClinicalCutoffStruct;
use InvalidArgumentException;

class ClinicalCutoff
{
    private ClinicalCutoffStruct|null $data;
    private BonAlgorithm $algorithm;
    private RatingCollection|null $ratings;

    public function __construct(BonAlgorithm $algorithm, RatingCollection $ratings)
    {
        $this->data = new ClinicalCutoffStruct;

        $this->algorithm = $algorithm;
        $this->ratings = $ratings;

        $this->data->value = $this->algorithm->clinicalCutoff;
        $this->data->valueAsString = number_format($this->data->value, 1);

        $this->calculateAndPopulateData();
    }

    private function calculateAndPopulateData(): void
    {
        $firstRating = $this->ratings->first();

        if (is_null($firstRating)) {
            $this->data->firstRatingScore = null;
            $this->data->firstRatingScoreAsString = null;
            $this->data->isAbove = false;
            return;
        }

        if ($firstRating->data()->score < 0 || $firstRating->data()->score > 40) {
            throw new InvalidArgumentException('The first rating score is invalid. It must be between 0.0 and 40.0.');
        }

        $this->data->firstRatingScore = $firstRating->data()->score;
        $this->data->firstRatingScoreAsString = number_format($this->data->firstRatingScore, 1);
        $this->data->isAbove = ($firstRating->data()->score > $this->data->value);
    }

    public function data(): ClinicalCutoffStruct
    {
        return $this->data;
    }
}