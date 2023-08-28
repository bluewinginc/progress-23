<?php

namespace Bluewing\Progress23\Structs;

class RaterStruct
{
    public int|null $ageGroup = null;
    public string|null $ageGroupAsString = null;
    public int $excludeFromStats = 0;

    public function toArray(): array
    {
        return [
            'ageGroup' => $this->ageGroup,
            'ageGroupAsString' => $this->ageGroupAsString,
            'excludeFromStats' => $this->excludeFromStats
        ];
    }
}