<?php

namespace AkkiIo\CronExpressionGenerator\Tests;

use AkkiIo\CronExpressionGenerator\ParseInput;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParseInputTest extends TestCase
{
    /** @test */
    public function non_supported_types_gives_error()
    {
        $this->expectException(InvalidArgumentException::class);

        (new ParseInput([
            'type' => 'NOT_SUPPORTED',
        ], 0, 59))->generate();
    }

    /** @test */
    public function it_tests_for_type_once()
    {
        $expression = (new ParseInput([
            'type' => 'ONCE',
            'at' => '35'
        ], 0, 59))->generate();

        $this->assertEquals('35', $expression);
    }

    /** @test */
    public function it_tests_for_type_every()
    {
        $expression = (new ParseInput([
            'type' => 'EVERY',
            'every' => '5'
        ], 0, 59))->generate();

        $this->assertEquals('*/5', $expression);
    }

    /** @test */
    public function it_tests_for_type_list()
    {
        $expression = (new ParseInput([
            'type' => 'LIST',
            'list' => [0,1,2,22,33,59],
        ], 0, 59))->generate();

        $this->assertEquals('0,1,2,22,33,59', $expression);
    }

    /** @test */
    public function it_tests_for_type_range()
    {
        $expression = (new ParseInput([
            'type' => 'RANGE',
            'start' => 5,
            'end' => 10,
        ], 0, 59))->generate();

        $this->assertEquals('5-10', $expression);
    }

    /** @test */
    public function it_tests_for_type_step()
    {
        $expression = (new ParseInput([
            'type' => 'STEP',
            'every' => 5,
            'start' => 5,
            'end' => 10,
        ], 0, 59))->generate();

        $this->assertEquals('5-10/5', $expression);
    }
}
