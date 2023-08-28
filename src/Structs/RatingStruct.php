<?php

namespace Bluewing\Progress23\Structs;

class RatingStruct
{
    public int|null $id = null;
    public string|null $dateCompleted = null;
    public float $score = 0.0;
    public string $scoreAsString = '0.0';

    public function toArray(bool $justScores = false): array
    {
        if ($justScores) {
            return [
                'score' => $this->score,
                'scoreAsString' => $this->scoreAsString,
            ];
        }

        return [
            'id' => $this->id,
            'dateCompleted' => $this->dateCompleted,
            'score' => $this->score,
            'scoreAsString' => $this->scoreAsString,
        ];
    }
}