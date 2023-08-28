<?php

namespace Bluewing\Progress23;

use Bluewing\Progress23\Structs\ExclusionsStruct;

class Exclusions
{
    protected ExclusionsStruct|null $data = null;

    public function __construct(bool $userExcluded, bool $firstRatingAbove32, bool $zeroOrOneMeetings)
    {
        $this->data = new ExclusionsStruct;

        $this->data->userExcluded = $userExcluded;
        $this->data->firstRatingAbove32 = $firstRatingAbove32;
        $this->data->zeroOrOneMeetings = $zeroOrOneMeetings;

        $this->data->excluded = $userExcluded || $firstRatingAbove32 || $zeroOrOneMeetings;
        $this->data->included = !$this->data->excluded;
    }

    public function data(): ExclusionsStruct
    {
        return $this->data;
    }
}