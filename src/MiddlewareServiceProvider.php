<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Http\Kernel as KernelContract;
use Illuminate\Foundation\Http\Kernel;

/**
 * Middleware Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class MiddlewareServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get middlewares
     *
     * @return array<string>
     */
    abstract protected function middlewares(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * register Middleware
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->middlewares() as $middleware) {
            $this->app->singleton($middleware);
        }
    }

    /**
     * push Middleware
     *
     * @return void
     */
    public function boot(): void
    {
        $kernel = $this->getKernel();

        foreach ($this->middlewares() as $middleware) {
            $kernel->pushMiddleware($middleware);
        }
    }

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * get Kernel
     *
     * @return \Illuminate\Foundation\Http\Kernel
     */
    protected function getKernel(): Kernel
    {
        return app(KernelContract::class);
    }
}
