<?php

namespace Bluewing\Progress23\Tests\Unit;

use Bluewing\Progress23\EtrTarget;
use Bluewing\Progress23\Rater;
use Bluewing\Progress23\RatingCollection;
use Exception;
use PHPUnit\Framework\TestCase;

class EtrTargetTest extends TestCase
{
    const ADOLESCENT = 1;
    const ADULT = 2;
    const CHILD = 3;

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_an_expected_change_value_using_the_st_youth_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(12.98, round($data->expectedChange, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_returns_an_expected_change_value_using_the_st_adult_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(11.94, round($data->expectedChange, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_true_when_checking_if_etr_target_was_met_when_using_st_youth_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertTrue($data->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_true_when_checking_if_etr_target_was_met_when_using_st_adult_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertTrue($data->met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_the_etr_target_met_percent_using_st_youth_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(68.58, round($data->metPercent, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_the_etr_target_met_percent_using_st_adult_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(74.57, round($data->metPercent, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_whether_the_etr_target_was_met_with_two_scores_with_st_youth_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $met = $data->metPercent50;

        $this->assertTrue($met);

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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $met = $data->metPercent67;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_whether_the_etr_target_was_met_with_two_scores_with_st_adult_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $met = $data->metPercent50;

        $this->assertTrue($met);

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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $met = $data->metPercent67;

        $this->assertTrue($met);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_the_etr_target_value_for_using_st_youth_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(25.08, round($data->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_the_etr_target_value_using_st_adult_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(24.04, round($data->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_the_etr_target_value_using_lt_youth_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(25.08, round($data->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_the_etr_target_value_using_lt_adult_algorithm()
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

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(24.04, round($data->value, 2));
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_initialized_values_when_using_st_youth_algorithm_when_there_are_no_ratings()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(0.0, $data->expectedChange);
        $this->assertEquals(0.0, $data->value);
        $this->assertEquals(0.0, $data->metPercent);
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function return_initialized_values_when_using_st_adult_algorithm_when_there_are_no_ratings()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(0.0, $data->expectedChange);
        $this->assertEquals(0.0, $data->value);
        $this->assertEquals(0.0, $data->metPercent);
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_target_data_when_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.84, round($data->expectedChange, 2));
        $this->assertEquals(28.04, round($data->value, 2));
        $this->assertEquals(12.44, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_target_data_when_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 20.3);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.03, round($data->expectedChange, 2));
        $this->assertEquals(27.23, round($data->value, 2));
        $this->assertEquals(13.70, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_target_data_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 22.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.32, round($data->expectedChange, 2));
        $this->assertEquals(28.42, round($data->value, 2));
        $this->assertEquals(25.25, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function will_return_etr_target_data_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 22.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(7.54, round($data->expectedChange, 2));
        $this->assertEquals(27.64, round($data->value, 2));
        $this->assertEquals(27.87, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_met_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 36.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.32, round($data->expectedChange, 2));
        $this->assertEquals(28.42, round($data->value, 2));
        $this->assertEquals(100.00, round($data->metPercent, 2));
        $this->assertTrue($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertTrue($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_met_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 20.1);
        $ratings->add(2, '', 36.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(7.54, round($data->expectedChange, 2));
        $this->assertEquals(27.64, round($data->value, 2));
        $this->assertEquals(100.00, round($data->metPercent, 2));
        $this->assertTrue($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertTrue($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_met_percent_is_correct_when_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 24.3);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.84, round($data->expectedChange, 2));
        $this->assertEquals(28.04, round($data->value, 2));
        $this->assertEquals(57.68, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_met_percent_is_correct_when_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 24.3);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.03, round($data->expectedChange, 2));
        $this->assertEquals(27.23, round($data->value, 2));
        $this->assertEquals(63.51, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_predicted_change_percent_met_is_false_when_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 23.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.84, round($data->expectedChange, 2));
        $this->assertEquals(28.04, round($data->value, 2));
        $this->assertEquals(45.24, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_predicted_change_percent_met_is_false_when_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 23.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.03, round($data->expectedChange, 2));
        $this->assertEquals(27.23, round($data->value, 2));
        $this->assertEquals(49.81, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_predicted_change_percent_met_is_true_when_using_st_youth_algorithm()
    {
        $rater = new Rater($this::ADOLESCENT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 23.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.84, round($data->expectedChange, 2));
        $this->assertEquals(28.04, round($data->value, 2));
        $this->assertEquals(45.24, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertFalse($data->metPercent50);
        $this->assertFalse($data->metPercent67);

        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 29.3);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.84, round($data->expectedChange, 2));
        $this->assertEquals(28.04, round($data->value, 2));
        $this->assertEquals(100.00, round($data->metPercent, 2));
        $this->assertTrue($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertTrue($data->metPercent67);
    }

    /**
     * @test
     * @throws Exception
     */
    public function etr_target_predicted_change_percent_met_is_true_when_using_st_adult_algorithm()
    {
        $rater = new Rater($this::ADULT);
        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 25.2);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.03, round($data->expectedChange, 2));
        $this->assertEquals(27.23, round($data->value, 2));
        $this->assertEquals(74.72, round($data->metPercent, 2));
        $this->assertFalse($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertTrue($data->metPercent67);

        $ratings = new RatingCollection;

        $ratings->add(1, '', 19.2);
        $ratings->add(2, '', 27.3);

        $etrTarget = new EtrTarget($rater, $ratings);

        $data = $etrTarget->data();

        $this->assertEquals(8.03, round($data->expectedChange, 2));
        $this->assertEquals(27.23, round($data->value, 2));
        $this->assertEquals(100.00, round($data->metPercent, 2));
        $this->assertTrue($data->met);
        $this->assertTrue($data->metPercent50);
        $this->assertTrue($data->metPercent67);
    }
}
