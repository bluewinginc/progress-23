<?php

namespace Bluewing\Progress23\Structs;

class EtrStruct
{
    public float $expectedChange = 0.0;
    public string $expectedChangeAsString = '0.00';
    public bool $met = false;
    public float $metPercent = 0.0;
    public string $metPercentAsString = '0.00';
    public bool $metPercent50 = false;
    public bool $metPercent67 = false;
    public float $value = 0.0;
    public string $valueAsString = '0.00';

    public function toArray(): array
    {
        return [
            'expectedChange' => $this->expectedChange,
            'expectedChangeAsString' => $this->expectedChangeAsString,
            'met' => $this->met,
            'metPercent' => $this->metPercent,
            'metPercentAsString' => $this->metPercentAsString,
            'metPercent50' => $this->metPercent50,
            'metPercent67' => $this->metPercent67,
            'value' => $this->value,
            'valueAsString' => $this->valueAsString
        ];
    }
}