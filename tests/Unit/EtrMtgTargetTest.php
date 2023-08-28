<?php

namespace Bluewing\Progress23\Tests\Unit;

use Bluewing\Progress23\EtrMtgTarget;
use Bluewing\Progress23\Rater;
use Bluewing\Progress23\RatingCollection;
use Bluewing\Progress23\Structs\EtrStruct;
use Exception;
use PHPUnit\Framework\TestCase;

class EtrMtgTargetTest extends TestCase
{
    const ADOLESCENT = 1;
    const ADULT = 2;
    const CHILD = 3;

    /**
     * @test
     * @throws Exception
     */
    public function return_expected_change_using_youth_st_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(12.94, round($data->expectedChange, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_expected_change_using_youth_lt_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 10.2);
        $ratings->add(9, '', 10.2);
        $ratings->add(10, '', 10.2);
        $ratings->add(11, '', 10.2);
        $ratings->add(12, '', 10.2);
        $ratings->add(13, '', 10.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(13.04, round($data->expectedChange, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_expected_change_using_adult_st_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(12.04, round($data->expectedChange, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_expected_change_using_adult_lt_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 10.2);
        $ratings->add(9, '', 10.2);
        $ratings->add(10, '', 10.2);
        $ratings->add(11, '', 10.2);
        $ratings->add(12, '', 10.2);
        $ratings->add(13, '', 10.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(11.31, round($data->expectedChange, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_that_etr_mtg_target_was_met_with_youth_st_13dot9_change()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertTrue($data->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_that_etr_mtg_target_was_met_with_youth_lt_13dot9_change()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertTrue($data->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_that_etr_mtg_target_was_met_with_adult_st_13dot9_change()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertTrue($data->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_that_etr_mtg_target_was_met_with_adult_lt_13dot9_change()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertTrue($data->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_met_percent_using_youth_st_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(100.0, $data->metPercent);

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(68.03, round($data->metPercent, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_met_percent_using_youth_lt_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(100.0, $data->metPercent);

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);
        $ratings->add(10, '', 21.0);
        $ratings->add(11, '', 21.0);
        $ratings->add(12, '', 21.0);
        $ratings->add(13, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(68.28, round($data->metPercent, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_met_percent_using_adult_st_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(100.0, $data->metPercent);

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(71.60, round($data->metPercent, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_met_percent_using_adult_lt_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(100.0, $data->metPercent);

        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);
        $ratings->add(10, '', 21.0);
        $ratings->add(11, '', 21.0);
        $ratings->add(12, '', 21.0);
        $ratings->add(13, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $this->assertEquals(78.71, round($data->metPercent, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_50_percent_using_youth_st_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent50;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_50_percent_using_youth_lt_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent50;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_50_percent_using_adult_st_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent50;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_50_percent_using_adult_lt_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent50;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_67_percent_using_st_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent67;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_67_percent_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);
        $ratings->add(10, '', 21.0);
        $ratings->add(11, '', 21.0);
        $ratings->add(12, '', 21.0);
        $ratings->add(13, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent67;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_67_percent_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent67;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_determine_if_etr_mtg_target_was_met_at_67_percent_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 21.0);
        $ratings->add(10, '', 21.0);
        $ratings->add(11, '', 21.0);
        $ratings->add(12, '', 21.0);
        $ratings->add(13, '', 21.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $data = $etrMtgTarget->data();

        $met = $data->metPercent67;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_value_for_meeting_5_using_youth_st_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $value = $etrMtgTarget->value(12.1, 5);

        $this->assertEquals(24.73, round($value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_value_for_meeting_17_using_youth_lt_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);
        $ratings->add(14, '', 26.0);
        $ratings->add(15, '', 26.0);
        $ratings->add(16, '', 26.0);
        $ratings->add(17, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $value = $etrMtgTarget->value(12.1, 17);

        $this->assertEquals(25.31, round($value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_value_for_meeting_5_using_adult_st_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $value = $etrMtgTarget->value(12.1, 5);

        $this->assertEquals(23.60, round($value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_etr_mtg_target_value_for_meeting_17_using_adult_lt_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 12.1);
        $ratings->add(2, '', 3.2);
        $ratings->add(3, '', 9.7);
        $ratings->add(4, '', 6.7);
        $ratings->add(5, '', 8.9);
        $ratings->add(6, '', 9.1);
        $ratings->add(7, '', 10.2);
        $ratings->add(8, '', 20.1);
        $ratings->add(9, '', 26.0);
        $ratings->add(10, '', 26.0);
        $ratings->add(11, '', 26.0);
        $ratings->add(12, '', 26.0);
        $ratings->add(13, '', 26.0);
        $ratings->add(14, '', 26.0);
        $ratings->add(15, '', 26.0);
        $ratings->add(16, '', 26.0);
        $ratings->add(17, '', 26.0);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);

        $value = $etrMtgTarget->value(12.1, 17);

        $this->assertEquals(23.75, round($value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_data_using_st_youth_algorithm_and_no_ratings()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_data_using_st_adult_algorithm_and_no_ratings()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_meeting_target_data_for_meeting_2_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(3.83, round($etrMtgTargetData->expectedChange, 2));
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(28.68, round($etrMtgTargetData->metPercent, 2));
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(23.03, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_meeting_target_data_for_meeting_14_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);
        $ratings->add(3, '', 20.3);
        $ratings->add(4, '', 20.3);
        $ratings->add(5, '', 20.3);
        $ratings->add(6, '', 20.3);
        $ratings->add(7, '', 20.3);
        $ratings->add(8, '', 20.3);
        $ratings->add(9, '', 20.3);
        $ratings->add(10, '', 20.3);
        $ratings->add(11, '', 20.3);
        $ratings->add(12, '', 20.3);
        $ratings->add(13, '', 20.3);
        $ratings->add(14, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(9.00, round($etrMtgTargetData->expectedChange, 2));
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(12.22, round($etrMtgTargetData->metPercent, 2));
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(28.20, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_meeting_target_data_for_meeting_2_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(3.31, round($etrMtgTargetData->expectedChange, 2));
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(33.28, round($etrMtgTargetData->metPercent, 2));
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(22.51, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_meeting_target_data_for_meeting_14_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);
        $ratings->add(3, '', 20.3);
        $ratings->add(4, '', 20.3);
        $ratings->add(5, '', 20.3);
        $ratings->add(6, '', 20.3);
        $ratings->add(7, '', 20.3);
        $ratings->add(8, '', 20.3);
        $ratings->add(9, '', 20.3);
        $ratings->add(10, '', 20.3);
        $ratings->add(11, '', 20.3);
        $ratings->add(12, '', 20.3);
        $ratings->add(13, '', 20.3);
        $ratings->add(14, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(7.70, round($etrMtgTargetData->expectedChange, 2));
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(14.29, round($etrMtgTargetData->metPercent, 2));
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(26.90, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_when_etr_meeting_target_is_not_met_using_st_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 22.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_when_etr_meeting_target_is_not_met_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 22.2);
        $ratings->add(3, '', 22.2);
        $ratings->add(4, '', 22.2);
        $ratings->add(5, '', 22.2);
        $ratings->add(6, '', 22.2);
        $ratings->add(7, '', 22.2);
        $ratings->add(8, '', 22.2);
        $ratings->add(9, '', 22.2);
        $ratings->add(10, '', 22.2);
        $ratings->add(11, '', 22.2);
        $ratings->add(12, '', 22.2);
        $ratings->add(13, '', 22.2);
        $ratings->add(14, '', 22.2);
        $ratings->add(15, '', 22.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_when_etr_meeting_target_is_not_met_using_st_adult_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 22.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_when_etr_meeting_target_is_not_met_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 22.2);
        $ratings->add(3, '', 22.2);
        $ratings->add(4, '', 22.2);
        $ratings->add(5, '', 22.2);
        $ratings->add(6, '', 22.2);
        $ratings->add(7, '', 22.2);
        $ratings->add(8, '', 22.2);
        $ratings->add(9, '', 22.2);
        $ratings->add(10, '', 22.2);
        $ratings->add(11, '', 22.2);
        $ratings->add(12, '', 22.2);
        $ratings->add(13, '', 22.2);
        $ratings->add(14, '', 22.2);
        $ratings->add(15, '', 22.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_when_etr_meeting_target_is_met_using_st_youth_algorithm()
    {
        $rater = new Rater($this::CHILD);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.7);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertTrue($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_when_etr_meeting_target_is_met_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.7);
        $ratings->add(3, '', 23.7);
        $ratings->add(4, '', 23.7);
        $ratings->add(5, '', 23.7);
        $ratings->add(6, '', 23.7);
        $ratings->add(7, '', 23.7);
        $ratings->add(8, '', 23.7);
        $ratings->add(9, '', 23.7);
        $ratings->add(10, '', 23.7);
        $ratings->add(11, '', 23.7);
        $ratings->add(12, '', 23.7);
        $ratings->add(13, '', 23.7);
        $ratings->add(14, '', 23.7);
        $ratings->add(15, '', 23.7);
        $ratings->add(16, '', 28.7);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertTrue($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_when_etr_meeting_target_is_met_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.2);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertTrue($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_true_when_etr_meeting_target_is_met_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.7);
        $ratings->add(3, '', 23.7);
        $ratings->add(4, '', 23.7);
        $ratings->add(5, '', 23.7);
        $ratings->add(6, '', 23.7);
        $ratings->add(7, '', 23.7);
        $ratings->add(8, '', 23.7);
        $ratings->add(9, '', 23.7);
        $ratings->add(10, '', 23.7);
        $ratings->add(11, '', 23.7);
        $ratings->add(12, '', 23.7);
        $ratings->add(13, '', 23.7);
        $ratings->add(14, '', 23.7);
        $ratings->add(15, '', 23.7);
        $ratings->add(16, '', 27.5);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertTrue($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_empty_values_when_first_rating_is_above_32_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 34.0);
        $ratings->add(2, '', 32.7);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_empty_values_when_first_rating_is_above_32_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 34.0);
        $ratings->add(2, '', 32.7);
        $ratings->add(3, '', 32.7);
        $ratings->add(4, '', 32.7);
        $ratings->add(5, '', 32.7);
        $ratings->add(6, '', 32.7);
        $ratings->add(7, '', 32.7);
        $ratings->add(8, '', 32.7);
        $ratings->add(9, '', 32.7);
        $ratings->add(10, '', 32.7);
        $ratings->add(11, '', 32.7);
        $ratings->add(12, '', 32.7);
        $ratings->add(13, '', 32.7);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_empty_values_when_first_rating_is_above_32_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 34.0);
        $ratings->add(2, '', 32.7);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_empty_values_when_first_rating_is_above_32_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 34.0);
        $ratings->add(2, '', 32.7);
        $ratings->add(3, '', 32.7);
        $ratings->add(4, '', 32.7);
        $ratings->add(5, '', 32.7);
        $ratings->add(6, '', 32.7);
        $ratings->add(7, '', 32.7);
        $ratings->add(8, '', 32.7);
        $ratings->add(9, '', 32.7);
        $ratings->add(10, '', 32.7);
        $ratings->add(11, '', 32.7);
        $ratings->add(12, '', 32.7);
        $ratings->add(13, '', 32.7);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_empty_values_when_using_st_youth_algorithm_with_no_ratings()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_empty_values_when_using_st_adult_algorithm_with_no_ratings()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(0.0, $etrMtgTargetData->expectedChange);
        $this->assertFalse($etrMtgTargetData->met);
        $this->assertEquals(0.0, $etrMtgTargetData->metPercent);
        $this->assertFalse($etrMtgTargetData->metPercent50);
        $this->assertFalse($etrMtgTargetData->metPercent67);
        $this->assertEquals(0.0, $etrMtgTargetData->value);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_meeting_target_value_for_meeting_2_is_correct_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(23.03, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_meeting_target_value_for_meeting_13_is_correct_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);
        $ratings->add(3, '', 20.3);
        $ratings->add(4, '', 20.3);
        $ratings->add(5, '', 20.3);
        $ratings->add(6, '', 20.3);
        $ratings->add(7, '', 20.3);
        $ratings->add(8, '', 20.3);
        $ratings->add(9, '', 20.3);
        $ratings->add(10, '', 20.3);
        $ratings->add(11, '', 20.3);
        $ratings->add(12, '', 20.3);
        $ratings->add(13, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(28.16, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_meeting_target_value_for_meeting_2_is_correct_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(22.51, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_meeting_target_value_for_meeting_13_is_correct_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);
        $ratings->add(3, '', 20.3);
        $ratings->add(4, '', 20.3);
        $ratings->add(5, '', 20.3);
        $ratings->add(6, '', 20.3);
        $ratings->add(7, '', 20.3);
        $ratings->add(8, '', 20.3);
        $ratings->add(9, '', 20.3);
        $ratings->add(10, '', 20.3);
        $ratings->add(11, '', 20.3);
        $ratings->add(12, '', 20.3);
        $ratings->add(13, '', 20.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertEquals(26.81, round($etrMtgTargetData->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_using_scores_where_etr_meeting_target_is_not_met_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.6);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_using_scores_where_etr_meeting_target_is_not_met_using_lt_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.6);
        $ratings->add(3, '', 23.6);
        $ratings->add(4, '', 23.6);
        $ratings->add(5, '', 23.6);
        $ratings->add(6, '', 23.6);
        $ratings->add(7, '', 23.6);
        $ratings->add(8, '', 23.6);
        $ratings->add(9, '', 23.6);
        $ratings->add(10, '', 23.6);
        $ratings->add(11, '', 23.6);
        $ratings->add(12, '', 23.6);
        $ratings->add(13, '', 23.6);
        $ratings->add(14, '', 28.5);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_using_scores_where_etr_meeting_target_is_not_met_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.1);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_false_using_scores_where_etr_meeting_target_is_not_met_using_lt_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 23.6);
        $ratings->add(3, '', 23.6);
        $ratings->add(4, '', 23.6);
        $ratings->add(5, '', 23.6);
        $ratings->add(6, '', 23.6);
        $ratings->add(7, '', 23.6);
        $ratings->add(8, '', 23.6);
        $ratings->add(9, '', 23.6);
        $ratings->add(10, '', 23.6);
        $ratings->add(11, '', 23.6);
        $ratings->add(12, '', 23.6);
        $ratings->add(13, '', 23.6);
        $ratings->add(14, '', 27.3);

        $etrMtgTarget = new EtrMtgTarget($rater, $ratings);
        $this->assertInstanceOf(EtrMtgTarget::class, $etrMtgTarget);

        $etrMtgTargetData = $etrMtgTarget->data();
        $this->assertInstanceOf(EtrStruct::class, $etrMtgTargetData);

        $this->assertFalse($etrMtgTargetData->met);
    }
}