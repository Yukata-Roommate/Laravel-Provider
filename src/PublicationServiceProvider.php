<?php

namespace YukataRm\Laravel\Provider;

use Illuminate\Support\ServiceProvider;

/**
 * Publication Service Provider
 * 
 * @package YukataRm\Laravel\Provider
 */
abstract class PublicationServiceProvider extends ServiceProvider
{
    /**
     * publish 
     * 
     * @return void
     */
    public function boot(): void
    {
        foreach ($this->publications() as $group => $pair) {
            $paths = $this->makePaths($pair);

            $this->publishes($paths, $group);

            $this->publishes($paths, $this->commonGroup());
        }
    }

    /**
     * make paths
     * 
     * @param array<string, string> $pair
     * @return array<string, string>
     */
    protected function makePaths(array $pair): array
    {
        $publish = [];

        foreach ($pair as $before => $after) {
            $publish = array_merge($publish, $this->makePublish($before, $after));
        }

        return $publish;
    }

    /**
     * make publish
     * 
     * @param string $before
     * @param string $after
     * @return array<string, string>
     */
    protected function makePublish(string $before, string $after): array
    {
        return [
            $this->path($before) => $after,
        ];
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
     * publish common group
     * 
     * @var string
     */
    protected string $commonGroup;

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

    /**
     * get common group
     * 
     * @return string
     */
    protected function commonGroup(): string
    {
        if (!isset($this->commonGroup)) throw new \ErrorException("commonGroup is not set.");

        return $this->commonGroup;
    }

    /**
     * get publications
     * 
     * group => [
     *    before path => after path
     * ]
     * 
     * @return array<string, array<string, string>>
     */
    abstract protected function publications(): array;

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * get path to publications
     * 
     * @param string|array<string> $path
     * @return string
     */
    protected function path(string|array $path): string
    {
        if (is_array($path)) $path = implode(DIRECTORY_SEPARATOR, $path);

        return $this->basePath() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "publications" . DIRECTORY_SEPARATOR . $path;
    }
}
