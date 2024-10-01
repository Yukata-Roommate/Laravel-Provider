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
     * @return array<string, \Closure>
     */
    abstract protected function macros(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * define macro
     * 
     * @return void
     */
    public function boot(): void
    {
        if (!$this->isExists()) throw new \RuntimeException("macro class {$this->macroClass} does not exist.");

        if (!$this->canAdd()) throw new \RuntimeException("macro class {$this->macroClass} can not add macro.");

        foreach ($this->macros() as $name => $closure) {
            $this->add($name, $closure);
        }
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * macro class
     * 
     * @var string
     */
    protected string $macroClass;

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * add macro
     * 
     * @param string $class
     * @param string $name
     * @param \Closure $closure
     * @return void
     */
    protected function add(string $name, \Closure $closure): void
    {
        $this->macroClass::macro($name, $closure);
    }

    /**
     * whether macro class exists
     * 
     * @return bool
     */
    protected function isExists(): bool
    {
        return class_exists($this->macroClass);
    }

    /**
     * whether macro class can add macro
     * 
     * @return bool
     */
    protected function canAdd(): bool
    {
        return method_exists($this->macroClass, "macro");
    }
}
