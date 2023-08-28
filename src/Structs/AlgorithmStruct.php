<?php

namespace Bluewing\Progress23\Structs;

class AlgorithmStruct
{
    public string|null $version = null;
    public float $clinicalCutoff = 0.0;
    public string|null $clinicalCutoffAsString = '0.0';
    public float $reliableChangeIndex = 0.0;
    public string|null $reliableChangeIndexAsString = '0.00';
    public float $standardDeviation = 0.0;
    public string|null $standardDeviationAsString = '0.00';
    public float $srsClinicalCutoff = 0.0;
    public string|null $srsClinicalCutoffAsString = '0.0';

    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'clinicalCutoff' => $this->clinicalCutoff,
            'clinicalCutoffAsString' => $this->clinicalCutoffAsString,
            'reliableChangeIndex' => $this->reliableChangeIndex,
            'reliableChangeIndexAsString' => $this->reliableChangeIndexAsString,
            'standardDeviation' => $this->standardDeviation,
            'standardDeviationAsString' => $this->standardDeviationAsString,
            'srsClinicalCutoff' => $this->srsClinicalCutoff,
            'srsClinicalCutoffAsString' => $this->srsClinicalCutoffAsString
        ];
    }
}