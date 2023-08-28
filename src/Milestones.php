<?php

namespace Bluewing\Progress23;

use Bluewing\Algorithms23\BonAlgorithm;
use Bluewing\Progress23\Structs\MilestonesStruct;
use Exception;

class Milestones
{
    protected MilestonesStruct|null $data = null;
    protected Rating|null $firstRating = null;
    protected Rating|null $lastRating = null;
    protected BonAlgorithm|null $algorithm = null;
    protected RatingCollection|null $ratings = null;
    protected float $change = 0.0;

    /**
     * @throws Exception
     */
    public function __construct(BonAlgorithm $algorithm, RatingCollection $ratings)
    {
        $this->algorithm = $algorithm;
        $this->ratings = $ratings;

        $this->data = new MilestonesStruct;

        $this->calculateAndPopulateData();
    }

    /**
     * @throws Exception
     */
    private function calculateAndPopulateData(): void
    {
        if ($this->ratings->count() < 2) {
            $this->data->cscMet = false;
            $this->data->rcMet = false;
            $this->data->rcOrCscMet = false;
            return;
        }

        $this->firstRating = $this->ratings->first();

        $msg = 'The first rating score is invalid. It must be between 0.0 and 40.0.';

        if ($this->firstRating->data()->score < 0 || $this->firstRating->data()->score > 40) throw new Exception($msg);

        $this->lastRating = $this->ratings->last();

        $msg = 'The last rating score is invalid. It must be between 0.0 and 40.0.';

        if ($this->lastRating->data()->score < 0 || $this->lastRating->data()->score > 40) throw new Exception($msg);

        $this->change = ($this->lastRating->data()->score - $this->firstRating->data()->score);

        $this->data->cscMet = $this->cscMet();
        $this->data->rcMet = !$this->data->cscMet && $this->rcMet();
        $this->data->rcOrCscMet = $this->data->rcMet || $this->data->cscMet;
    }

    public function data(): MilestonesStruct
    {
        return $this->data;
    }

    private function cscMet(): bool
    {
        // INFO: Determine if an OPEN or CLOSED rater met clinically significant change.
        //  There must be at least two (2) rating scores.

        if (! $this->rcMet()) return false;

        if ($this->firstRating->data()->score > $this->algorithm->clinicalCutoff) return false;

        return ($this->lastRating->data()->score > $this->algorithm->clinicalCutoff);
    }

    private function rcMet(): bool
    {
        // INFO: Determine if a rater has met reliable change.
        //  A minimum of two (2) rating scores are required.

        return ($this->change >= $this->algorithm->reliableChangeIndex);
    }
}