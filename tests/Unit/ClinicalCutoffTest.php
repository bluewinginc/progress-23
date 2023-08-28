<?php

namespace Bluewing\Progress23\Tests\Unit;

use Bluewing\Algorithms23\BonAlgorithm;
use Bluewing\Algorithms23\BonAlgorithmManager;
use Bluewing\Algorithms23\LongTerm\LongTermAdolescent;
use Bluewing\Algorithms23\LongTerm\LongTermAdult;
use Bluewing\Algorithms23\ShortTerm\ShortTermAdolescent;
use Bluewing\Algorithms23\ShortTerm\ShortTermAdult;
use Bluewing\Progress23\ClinicalCutoff;
use Bluewing\Progress23\RatingCollection;
use Exception;
use PHPUnit\Framework\TestCase;

class ClinicalCutoffTest extends TestCase
{
    const ADOLESCENT = 1;
    const ADULT = 2;
    const CHILD = 3;

    /** @test */
    public function return_data_when_using_st_adolescent_algorithm_and_no_rating_scores()
    {
        $ratings = new RatingCollection;

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADOLESCENT, $ratings->count());
        $this->assertInstanceOf(BonAlgorithm::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(28.0, $data->value);
        $this->assertNull($data->firstRatingScore);
        $this->assertFalse($data->isAbove);
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_false_using_st_adolescent_algorithm_and_first_rating_is_less_than_cc_value()
    {
        $ratings = new RatingCollection;

        $ratings->add(0, '2020-01-16', 14.0);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADOLESCENT, $ratings->count());
        $this->assertInstanceOf(BonAlgorithm::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(28.0, $data->value);
        $this->assertEquals(14.0, $data->firstRatingScore);
        $this->assertFalse($data->isAbove);
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_false_using_st_adolescent_algorithm_when_first_rating_equals_cc_value()
    {
        $ratings = new RatingCollection;

        $ratings->add(0, '2020-01-16', 28.0);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADOLESCENT, $ratings->count());
        $this->assertInstanceOf(BonAlgorithm::class, $algorithm);
        $this->assertInstanceOf(ShortTermAdolescent::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(28.0, $data->value);
        $this->assertEquals(28.0, $data->firstRatingScore);
        $this->assertFalse($data->isAbove);
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_false_using_lt_adolescent_algorithm_when_first_rating_equals_cc_value()
    {
        $ratings = new RatingCollection;

        $ratings->add(0, '2020-01-16', 28.0);
        $ratings->add(0, '2020-01-16', 19.0);
        $ratings->add(0, '2020-01-16', 20.0);
        $ratings->add(0, '2020-01-16', 21.0);
        $ratings->add(0, '2020-01-16', 22.0);
        $ratings->add(0, '2020-01-16', 23.0);
        $ratings->add(0, '2020-01-16', 35.0);
        $ratings->add(0, '2020-01-16', 36.0);
        $ratings->add(0, '2020-01-16', 37.0);
        $ratings->add(0, '2020-01-16', 38.0);
        $ratings->add(0, '2020-01-16', 38.2);
        $ratings->add(0, '2020-01-16', 38.4);
        $ratings->add(0, '2020-01-16', 38.6);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADOLESCENT, $ratings->count());
        $this->assertInstanceOf(BonAlgorithm::class, $algorithm);
        $this->assertInstanceOf(LongTermAdolescent::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(28.0, $data->value);
        $this->assertEquals(28.0, $data->firstRatingScore);
        $this->assertFalse($data->isAbove);
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_true_using_adolescent_algorithm_when_first_rating_is_greater_than_cc_value()
    {
        $ratings = new RatingCollection;

        $ratings->add(0, '2020-01-16', 28.1);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADOLESCENT, $ratings->count());
        $this->assertInstanceOf(ShortTermAdolescent::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(28.0, $data->value);
        $this->assertEquals(28.1, $data->firstRatingScore);
        $this->assertTrue($data->isAbove);

        $ratings->add(0, '2020-01-16', 19.0);
        $ratings->add(0, '2020-01-16', 20.0);
        $ratings->add(0, '2020-01-16', 21.0);
        $ratings->add(0, '2020-01-16', 22.0);
        $ratings->add(0, '2020-01-16', 23.0);
        $ratings->add(0, '2020-01-16', 35.0);
        $ratings->add(0, '2020-01-16', 36.0);
        $ratings->add(0, '2020-01-16', 37.0);
        $ratings->add(0, '2020-01-16', 38.0);
        $ratings->add(0, '2020-01-16', 38.2);
        $ratings->add(0, '2020-01-16', 38.4);
        $ratings->add(0, '2020-01-16', 38.6);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADOLESCENT, $ratings->count());
        $this->assertInstanceOf(LongTermAdolescent::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(28.0, $data->value);
        $this->assertEquals(28.1, $data->firstRatingScore);
        $this->assertTrue($data->isAbove);
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_false_using_adult_algorithm_when_first_rating_equals_cc_value()
    {
        $ratings = new RatingCollection;

        $ratings->add(0, '2020-01-16', 25.0);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADULT, $ratings->count());
        $this->assertInstanceOf(ShortTermAdult::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(25.0, $data->value);
        $this->assertEquals(25.0, $data->firstRatingScore);
        $this->assertFalse($data->isAbove);

        $ratings->add(0, '2020-01-16', 19.0);
        $ratings->add(0, '2020-01-16', 20.0);
        $ratings->add(0, '2020-01-16', 21.0);
        $ratings->add(0, '2020-01-16', 22.0);
        $ratings->add(0, '2020-01-16', 23.0);
        $ratings->add(0, '2020-01-16', 35.0);
        $ratings->add(0, '2020-01-16', 36.0);
        $ratings->add(0, '2020-01-16', 37.0);
        $ratings->add(0, '2020-01-16', 38.0);
        $ratings->add(0, '2020-01-16', 38.2);
        $ratings->add(0, '2020-01-16', 38.3);
        $ratings->add(0, '2020-01-16', 38.4);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADULT, $ratings->count());
        $this->assertInstanceOf(LongTermAdult::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(25.0, $data->value);
        $this->assertEquals(25.0, $data->firstRatingScore);
        $this->assertFalse($data->isAbove);
    }

    /**
     * @test
     * @throws Exception
     */
    public function is_true_using_adult_algorithms_when_first_rating_is_greater_than_cc_value()
    {
        $ratings = new RatingCollection;

        $ratings->add(0, '2020-01-16', 25.1);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADULT, $ratings->count());
        $this->assertInstanceOf(ShortTermAdult::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(25.0, $data->value);
        $this->assertEquals(25.1, $data->firstRatingScore);
        $this->assertTrue($data->isAbove);

        $ratings->add(0, '2020-01-16', 19.0);
        $ratings->add(0, '2020-01-16', 20.0);
        $ratings->add(0, '2020-01-16', 21.0);
        $ratings->add(0, '2020-01-16', 22.0);
        $ratings->add(0, '2020-01-16', 23.0);
        $ratings->add(0, '2020-01-16', 35.0);
        $ratings->add(0, '2020-01-16', 36.0);
        $ratings->add(0, '2020-01-16', 37.0);
        $ratings->add(0, '2020-01-16', 38.0);
        $ratings->add(0, '2020-01-16', 38.2);
        $ratings->add(0, '2020-01-16', 38.3);
        $ratings->add(0, '2020-01-16', 38.4);

        $manager = new BonAlgorithmManager;
        $algorithm = $manager($this::ADULT, $ratings->count());
        $this->assertInstanceOf(LongTermAdult::class, $algorithm);

        $clinicalCutoff = new ClinicalCutoff($algorithm, $ratings);
        $this->assertInstanceOf(ClinicalCutoff::class, $clinicalCutoff);

        $data = $clinicalCutoff->data();

        $this->assertEquals(25.0, $data->value);
        $this->assertEquals(25.1, $data->firstRatingScore);
        $this->assertTrue($data->isAbove);
    }
}