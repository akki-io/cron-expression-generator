<?php

namespace AkkiIo\CronExpressionGenerator;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class CronExpressionGenerator
{
    /**
     * Options related to the type.
     *
     * @var array
     */
    public array $options;

    /**
     * CronExpressionGenerator constructor.
     *
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Generate the cron expression.
     *
     * @return string
     */
    public function generate(): string
    {
        $cron['minute'] = (new ParseInput(Arr::get($this->options, 'minute', []), 0, 59))->generate();
        $cron['hour'] = (new ParseInput(Arr::get($this->options, 'hour', []), 0, 23))->generate();
        $cron['day_month'] = (new ParseInput(Arr::get($this->options, 'day_month', []), 1, 31))->generate();
        $cron['month'] = (new ParseInput(Arr::get($this->options, 'month', []), 1, 12))->generate();
        $cron['day_week'] = (new ParseInput(Arr::get($this->options, 'day_week', []), 0, 6))->generate();

        return implode(' ', $cron);
    }
}
