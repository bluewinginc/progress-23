<?php

namespace Bluewing\Progress23\Tests\Unit;

use Bluewing\Algorithms23\BonAlgorithmManager;
use Bluewing\Progress23\RatingCollection;
use Bluewing\Progress23\Structs\ClinicalCutoffStruct;
use Bluewing\Progress23\Structs\SawtoothPatternStruct;
use Bluewing\Progress23\Structs\ValidityIndicatorsStruct;
use Bluewing\Progress23\ValidityIndicators;
use Exception;
use PHPUnit\Framework\TestCase;

class ValidityIndicatorsTest extends TestCase
{
    const ADOLESCENT = 1;
    const ADULT = 2;
    const CHILD = 3;

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_an_instance_of_the_specified_class()
    {
        $age = self::ADOLESCENT;

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);

        $manager = new BonAlgorithmManager;

        $algorithm = $manager($age,$ratings->count());
        //$algorithmShortTerm = $manager->getFor($age, 0);

        $validityIndicators = new ValidityIndicators($algorithm, $ratings);

        $this->assertInstanceOf(ValidityIndicators::class, $validityIndicators);
    }

    /**
     * @test
     * @throws Exception
     */
    public function calling_the_data_method_returns_an_instance_of_the_specified_class()
    {
        $age = self::ADOLESCENT;

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);

        $manager = new BonAlgorithmManager;

        $algorithm = $manager($age,$ratings->count());
        //$algorithmShortTerm = $manager->getFor($age, 0);

        $validityIndicators = new ValidityIndicators($algorithm, $ratings);

        $this->assertInstanceOf(ValidityIndicatorsStruct::class, $validityIndicators->data());
    }

    /**
     * @test
     * @throws Exception
     */
    public function calling_the_data_method_with_ratings_returns_accurate_data()
    {
        $age = self::ADOLESCENT;

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);

        $manager = new BonAlgorithmManager;

        $algorithm = $manager($age,$ratings->count());
        //$algorithmShortTerm = $manager->getFor($age, 0);

        $validityIndicators = new ValidityIndicators($algorithm, $ratings);

        $data = $validityIndicators->data();

        $this->assertInstanceOf(ValidityIndicatorsStruct::class, $data);
        $this->assertInstanceOf(ClinicalCutoffStruct::class, $data->clinicalCutoff);
        $this->assertInstanceOf(SawtoothPatternStruct::class, $data->sawtoothPattern);
        $this->assertFalse($data->firstRatingAbove32);
        $this->assertFalse($data->zeroOrOneMeetings);
    }

    /**
     * @test
     * @throws Exception
     */
    public function calling_the_data_method_with_no_ratings_returns_accurate_data()
    {
        $age = self::ADOLESCENT;

        $ratings = new RatingCollection;

        $manager = new BonAlgorithmManager;

        $algorithm = $manager($age,$ratings->count());
        //$algorithmShortTerm = $manager->getFor($age, 0);

        $validityIndicators = new ValidityIndicators($algorithm, $ratings);

        $data = $validityIndicators->data();

        $this->assertInstanceOf(ValidityIndicatorsStruct::class, $data);
        $this->assertInstanceOf(ClinicalCutoffStruct::class, $data->clinicalCutoff);
        $this->assertInstanceOf(SawtoothPatternStruct::class, $data->sawtoothPattern);
        $this->assertFalse($data->firstRatingAbove32);
        $this->assertTrue($data->zeroOrOneMeetings);
    }

    /**
     * @test
     * @throws Exception
     */
    public function calling_the_data_method_with_first_rating_over_32_returns_accurate_data()
    {
        $age = self::ADOLESCENT;

        $ratings = new RatingCollection;

        $ratings->add(1, '', 38.0);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);

        $manager = new BonAlgorithmManager;

        $algorithm = $manager($age,$ratings->count());
        //$algorithmShortTerm = $manager->getFor($age, 0);

        $validityIndicators = new ValidityIndicators($algorithm, $ratings);

        $data = $validityIndicators->data();

        $this->assertInstanceOf(ValidityIndicatorsStruct::class, $data);
        $this->assertInstanceOf(ClinicalCutoffStruct::class, $data->clinicalCutoff);
        $this->assertInstanceOf(SawtoothPatternStruct::class, $data->sawtoothPattern);
        $this->assertTrue($data->firstRatingAbove32);
        $this->assertFalse($data->zeroOrOneMeetings);
    }
}