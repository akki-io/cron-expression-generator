<?php

namespace AkkiIo\CronExpressionGenerator;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;

class ValidatorFactory
{
    /**
     * @var Factory
     */
    private Factory $factory;

    /**
     * ValidatorFactory constructor.
     */
    public function __construct()
    {
        $this->factory = new Factory($this->loadTranslator());
    }

    /**
     * Load the translator from the lang file.
     *
     * @return Translation\Translator
     */
    protected function loadTranslator()
    {
        $fileSystem = new Filesystem();

        $loader = new FileLoader(
            $fileSystem,
            dirname(dirname(__FILE__)) . '/lang'
        );

        $loader->addNamespace(
            'lang',
            dirname(dirname(__FILE__)) . '/lang'
        );

        $loader->load(
            'en',
            'validation',
            'lang'
        );

        return new Translator($loader, 'en');
    }

    /**
     * Magic call method.
     *
     * @param $method
     * @param $args
     * @return false|mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }
}
