<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

/**
 * View Service Provider
 * 
 * @package YukataRm\Laravel\Provider
 */
abstract class ViewServiceProvider extends ServiceProvider
{
    /*----------------------------------------*
     * Abstract
     *----------------------------------------*/

    /**
     * get views
     * 
     * @return array<string, string>
     */
    abstract protected function views(): array;

    /*----------------------------------------*
     * Required
     *----------------------------------------*/

    /**
     * load views
     * 
     * @return void
     */
    public function boot(): void
    {
        foreach ($this->views() as $path => $namespace) {
            $this->loadViewsFrom($this->path($path), $namespace);
        }
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * base path
     * 
     * @var string
     */
    protected string $basePath;

    /**
     * get base path
     * 
     * @return string
     */
    protected function basePath(): string
    {
        if (!isset($this->basePath)) throw new \ErrorException("basePath is not set.");

        return $this->basePath;
    }

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * get path to resources
     * 
     * @param string|array<string> $path
     * @return string
     */
    protected function path(string|array $path): string
    {
        if (is_array($path)) $path = implode(DIRECTORY_SEPARATOR, $path);

        return $this->basePath() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . $path;
    }
}
