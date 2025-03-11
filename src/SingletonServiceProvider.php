<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

/**
 * Singleton Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class SingletonServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get singleton classes
     *
     * @return array<string>
     */
    abstract protected function singletons(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * register singleton classes
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->singletons() as $singleton) {
            $this->app->singleton($singleton);
        }
    }
}
