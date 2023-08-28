<?php

namespace Bluewing\Progress23;

use Bluewing\Progress23\Structs\RaterStruct;
use Exception;

class Rater
{
    protected RaterStruct|null $raterStruct = null;

    /**
     * @throws Exception
     */
    public function __construct(int $ageGroup, int $excludeFromStats = 0)
    {
        $msg = 'Invalid rater age group.  It must be set to 1, 2, or 3.';

        if ($ageGroup < 1 || $ageGroup > 3) throw new Exception($msg);

        $msg = 'Invalid excludeFromStats value.  It must be set to 0 or 1.';

        if ($excludeFromStats < 0 || $excludeFromStats > 1) throw new Exception($msg);

        $this->raterStruct = new RaterStruct;

        $this->raterStruct->ageGroup = $ageGroup;

        if ($ageGroup === 1) {
            $this->raterStruct->ageGroupAsString = 'Adolescent';
        } elseif ($ageGroup === 2) {
            $this->raterStruct->ageGroupAsString = 'Adult';
        } elseif ($ageGroup === 3) {
            $this->raterStruct->ageGroupAsString = 'Child';
        }

        $this->raterStruct->excludeFromStats = $excludeFromStats;
    }

    public function data(): RaterStruct
    {
        return $this->raterStruct;
    }
}