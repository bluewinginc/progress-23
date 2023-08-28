<?php

namespace Bluewing\Progress23\Structs;

use Bluewing\Progress23\Rater;
use Bluewing\Progress23\Rating;

class EtrPathStruct
{
    public Rater|null $rater = null;
    public Rating|null $firstRating = null;
    public int $meetings = 0;
    public array $values = [];
    public array $valuesAsString = [];

    public function toArray(): array
    {
        return [
            'rater' => $this->rater->data()->toArray(),
            'firstRating' => $this->firstRating->data()->toArray(),
            'meetings' => $this->meetings,
            'values' => $this->values,
            'valuesAsString' => $this->valuesAsString
        ];
    }
}