<?php

namespace AkkiIo\CronExpressionGenerator\Tests;

use AkkiIo\CronExpressionGenerator\CronExpressionGenerator;
use PHPUnit\Framework\TestCase;

class CronExpressionGeneratorBasicTest extends TestCase
{
    /** @test */
    public function it_should_return_cron_for_every_minute()
    {
        $options = [];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('* * * * *', $cron);
    }

    /** @test */
    public function it_should_return_cron_for_every_hour()
    {
        $options = [
            'minute' => [
                'type' => 'ONCE',
                'at' => 0,
            ],
            'hour' => [
                'type' => 'EVERY',
                'every' => 1,
            ],
        ];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('0 */1 * * *', $cron);
    }

    /** @test */
    public function it_should_return_cron_for_every_day_at_specific_hour_minute()
    {
        $options = [
            'minute' => [
                'type' => 'ONCE',
                'at' => 15,
            ],
            'hour' => [
                'type' => 'ONCE',
                'at' => 10,
            ],
        ];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('15 10 * * *', $cron);
    }

    /** @test */
    public function it_should_return_cron_for_weekday_at_specific_hour_minute()
    {
        $options = [
            'minute' => [
                'type' => 'ONCE',
                'at' => 15,
            ],
            'hour' => [
                'type' => 'ONCE',
                'at' => 10,
            ],
            'day_week' => [
                'type' => 'RANGE',
                'start' => 1,
                'end' => 5,
            ],
        ];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('15 10 * * 1-5', $cron);
    }

    /** @test */
    public function it_should_return_cron_for_every_month_at_specific_date_hour_minute()
    {
        $options = [
            'minute' => [
                'type' => 'ONCE',
                'at' => 15,
            ],
            'hour' => [
                'type' => 'ONCE',
                'at' => 10,
            ],
            'day_month' => [
                'type' => 'ONCE',
                'at' => 22,
            ],
        ];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('15 10 22 * *', $cron);
    }

    /** @test */
    public function it_should_return_cron_for_every_sunday_at_specific_day_hour_minute()
    {
        $options = [
            'minute' => [
                'type' => 'ONCE',
                'at' => 15,
            ],
            'hour' => [
                'type' => 'ONCE',
                'at' => 10,
            ],
            'day_week' => [
                'type' => 'ONCE',
                'at' => 0,
            ],
        ];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('15 10 * * 0', $cron);
    }

    /** @test */
    public function it_should_return_cron_for_every_year_at_specific_month_date_hour_minute()
    {
        $options = [
            'minute' => [
                'type' => 'ONCE',
                'at' => 15,
            ],
            'hour' => [
                'type' => 'ONCE',
                'at' => 10,
            ],
            'day_month' => [
                'type' => 'ONCE',
                'at' => 22,
            ],
            'month' => [
                'type' => 'ONCE',
                'at' => 10,
            ],
        ];

        $cron = (new CronExpressionGenerator($options))->generate();

        $this->assertEquals('15 10 22 10 *', $cron);
    }
}
