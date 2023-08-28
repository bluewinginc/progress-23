<?php

namespace Bluewing\Progress23\Tests\Unit;

use Bluewing\Progress23\Rating;
use Bluewing\Progress23\Structs\RatingStruct;
use Exception;
use PHPUnit\Framework\TestCase;

class RatingTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_a_rating_struct_with_no_arguments()
    {
        $rating = new Rating();
        $this->assertInstanceOf(RatingStruct::class, $rating->data());
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_an_instance_of_a_rating_with_valid_data()
    {
        $rating = new Rating(1, '2021-01-02', 9.2);
        $this->assertInstanceOf(Rating::class, $rating);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_an_instance_of_a_rating_struct_with_valid_data()
    {
        $rating = new Rating(1, '2021-01-02', 9.2);
        $this->assertInstanceOf(RatingStruct::class, $rating->data());

        $rating = new Rating(score: 9.2);
        $this->assertInstanceOf(RatingStruct::class, $rating->data());
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_an_exception_when_passing_an_invalid_score()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid score.  It must be between 0.0 and 40.0.');

        new Rating(1, '2021-01-02', -0.1);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_populates_a_rating_struct_from_a_valid_array()
    {
        $rating = new Rating();

        $rating->fromArray(['id' => 1, 'dateCompleted' => '2021-01-02', 'score' => 9.2]);

        $this->assertInstanceOf(RatingStruct::class, $rating->data());
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_an_exception_when_passing_an_array_without_an_id_key()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The id key is required.');

        $rating = new Rating();

        $rating->fromArray(['dateCompleted' => '2021-01-02', 'score' => 9.2]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_an_exception_when_passing_an_array_without_a_dateCompleted_key()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The dateCompleted key is required.');

        $rating = new Rating();

        $rating->fromArray(['id' => 0, 'score' => 9.2]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_an_exception_when_passing_an_array_without_a_score_key()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The score key is required.');

        $rating = new Rating();

        $rating->fromArray(['id' => 0, 'dateCompleted' => null]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_an_exception_when_passing_an_array_containing_an_invalid_score()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid score.  It must be between 0.0 and 40.0.');

        $rating = new Rating();

        $rating->fromArray(['id' => 1, 'dateCompleted' => '2021-01-02', 'score' => -0.1]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_a_fully_populated_array_when_the_just_scores_argument_is_false()
    {
        $rating = new Rating(1, '2021-01-02', 10.2);
        $array = $rating->data()->toArray();

        $this->assertIsArray($rating->data()->toArray());
        $this->assertEquals(1, $array['id']);
        $this->assertEquals('2021-01-02', $array['dateCompleted']);
        $this->assertEquals(10.2, $array['score']);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_an_array_of_scores_when_the_just_scores_argument_is_true()
    {
        $rating = new Rating(1, '2021-01-02', 10.2);
        $array = $rating->data()->toArray(true);

        $this->assertIsArray($rating->data()->toArray(true));
        $this->assertEquals(10.2, $array['score']);
        $this->assertEquals("10.2", $array['scoreAsString']);
    }
}