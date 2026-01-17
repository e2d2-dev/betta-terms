<?php

namespace Betta\Terms;

class ComponentRegistry
{
    protected array $components = [];

    public static function make(): static
    {
        return app(static::class);
    }

    public function add(string $component, ?string $name = null): static
    {
        $this->components[$component] = $name ? ucfirst($name) : $this->getName($component);

        return $this;
    }

    protected function getName(string $component): string
    {
        return str($component)->classBasename()->toString();
    }

    public function getAll(): array
    {
        return $this->components;
    }
}
