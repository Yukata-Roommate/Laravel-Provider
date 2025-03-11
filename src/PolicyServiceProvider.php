<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

/**
 * Policy Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class PolicyServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get policies
     *
     * @return array<string, string>
     */
    abstract protected function policies(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * define Policy
     *
     * @return void
     */
    public function boot(): void
    {
        foreach ($this->policies() as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
