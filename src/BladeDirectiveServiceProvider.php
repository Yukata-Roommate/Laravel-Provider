<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

/**
 * Blade Directive Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class BladeDirectiveServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get directives
     *
     * @return array<string, \Closure>
     */
    protected function directives(): array
    {
        return [];
    }

    /**
     * get if directives
     *
     * @return array<string, \Closure>
     */
    protected function ifDirectives(): array
    {
        return [];
    }

    /**
     * get stringable directives
     *
     * @return array<string, \Closure>
     */
    protected function stringableDirectives(): array
    {
        return [];
    }

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * add directives
     *
     * @return void
     */
    public function boot(): void
    {
        $this->addDirectives();
        $this->addIfDirectives();
        $this->addStringableDirectives();
    }

    /**
     * add directives
     *
     * @return void
     */
    protected function addDirectives(): void
    {
        $directives = $this->directives();

        if (empty($directives)) return;

        foreach ($directives as $name => $directive) {
            Blade::directive($name, $directive);
        }
    }

    /**
     * add if directives
     *
     * @return void
     */
    protected function addIfDirectives(): void
    {
        $ifs = $this->ifDirectives();

        if (empty($ifs)) return;

        foreach ($ifs as $name => $directive) {
            Blade::if($name, $directive);
        }
    }

    /**
     * add stringable directives
     *
     * @return void
     */
    protected function addStringableDirectives(): void
    {
        $stringables = $this->stringableDirectives();

        if (empty($stringables)) return;

        foreach ($stringables as $name => $directive) {
            Blade::stringable($name, $directive);
        }
    }

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * get directive string
     *
     * @param string $value
     * @return string
     */
    protected function directive(string $value): string
    {
        return "<?php {$value}; ?>";
    }

    /**
     * get echo string
     *
     * @param string $value
     * @return string
     */
    protected function echo(string $value): string
    {
        return $this->directive("echo {$value}");
    }
}
