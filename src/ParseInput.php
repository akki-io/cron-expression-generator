<?php

namespace AkkiIo\CronExpressionGenerator;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class ParseInput
{
    const SUPPORTED_TYPES = [
        'ONCE',
        'EVERY',
        'LIST',
        'RANGE',
        'STEP',
    ];

    public array $options;

    public int $max;

    /**
     * ParseInput constructor.
     *
     * @param array $options
     * @param int $min
     * @param int $max
     */
    public function __construct(array $options, int $min, int $max)
    {
        $this->options = $options;

        if (count($this->options)) {
            $validator = (new ValidatorFactory())->make($this->options, $this->rules($min, $max));

            if ($validator->fails()) {
                throw new InvalidArgumentException("UNSUPPORTED_OPTIONS");
            }
        }
    }

    /**
     * Get the validation rules
     *
     * @param int $min
     * @param int $max
     * @return array[]
     */
    public function rules(int $min, int $max): array
    {
        return [
            'type' => [
                'required',
                Rule::in(self::SUPPORTED_TYPES),
            ],
            'at' => [
                'required_if:type,ONCE',
                'between:'.($min).','.($max),
            ],
            'every' => [
                'required_if:type,EVERY',
                'required_if:type,STEP',
                'between:'.($min+1).','.($max),
            ],
            'list' => [
                'required_if:type,LIST',
                'array',
            ],
            'list.*' => [
                'required_if:type,LIST',
                'between:'.($min).','.($max-1),
            ],
            'start' => [
                'required_if:type,RANGE',
                'required_if:type,STEP',
                'between:'.($min).','.($max-1),
            ],
            'end' => [
                'required_if:type,RANGE',
                'required_if:type,STEP',
                'between:'.($min).','.($max-1),
                'gte:start'
            ],
        ];
    }

    /**
     * Generate the cron.
     *
     * @return string
     */
    public function generate(): string
    {
        $type = Arr::get($this->options, 'type');

        if ($type === 'ONCE') {
            return Arr::get($this->options, 'at');
        }

        if ($type === 'EVERY') {
            return '*/'.Arr::get($this->options, 'every');
        }

        if ($type === 'LIST') {
            return implode(',', Arr::get($this->options, 'list'));
        }

        if ($type === 'RANGE') {
            return Arr::get($this->options, 'start')
                .'-'
                .Arr::get($this->options, 'end');
        }

        if ($type === 'STEP') {
            return Arr::get($this->options, 'start')
                .'-'
                .Arr::get($this->options, 'end')
                .'/'
                .Arr::get($this->options, 'every');
        }

        return '*';
    }
}
