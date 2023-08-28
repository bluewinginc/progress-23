<?php

namespace Bluewing\Progress23;

use Exception;

class RatingCollection
{
    private array $items = [];
    private bool $readOnly = false;

    public function __construct() {}

    /**
     * @throws Exception
     */
    public function add(int|null $id = null, string|null $dateCompleted = null, float $score = 0.0): void
    {
        if (! $this->readOnly) {
            $this->items[] = new Rating($id, $dateCompleted, $score);
        }
    }

    /**
     * @throws Exception
     */
    public function addItem(array $item): void
    {
        // INFO: Add a rating as an array item.
        //  The item shape: ['id' => int|null, 'dateCompleted' => string|null, 'score' => float]
        //  Example of an array item: ['id' => 1, 'dateCompleted' => '2021-02-28', 'score' => 1.2]

        if (! $this->readOnly) {
            $rating = new Rating();
            $rating->fromArray($item);
            $this->addRating($rating);
        }
    }

    public function addRating(Rating $rating): void
    {
        if (! $this->readOnly) $this->items[] = $rating;
    }

    /**
     * @throws Exception
     */
    public function addRatings(array $items): void
    {
        // INFO: Add an array of an array of rating props to the collection.
        //  The array item shape: ['id' => int|null, 'dateCompleted' => string|null, 'score' => float]
        //  Example of an array item: ['id' => 1, 'dateCompleted' => '2021-02-28', 'score' => 1.2]
        if (! $this->readOnly) {

            /* @var array $item */
            foreach($items as $item) {
                $rating = new Rating();
                $rating->fromArray($item);
                $this->addRating($rating);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function addScores(array $scores): void
    {
        if (! $this->readOnly) {
            /* @var float $score */
            foreach($scores as $score) {
                $this->add(score: $score);
            }
        }
    }

    public function count(): int
    {
        return count($this->items);
    }

   public function first(): ?Rating
    {
        if ($this->count() > 0) return $this->items[0];

        return null;
    }

    /**
     * @throws Exception
     */
    private function indexInBounds(int $index): void
    {
        $msg = 'The index is invalid.  There are no items in the collection.';

        if ($this->count() === 0) throw new Exception($msg);

        $msg = 'The index is invalid.  The lower bound of the index is 0.';

        if ($index < 0) throw new Exception($msg);

        $msg = 'The index is invalid.  The upper bound of the index is count() - 1.';

        if ($index > ($this->count() - 1)) {
            throw new Exception($msg);
        }
    }

    /** @noinspection PhpUnused */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @throws Exception
     */
    public function item(int $index): Rating
    {
        $this->indexInBounds($index);

        return $this->items[$index];
    }

   public function items(bool $asItemArray = false, bool $justScores = false): array
    {
        if ($asItemArray) {
            if ($this->count() === 0) {
                return [];
            } else {
                $items = [];
                /** @var Rating $item */
                foreach ($this->items as $item) {
                    $items[] = $item->data()->toArray($justScores);
                }

                return $items;
            }
        }

        return $this->items;
    }

    public function last(): ?Rating
    {
        if ($this->count() > 0) {
            $lastIndex = $this->count() - 1;

            return $this->items[$lastIndex];
        }

        return null;
    }

    /**
     * @noinspection PhpUnused
     */
    public function makeReadOnly(): void
    {
        // INFO: Items will not be able to be added or removed from the collection.

        if (! $this->readOnly) $this->readOnly = true;
    }

    public function remove(): RatingCollection
    {
        if ($this->readOnly) return $this;

        $this->items = [];

        return $this;
    }

    /**
     * @throws Exception
     */
    public function removeAt(int $index): RatingCollection
    {
        // INFO: Remove an item from the collection, at the specified index, reindex the items, and return the collection.

        if ($this->readOnly) return $this;

        $this->indexInBounds($index);

        unset($this->items[$index]);

        $this->items = array_values($this->items);

        return $this;
    }

    public function scores(): array
    {
        $scores = [];

        /* @var Rating $item */
        foreach($this->items as $item) {
            $scores[] = $item->data()->score;
        }

        return $scores;
    }
}