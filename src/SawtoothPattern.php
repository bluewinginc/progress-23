<?php

namespace Bluewing\Progress23;

use Bluewing\Progress23\Structs\SawtoothPatternStruct;
use Exception;

class SawtoothPattern
{
    protected SawtoothPatternStruct|null $data = null;
    protected RatingCollection|null $ratings = null;

    const DIRECTION_CHANGES = 4;
    const POINT_CHANGE = 6;

    /**
     * @throws Exception
     */
    public function __construct(RatingCollection $ratings)
    {
        $this->data = new SawtoothPatternStruct;

        $this->ratings = $ratings;

        $this->data->directionChanges = $this->calculateSawtoothDirectionChanges();
        $this->data->has = $this->has();
        $this->data->teeth = $this->teeth();
    }

    public function data(): SawtoothPatternStruct
    {
        return $this->data;
    }

    /**
     * @throws Exception
     */
    private function calculateSawtoothDirectionChanges(): int
    {
        // INFO: Return the number of alternating changes, using the POINT_CHANGE, in the rating scores.

        $directionChanges = 0;

        // INFO: If there are fewer than 2 ratings, there can't be any direction changes.
        if ($this->ratings->count() < 2) return 0;

        // 2019-03-12 - LOGIC CHANGE
        // The objective is to flag four (4) consecutive or non-consecutive direction changes of six (6) points or more.
        // 1.0; 7.0; 2.0; 6.0; 12.0; 18.0; 26.0; 15.0; 9.0;
        //   [1]                              [2]

        $direction = 'none';

        for ($i = 0; $i < ($this->ratings->count() - 1); $i++) {
            $value1 = ($this->ratings->item($i)->data()->score * 10)/10;
            $value2 = ($this->ratings->item($i + 1)->data()->score * 10)/10;
            $diff = abs($value2 - $value1);

            if ($diff >= $this::POINT_CHANGE) {
                if ($value2 > $value1) {
                    if ($direction === 'down' || $direction === 'none') $directionChanges += 1;

                    $direction = 'up';
                } else {
                    if ($direction === 'up' || $direction === 'none') $directionChanges += 1;

                    $direction = 'down';
                }
            }
        }

        return $directionChanges;
    }

    private function has(): bool
    {
        // INFO: Determine if a rater has a sawtooth pattern, using the DIRECTION_CHANGES constant.
        //  When the number of ratings is less than the DIRECTION_CHANGES + 1, return FALSE.

        if ($this->ratings->count() < $this::DIRECTION_CHANGES + 1) return false;

        return ($this->data->directionChanges >= $this::DIRECTION_CHANGES);
    }

    private function teeth(): int
    {
        // INFO: There must be at least one direction change, or it is automatically 0.

        if ($this->data->directionChanges < 1) return 0;

        return $this->data->directionChanges - 1;
    }
}