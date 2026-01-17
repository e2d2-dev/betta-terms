<?php

namespace Betta\Terms\Filament\Forms\Source;

use Betta\Terms\Enums\Source;
use Betta\Terms\Models\Condition;
use Filament\Schemas\Components\Utilities\Get;

trait HasTermSource
{
    protected Source $source;

    public function source(Source $source): static
    {
        $this->source = $source;

        $this->visibleWhenSource($source);

        $this->disableOnceAccepted();

        $this->required();

        return $this;
    }

    public function visibleWhenSource(Source $source): static
    {
        $this->visible(fn (Get $get) => $get('data.source', true) == $source);

        return $this;
    }

    public function disableOnceAccepted(): static
    {
        $this->disabled(fn (?Condition $record) => $record && $record->onceAccepted());

        return $this;
    }
}
