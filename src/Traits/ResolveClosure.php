<?php

namespace Betta\Terms\Traits;

use Betta\Terms\Terms;
use Closure;
use InvalidArgumentException;
use ReflectionFunction;

trait ResolveClosure
{
    protected function resolveClosure(Closure $callback, array $arguments = []): mixed
    {
        $fn = new ReflectionFunction($callback);

        $resolved = [];
        $resolvable = [...$this->getResolveAbleArguments(), ...$arguments ];

        foreach ($fn->getParameters() as $parameter) {
            $name = $parameter->getName();
            $argument = $resolvable[$name] ?? null;

            if(! $argument) {
                throw new InvalidArgumentException("{$name} could not be resolved.");
            }
            $resolved[] = $argument;
        }

        return $callback(...$resolved);
    }

    protected function getResolveAbleArguments(): array
    {
        return [
            'guard' => Terms::getGuard(),
            'user' => auth()->user(),
            'panel' => filament()->getCurrentPanel(),
        ];
    }
}
