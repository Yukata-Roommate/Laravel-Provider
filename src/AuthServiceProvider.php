<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

/**
 * Auth Service Provider
 * 
 * @package YukataRm\Laravel\Provider
 */
abstract class AuthServiceProvider extends ServiceProvider
{
    /**
     * define auth
     *
     * @return void
     */
    public function boot()
    {
        $this->defineGates();

        $this->definePolicies();
    }

    /*----------------------------------------*
     * Gate
     *----------------------------------------*/

    /**
     * define gates
     * 
     * @return void
     */
    abstract protected function defineGates(): void;

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

    /*----------------------------------------*
     * Policy
     *----------------------------------------*/

    /**
     * policies
     * 
     * @var array<string, string>
     */
    protected $policies = [];

    /**
     * get policies
     * 
     * @return array<string, string>
     */
    protected function policies(): array
    {
        return $this->policies;
    }

    /**
     * define policies
     * 
     * @return void
     */
    protected function definePolicies(): void
    {
        foreach ($this->policies() as $model => $policy) {
            $this->policy($model, $policy);
        }
    }

    /**
     * define policy
     * 
     * @param string $model
     * @param string $policy
     * @return void
     */
    protected function policy(string $model, string $policy): void
    {
        Gate::policy($model, $policy);
    }
}
