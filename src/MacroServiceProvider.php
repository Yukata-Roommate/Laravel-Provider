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
     * @return array<string, array<string, string|\Closure>>
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
        foreach ($this->macros() as $class => $macro) {
            if (!$this->isExists($class)) $this->throwNotFoundException($class);

            if (!$this->canAdd($class)) $this->throwCanNotAddException($class);

            if (!$this->validateName($macro)) $this->throwInvalidNameException($class, $macro);

            if (!$this->validateClosure($macro)) $this->throwInvalidClosureException($class, $macro);

            $this->add($class, $macro[$this->nameKey], $macro[$this->closureKey]);
        }
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * macro name key
     * 
     * @var string
     */
    protected string $nameKey = "name";

    /**
     * macro closure key
     * 
     * @var string
     */
    protected string $closureKey = "closure";

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
    protected function add(string $class, string $name, \Closure $closure): void
    {
        $class::macro($name, $closure);
    }

    /**
     * whether macro class exists
     * 
     * @param string $class
     * @return bool
     */
    protected function isExists(string $class): bool
    {
        return class_exists($class);
    }

    /**
     * throw not found exception
     * 
     * @param string $class
     * @return void
     */
    protected function throwNotFoundException(string $class): void
    {
        throw new \RuntimeException("macro class {$class} not found");
    }

    /**
     * whether macro class can add macro
     * 
     * @param string $class
     * @return bool
     */
    protected function canAdd(string $class): bool
    {
        return method_exists($class, "macro");
    }

    /**
     * throw can not add exception
     * 
     * @param string $class
     * @return void
     */
    protected function throwCanNotAddException(string $class): void
    {
        throw new \RuntimeException("macro class {$class} can not add macro");
    }

    /**
     * whether macro name is valid
     * 
     * @param array<string, \Closure> $macro
     * @return bool
     */
    protected function validateName(array $macro): bool
    {
        if (!isset($macro[$this->nameKey])) return false;

        $name = $macro[$this->nameKey];

        return is_string($name) && !empty($name);
    }

    /**
     * throw invalid name exception
     * 
     * @param string $class
     * @param array<string, \Closure> $macro
     * @return void
     */
    protected function throwInvalidNameException(string $class, array $macro): void
    {
        $json = $this->toMacroJson($macro);

        throw new \RuntimeException("macro name is invalid. class {$class}, macro: {$json}");
    }

    /**
     * whether macro closure is valid
     * 
     * @param array<string, \Closure> $macro
     * @return bool
     */
    protected function validateClosure(array $macro): bool
    {
        if (!isset($macro[$this->closureKey])) return false;

        $closure = $macro[$this->closureKey];

        return is_callable($closure);
    }

    /**
     * throw invalid closure exception
     * 
     * @param string $class
     * @param array<string, \Closure> $macro
     * @return void
     */
    protected function throwInvalidClosureException(string $class, array $macro): void
    {
        $json = $this->toMacroJson($macro);

        throw new \RuntimeException("macro closure is invalid. class {$class}, macro: {$json}");
    }

    /**
     * convert to macro json
     * 
     * @param array<string, \Closure> $macro
     * @return string
     */
    protected function toMacroJson(array $macro): string
    {
        return json_encode($macro, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
