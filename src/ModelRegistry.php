<?php

namespace Betta\Terms;

use Illuminate\Support\Facades\File;

class ModelRegistry
{
    protected array $models = [];

    public function __construct()
    {
        $this->discover(app_path('Models'));
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function add(string $model, ?string $name = null): static
    {
        $name = $name ? ucfirst($name) : $this->getName($model);
        $this->models[$model] = $name;

        return $this;
    }

    protected function getName(string $model): string
    {
        return str($model)->classBasename()->toString();
    }

    public function getAll(): array
    {
        return collect($this->models)->sort()->toArray();
    }

    public function discover(string $in): static
    {
        if (! is_dir($in)) {
            return $this;
        }

        $this->models = collect(File::allFiles($in))
            ->mapWithKeys(function (\SplFileInfo $file) {
                $name = $file->getBasename('.php');

                $file = file_get_contents($file->getRealPath());
                $namespace = str($file)->after('namespace')->before(';')->trim()->toString();

                $model = $namespace.'\\'.$name;

                return [$model => $name];
            })
            ->merge($this->models)
            ->toArray();

        return $this;
    }
}
