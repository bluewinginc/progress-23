<?php

namespace Bluewing\Progress23;

use Bluewing\Algorithms23\BonAlgorithmManager;
use Bluewing\Algorithms23\BonAlgorithm;
use Bluewing\Progress23\Structs\EtrStruct;
use Exception;
use InvalidArgumentException;

class EtrMtgTarget
{
    protected EtrStruct|null $data = null;
    protected Rater|null $rater = null;
    protected RatingCollection|null $ratings = null;
    protected BonAlgorithm|null $algorithm = null;

    /**
     * @throws Exception
     */
    public function __construct(Rater $rater, RatingCollection $ratings)
    {
        $this->data = new EtrStruct;

        $this->rater = $rater;
        $this->ratings = $ratings;

        $this->calculateAndPopulateData();
    }

    /**
     * @throws Exception
     */
    private function calculateAndPopulateData(): void
    {
        $manager = new BonAlgorithmManager;

        $this->algorithm = $manager($this->rater->data()->ageGroup, $this->ratings->count());

        $firstRating = $this->ratings->first();

        if ($this->ratings->count() <= 1 || $firstRating->data()->score > 32.0) {
            $this->data->expectedChange = 0.0;
            $this->data->expectedChangeAsString = number_format($this->data->expectedChange, 2);
            $this->data->met = false;
            $this->data->metPercent = 0.0;
            $this->data->metPercentAsString = number_format($this->data->metPercent, 2);
            $this->data->metPercent50 = false;
            $this->data->metPercent67 = false;
            $this->data->value = 0.0;
            $this->data->valueAsString = number_format($this->data->value, 2);

            return;
        }

        $msg = 'The first rating score is invalid. It must be between 0.0 and 40.0.';

        if ($firstRating->data()->score < 0 || $firstRating->data()->score > 40) throw new Exception($msg);

        $firstRatingScore = $firstRating->data()->score;

        $lastRating = $this->ratings->last();

        $msg = 'The last rating score is invalid. It must be between 0.0 and 40.0.';

        if ($lastRating->data()->score < 0 || $lastRating->data()->score > 40) throw new Exception($msg);

        $lastRatingScore = $lastRating->data()->score;

        $this->data->expectedChange = round($this->expectedChange($firstRatingScore), 2);
        $this->data->expectedChangeAsString = number_format($this->data->expectedChange, 2);
        $this->data->met = $this->met($firstRatingScore, $lastRatingScore);
        $this->data->metPercent = round($this->metPercent($firstRatingScore, $lastRatingScore), 2);
        $this->data->metPercentAsString = number_format($this->data->metPercent, 2);
        $this->data->metPercent50 = $this->predictedChangePercentMet($firstRatingScore, $lastRatingScore,50.0);
        $this->data->metPercent67 = $this->predictedChangePercentMet($firstRatingScore, $lastRatingScore,66.66);
        $this->data->value = round($this->value($firstRatingScore, $this->ratings->count()), 2);
        $this->data->valueAsString = number_format($this->data->value, 2);
    }

    public function data(): EtrStruct
    {
        if ($this->ratings->count() === 0) return new EtrStruct;

        return $this->data;
    }

    private function expectedChange(float $firstRatingScore): float
    {
        return $this->value($firstRatingScore, $this->ratings->count()) - $firstRatingScore;
    }

    private function met(float $firstRatingScore, float $lastRatingScore): bool
    {
        // INFO: Return a boolean indicating if an OPEN rater met or exceeded the etr meeting target.
        //  This pertains to progress calculations, progress meter, stats.
        //  We look at the last rating score.
        //  This DOES NOT pertain to graph.
        //  One (1) rating is REQUIRED.
        return $lastRatingScore >= $this->value($firstRatingScore, $this->ratings->count());
    }

    private function metPercent(float $firstRatingScore, float $lastRatingScore): float
    {
        // INFO: Return a value representing the percentage of the etr target met for an OPEN rater only.
        //  It is possible for the etrMeetingTargetMetPercent to be greater than 100, so the ceiling is 100 percent.
        //  One (1) rating is REQUIRED.
        //  When the expected_change is 0.0, a division by 0 error can happen.
        //  When the expected change is less than 0.0, it means the first rating score is above 32.
        //  In these cases always return 0.0.

        if ($this->expectedChange($firstRatingScore) <= 0.0) return 0.0;

        $change = ($lastRatingScore - $firstRatingScore);

        $etrTargetMeetingMetPercent = ($change / $this->expectedChange($firstRatingScore)) * 100;

        if ($etrTargetMeetingMetPercent > 100.0) return 100.0;
        if ($etrTargetMeetingMetPercent < 0.0) return 0.0;

        return $etrTargetMeetingMetPercent;
    }

    private function predictedChangePercentMet(float $firstRatingScore, float $lastRatingScore, float $predictedChangeIndex): bool
    {
        // INFO: Return a boolean indicating if an OPEN rater has met the predicted change at a specific percentage.
        //  This pertains to progress calculations, progress meter, and stats.  This DOES NOT pertain to graph.
        //  Two (2) rating scores are REQUIRED.
        //  When the expected_change is 0.0, a division by 0 error can happen.
        //  When the expected change is less than 0.0, it means the first rating score is above 32.
        //  In these cases always return 0.0.

        if ($this->expectedChange($firstRatingScore) <= 0.0) return 0.0;

        $msg = 'The predictedChangeIndex parameter is invalid.  It must be between 0.0 and 100.0.';

        if ($predictedChangeIndex < 0 || $predictedChangeIndex > 100) throw new InvalidArgumentException($msg);

        $change = $lastRatingScore - $firstRatingScore;

        return ($change / $this->expectedChange($firstRatingScore)) >= ($predictedChangeIndex / 100);
    }

    public function value(float $firstRatingScore, int $meeting): float
    {
        // INFO: Return a value representing an etr value for an OPEN rater for a specific meeting.
        //  Filter through the ratings and create an array of rating scores.  IGNORE skipped ratings.
        //  One (1) ORS score is REQUIRED.

        if ($meeting < 1 || $meeting > $this->ratings->count()) return 0.0;

        $flattenMeeting = $this->algorithm->flattenMeeting;
        $centeredAt20 = $firstRatingScore - 20;
        $interceptMean = $this->algorithm->interceptMean + ($this->algorithm->intake * $centeredAt20);
        $linearMean = $this->algorithm->linearMean + ($this->algorithm->linearByIntake * $centeredAt20);
        $quadraticMean = $this->algorithm->quadraticMean + ($this->algorithm->quadraticByIntake * $centeredAt20);
        $cubicMean = $this->algorithm->cubicMean + ($this->algorithm->cubicByIntake * $centeredAt20);
        $intercept = 1;

        if ($meeting === 1) return $firstRatingScore;     // Intake meeting

        // INFO: This section of code uses the algorithm's flatten_meeting property to flatten the trajectory of the etr
        //  at the outer tail as it can get erratic (it drops after it reaches the max altitude).

        $i = $meeting - 1;

        if ($i >= $flattenMeeting) $i = $flattenMeeting;

        $linear	= $i;
        $quadratic = $linear * $linear;
        $cubic = $linear * $linear * $linear;

        return ($interceptMean * $intercept) + ($linearMean * $linear) + ($quadraticMean * $quadratic) + ($cubicMean * $cubic);
    }
}