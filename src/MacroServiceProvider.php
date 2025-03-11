<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

/**
 * Macro Service Provider
 *
 * @package YukataRm\Laravel\Provider
 */
abstract class MacroServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get macros
     *
     * @return array<string, array<string, \Closure>>
     */
    abstract protected function macros(): array;

    /**
     * get mixins
     *
     * @return array<string, object>
     */
    protected function mixins(): array
    {
        return [];
    }

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * define macro and add mixin
     *
     * @return void
     */
    public function boot(): void
    {
        $this->defineMacro();

        $this->addMixin();
    }

    /**
     * define macro
     *
     * @return void
     */
    protected function defineMacro(): void
    {
        $macros = $this->macros();

        if (empty($macros)) return;

        foreach ($macros as $macroClass => $contents) {
            if (!class_exists($macroClass)) continue;

            if (!method_exists($macroClass, "macro")) continue;

            foreach ($contents as $name => $closure) {
                $macroClass::macro($name, $closure);
            }
        }
    }

    /**
     * add mixin
     *
     * @return void
     */
    protected function addMixin(): void
    {
        $mixins = $this->mixins();

        if (empty($mixins)) return;

        foreach ($mixins as $mixinClass => $object) {
            if (!class_exists($mixinClass)) continue;

            if (!method_exists($mixinClass, "mixin")) continue;

            $mixinClass::mixin($object);
        }
    }
}
