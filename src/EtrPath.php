<?php

namespace Bluewing\Progress23;

use Bluewing\Algorithms23\BonAlgorithmManager;
use Bluewing\Algorithms23\BonAlgorithm;
use Bluewing\Progress23\Structs\EtrPathStruct;
use Exception;

class EtrPath
{
    protected EtrPathStruct|null $data = null;
    protected BonAlgorithm|null $algorithm = null;

    /**
     * @throws Exception
     */
    public function __construct(Rater $rater, Rating $firstRating, int $meetings)
    {
        $msg = 'There meetings argument must be greater than 0.';

        if ($meetings <= 0) throw new Exception($msg);

        $this->data = new EtrPathStruct;

        $this->data->rater = $rater;
        $this->data->firstRating = $firstRating;
        $this->data->meetings = $meetings;

        $this->calculateAndPopulateData();
    }

    private function calculateAndPopulateData(): void
    {
        $manager = new BonAlgorithmManager;

        $this->algorithm = $manager($this->data->rater->data()->ageGroup, $this->data->meetings);

        // INFO: Get the expected treatment response (etr) for each meeting.
        $flattenMeeting = $this->algorithm->flattenMeeting;
        $maxMeetings = $this->algorithm->maxMeetings;
        $centeredAt20 = $this->data->firstRating->data()->score - 20;
        $interceptMean = $this->algorithm->interceptMean + ($this->algorithm->intake * $centeredAt20);
        $linearMean = $this->algorithm->linearMean + ($this->algorithm->linearByIntake * $centeredAt20);
        $quadraticMean = $this->algorithm->quadraticMean + ($this->algorithm->quadraticByIntake * $centeredAt20);
        $cubicMean = $this->algorithm->cubicMean + ($this->algorithm->cubicByIntake * $centeredAt20);
        $intercept = 1;

        // INFO: Make sure that the entire etr is always presented.
        if ($this->data->meetings < $maxMeetings) {
            $this->data->meetings = $maxMeetings;
        }

        // INFO: Add the intake session.
        $value = $this->data->firstRating->data()->score;
        $this->data->values[] = $value;
        $this->data->valuesAsString[] = number_format($value, 1);

        // INFO: Add the remaining values.
        for ($i = 1; $i < $this->data->meetings; $i++) {
            $meeting = $i;

            if ($meeting >= $flattenMeeting) {
                $meeting = $flattenMeeting;
            }

            $linear	= $meeting;
            $quadratic = $linear * $linear;
            $cubic = $linear * $linear * $linear;
            $value = ($interceptMean * $intercept) + ($linearMean * $linear) + ($quadraticMean * $quadratic) + ($cubicMean * $cubic);

            $roundedValue = round($value, 1);
            $this->data->values[] = $roundedValue;
            $this->data->valuesAsString[] = number_format($roundedValue, 1);
        }
    }

    public function data(): EtrPathStruct
    {
        return $this->data;
    }
}