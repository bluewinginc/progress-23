<?php

namespace Bluewing\Progress23\Structs;

class MilestonesStruct
{
    public bool $cscMet = false;
    public bool $rcMet = false;
    public bool $rcOrCscMet = false;

    public function toArray(): array
    {
        return [
            'cscMet' => $this->cscMet,
            'rcMet' => $this->rcMet,
            'rcOrCscMet' => $this->rcOrCscMet
        ];
    }
}