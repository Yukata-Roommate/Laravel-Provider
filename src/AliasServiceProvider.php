<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Foundation\AliasLoader;

/**
 * Alias Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class AliasServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get aliases
     *
     * @return array<string, string>
     */
    abstract protected function aliases(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * register Alias
     *
     * @return void
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->aliases() as $alias => $class) {
            $loader->alias($alias, $class);
        }
    }
}
