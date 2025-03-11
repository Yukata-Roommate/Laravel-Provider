<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

/**
 * Facade Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class FacadeServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get facades
     *
     * @return array<string, string>
     */
    abstract protected function facades(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * register Facade
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->facades() as $alias => $facade) {
            $this->app->singleton($alias, function () use ($facade) {
                return new $facade();
            });
        }
    }
}
