<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

/**
 * Gate Service Provider
 * 
 * @package YukataRm\Laravel\Provider
 */
abstract class GateServiceProvider extends ServiceProvider
{
    /**
     * define Gate
     *
     * @return void
     */
    public function boot(): void
    {
        $this->define();
    }

    /**
     * define Gate
     * 
     * @return void
     */
    abstract protected function define(): void;

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * define gate
     * 
     * @param string $ability
     * @param callable $callback
     * @return void
     */
    protected function gate(string $ability, callable $callback): void
    {
        Gate::define($ability, $callback);
    }

    /**
     * define before gate
     * 
     * @param callable $callback
     * @return void
     */
    protected function beforeGate(callable $callback): void
    {
        Gate::before($callback);
    }

    /**
     * define after gate
     * 
     * @param callable $callback
     * @return void
     */
    protected function afterGate(callable $callback): void
    {
        Gate::after($callback);
    }

    /**
     * define resource gate
     * 
     * @param string $name
     * @param string $class
     * @param array|null $abilities
     * @return void
     */
    protected function resourceGate(string $name, string $class, array|null $abilities = null): void
    {
        Gate::resource($name, $class, $abilities);
    }
}
