<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

/**
 * View Composer Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class ViewComposerServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get composers
     *
     * @return array<string, array|string>
     */
    abstract protected function composers(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * register Alias
     *
     * @return void
     */
    public function boot(): void
    {
        $composers = $this->composers();

        if (empty($composers)) return;

        View::composers($composers);
    }
}
