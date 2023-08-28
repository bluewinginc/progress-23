<?php

namespace Bluewing\Progress23;

use Bluewing\Progress23\Structs\RatingStruct;
use Exception;

class Rating
{
    protected RatingStruct|null $ratingStruct = null;

    /**
     * @throws Exception
     */
    public function __construct(int|null $id = null, string|null $dateCompleted = null, float $score = 0.0)
    {
        $this->ratingStruct = new RatingStruct;

        $this->ratingStruct->id = $id;
        $this->ratingStruct->dateCompleted = $dateCompleted;
        $this->ratingStruct->score = $score;
        $this->ratingStruct->scoreAsString = number_format($score, 1);

        $this->check();
    }

    /**
     * @throws Exception
     */
    private function check(): void
    {
        $msg = 'Invalid score.  It must be between 0.0 and 40.0.';

        if ($this->ratingStruct->score < 0 || $this->ratingStruct->score > 40) throw new Exception($msg);
    }

    public function data(): RatingStruct
    {
        return $this->ratingStruct;
    }

    /**
     * @throws Exception
     */
    public function fromArray(array $data): void
    {
        // INFO: Populates the rating struct from an array of data.
        //  The array must contain valid data, or it will fail.

        $msg = 'The id key is required.';

        if (! array_key_exists('id', $data)) throw new Exception($msg);

        $msg = 'The dateCompleted key is required.';

        if (! array_key_exists('dateCompleted', $data)) throw new Exception($msg);

        $msg = 'The score key is required.';

        if (! array_key_exists('score', $data)) throw new Exception($msg);

        $id = $data['id'];
        $dateCompleted = $data['dateCompleted'];
        $score = $data['score'];

        $this->ratingStruct->id = is_int($id) ? $id : null;
        $this->ratingStruct->dateCompleted = is_string($dateCompleted) ? $dateCompleted : null;
        $this->ratingStruct->score = is_float($score) ? $score : -1;
        $this->ratingStruct->scoreAsString = number_format($score , 1);

        $this->check();
    }
}