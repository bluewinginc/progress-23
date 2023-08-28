<?php

namespace Bluewing\Progress23\Tests\Unit;

use Bluewing\Progress23\EtrPath;
use Bluewing\Progress23\Rater;
use Bluewing\Progress23\Rating;
use Exception;
use PHPUnit\Framework\TestCase;

class EtrPathTest extends TestCase
{
    const ADOLESCENT = 1;
    const ADULT = 2;
    const CHILD = 3;

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_etr_values_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $firstRating = new Rating(score: 12.1);

        $etrPath = new EtrPath($rater, $firstRating, 3);

        $data = $etrPath->data();

        $this->assertCount(12, $data->values);
        $this->assertEquals(12.1, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_etr_values_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $firstRating = new Rating(score: 12.1);

        $etrPath = new EtrPath($rater, $firstRating, 3);

        $data = $etrPath->data();

        $this->assertCount(12, $data->values);
        $this->assertEquals(12.1, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_etr_values_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);

        $firstRating = new Rating(score: 16.1);

        $etrPath = new EtrPath($rater, $firstRating,16);

        $data = $etrPath->data();

        $this->assertCount(25, $data->values);
        $this->assertEquals(16.1, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_etr_values_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);

        $firstRating = new Rating(score: 16.1);

        $etrPath = new EtrPath($rater, $firstRating,16);

        $data = $etrPath->data();

        $this->assertCount(25, $data->values);
        $this->assertEquals(16.1, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_exception_when_there_are_no_meetings_with_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);

        $firstRating = new Rating(score: 16.1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There meetings argument must be greater than 0.');

        new EtrPath($rater, $firstRating, 0);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_exception_when_there_are_no_meetings_with_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);

        $firstRating = new Rating(score: 16.1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There meetings argument must be greater than 0.');

        new EtrPath($rater, $firstRating, 0);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_exception_when_there_are_fewer_than_0_meetings_with_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);

        $firstRating = new Rating(score: 16.1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There meetings argument must be greater than 0.');

        new EtrPath($rater, $firstRating, -1);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_throws_exception_when_there_are_fewer_than_0_meetings_with_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);

        $firstRating = new Rating(score: 16.1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There meetings argument must be greater than 0.');

        new EtrPath($rater, $firstRating, -1);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_12_items_using_st_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 3);

        $data = $etrPath->data();

        $this->assertCount(12, $data->values);
        $this->assertEquals(19.2, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_12_items_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 3);

        $data = $etrPath->data();

        $this->assertCount(12, $data->values);
        $this->assertEquals(19.2, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_25_items_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT, 1);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 16);

        $data = $etrPath->data();

        $this->assertCount(25, $data->values);
        $this->assertEquals(19.2, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_25_items_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT, 1);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 16);

        $data = $etrPath->data();

        $this->assertCount(25, $data->values);
        $this->assertEquals(19.2, $data->values[0]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_array_contains_values_using_st_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 1);

        $data = $etrPath->data();

        $this->assertCount(12, $data->values);
        $this->assertEquals(23.0, $data->values[1]);
        $this->assertEquals(28.1, $data->values[7]);
        $this->assertEquals(28.9, $data->values[11]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_array_contains_values_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 1);

        $data = $etrPath->data();

        $this->assertCount(12, $data->values);
        $this->assertEquals(22.5, $data->values[1]);
        $this->assertEquals(27.5, $data->values[7]);
        $this->assertEquals(28.3, $data->values[11]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_array_contains_values_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 16);

        $data = $etrPath->data();

        $this->assertCount(25, $data->values);
        $this->assertEquals(22.0, $data->values[1]);
        $this->assertEquals(27.2, $data->values[7]);
        $this->assertEquals(28.1, $data->values[11]);
        $this->assertEquals(29.4, $data->values[21]);
        $this->assertEquals(29.9, $data->values[22]);
        $this->assertEquals(29.9, $data->values[23]);
        $this->assertEquals(29.9, $data->values[24]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_array_contains_values_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);

        $firstRating = new Rating(score: 19.2);

        $etrPath = new EtrPath($rater, $firstRating, 16);

        $data = $etrPath->data();

        $this->assertCount(25, $data->values);
        $this->assertEquals(21.2, $data->values[1]);
        $this->assertEquals(25.7, $data->values[7]);
        $this->assertEquals(26.7, $data->values[11]);
        $this->assertEquals(27.9, $data->values[21]);
        $this->assertEquals(28.3, $data->values[22]);
        $this->assertEquals(28.3, $data->values[23]);
        $this->assertEquals(28.3, $data->values[24]);
    }
}