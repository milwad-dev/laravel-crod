<?php

namespace Milwad\LaravelCrod\Traits;

use Illuminate\Support\Pluralizer;

trait StubTrait
{
    /**
     * Build stub & check exists.
     */
    protected function makeStubFile(string $pathSource, string $name, string $latest, string $pathStub, bool $singular = true): void
    {
        $path = $this->getSourceFilePath($pathSource, $name, $latest, $singular);
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile($pathStub, $pathSource, $name);

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * Return the stub file path.
     *
     *
     * @return string
     */
    private function getStubPath(string $path)
    {
        return __DIR__.$path;
    }

    /**
     * Map the stub variables present in stub to its value.
     *
     *
     * @return array
     */
    private function getStubVariables(string $namespace, string $name)
    {
        return [
            'NAMESPACE'  => $namespace,
            'CLASS_NAME' => $this->getSingularClassName($name),
        ];
    }

    /**
     * Get the stub path and the stub variables.
     *
     *
     * @return array|false|string|string[]
     */
    private function getSourceFile(string $path, string $namespace, string $name)
    {
        return $this->getStubContents(
            $this->getStubPath($path),
            $this->getStubVariables($namespace, $name)
        );
    }

    /**
     * Replace the stub variables(key) with the desire value.
     *
     * @param array $stubVariables
     *
     * @return array|false|string|string[]
     */
    private function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class.
     *
     *
     * @return string
     */
    private function getSourceFilePath(string $path, string $name, string $latest, bool $singular = true)
    {
        if (!$singular) {
            return base_path($path).'\\'.$name."$latest.php";
        }

        return base_path($path).'\\'.$this->getSingularClassName($name)."$latest.php";
    }

    /**
     * Return the singular capitalize name.
     *
     *
     * @return string
     */
    private function getSingularClassName(string $name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     *
     * @return string
     */
    private function makeDirectory(string $path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
