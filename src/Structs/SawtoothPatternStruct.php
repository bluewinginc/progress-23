<?php

namespace Bluewing\Progress23\Structs;

class SawtoothPatternStruct
{
    public int $directionChanges = 0;
    public bool $has = false;
    public int $teeth = 0;

    public function toArray(): array
    {
        return [
            'directionChanges' => $this->directionChanges,
            'has' => $this->has,
            'teeth' => $this->teeth
        ];
    }
}