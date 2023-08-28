<?php

namespace Bluewing\Progress23;

use Bluewing\Algorithms23\BonAlgorithmManager;
use Bluewing\Progress23\Structs\AlgorithmStruct;
use Bluewing\Progress23\Structs\ProgressStruct;
use Exception;

class Progress
{
    protected ProgressStruct|null $progress = null;
    protected Rater|null $rater = null;
    protected RatingCollection|null $ratings = null;

    /**
     * @throws Exception
     */
    public function __construct(Rater $rater, RatingCollection $ratings)
    {
        $this->progress = new ProgressStruct;

        $this->rater = $rater;
        $this->ratings = $ratings;

        $this->progress->rater = $rater;
        $this->progress->ratings = $ratings;

        $this->progress->ratingsCount = $ratings->count();

        $this->progress->firstRating = $this->progress->ratings->first();

        if (is_null($this->progress->firstRating)) $this->progress->firstRating = null;

        $msg = 'The first rating score is invalid. It must be between 0.0 and 40.0.';

        if ($this->progress->firstRating->data()->score < 0 || $this->progress->firstRating->data()->score > 40) throw new Exception($msg);

        $this->progress->lastRating = $this->progress->ratings->last();

        if (is_null($this->progress->lastRating)) $this->progress->lastRating = null;

        $msg = 'The last rating score is invalid. It must be between 0.0 and 40.0.';

        if ($this->progress->lastRating->data()->score < 0 || $this->progress->lastRating->data()->score > 40) throw new Exception($msg);

        // INFO: Only update the rating change value if there is one or more ratings.
        if ($this->progress->ratings->count() > 0) {
            $this->progress->ratingChange = round($this->progress->lastRating->data()->score - $this->progress->firstRating->data()->score, 1);
            $this->progress->ratingChangeAsString = number_format($this->progress->ratingChange, 1);
        }

        // INFO: Algorithms
        $manager = new BonAlgorithmManager;

        $algorithm = $manager($this->progress->rater->data()->ageGroup, $this->progress->ratings->count());
        $algorithmShortTerm = $manager($this->progress->rater->data()->ageGroup, 0);

        $algorithmStruct = new AlgorithmStruct;
        $algorithmStruct->version = $algorithm->info;
        $algorithmStruct->clinicalCutoff = $algorithm->clinicalCutoff;
        $algorithmStruct->clinicalCutoffAsString = number_format($algorithm->clinicalCutoff, 1);
        $algorithmStruct->reliableChangeIndex = $algorithm->reliableChangeIndex;
        $algorithmStruct->reliableChangeIndexAsString = number_format($algorithm->reliableChangeIndex, 2);
        $algorithmStruct->standardDeviation = $algorithm->standardDeviation;
        $algorithmStruct->standardDeviationAsString = number_format($algorithm->standardDeviation, 2);
        $algorithmStruct->srsClinicalCutoff = 36;
        $algorithmStruct->srsClinicalCutoffAsString = number_format(36, 1);
        $this->progress->algorithm = $algorithmStruct;

        // INFO: AlgorithmShortTerm
        $algorithmStruct = new AlgorithmStruct;
        $algorithmStruct->version = $algorithmShortTerm->info;
        $algorithmStruct->clinicalCutoff = $algorithmShortTerm->clinicalCutoff;
        $algorithmStruct->clinicalCutoffAsString = number_format($algorithmShortTerm->clinicalCutoff, 1);
        $algorithmStruct->reliableChangeIndex = $algorithmShortTerm->reliableChangeIndex;
        $algorithmStruct->reliableChangeIndexAsString = number_format($algorithmShortTerm->reliableChangeIndex, 2);
        $algorithmStruct->standardDeviation = $algorithmShortTerm->standardDeviation;
        $algorithmStruct->standardDeviationAsString = number_format($algorithmShortTerm->standardDeviation, 2);
        $algorithmStruct->srsClinicalCutoff = 36;
        $algorithmStruct->srsClinicalCutoffAsString = number_format(36, 1);
        $this->progress->algorithmShortTerm = $algorithmStruct;

        $this->progress->effectSize = round($this->progress->ratingChange / $algorithm->standardDeviation, 2);
        $this->progress->effectSizeAsString = number_format($this->progress->effectSize, 2);

        // INFO: ETR Meeting Target
        $etrMtgTarget = new EtrMtgTarget($this->progress->rater, $this->progress->ratings);
        $this->progress->etrMtgTarget = $etrMtgTarget->data();

        // INFO: ETR Target
        $etrTarget = new EtrTarget($this->progress->rater, $this->progress->ratings);
        $this->progress->etrTarget = $etrTarget->data();

        // INFO: Validity Indicators
        $validityIndicators = new ValidityIndicators($algorithm, $this->progress->ratings);
        $this->progress->validityIndicators = $validityIndicators->data();

        // INFO: Milestones
        $milestones = new Milestones($algorithm, $this->progress->ratings);
        $this->progress->milestones = $milestones->data();

        // INFO: Exclusions
        $exclusions = new Exclusions($this->progress->rater->data()->excludeFromStats === 1, $this->progress->validityIndicators->firstRatingAbove32, $this->progress->validityIndicators->zeroOrOneMeetings);
        $this->progress->exclusions = $exclusions->data();
    }

    public function data(): ProgressStruct
    {
        return $this->progress;
    }
}