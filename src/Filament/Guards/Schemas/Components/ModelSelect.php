<?php

namespace Betta\Terms\Filament\Guards\Schemas\Components;

use Betta\Terms\Enums\GuardType;
use Betta\Terms\ModelRegistry;
use Betta\Terms\Terms;
use Filament\Forms\Components\Select;

class ModelSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'model_slug';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Model');

        $this->options(fn () => ModelRegistry::make()->getAll());

        $this->searchable();

        $this->reactive();

        $this->afterStateUpdated(fn () => $this->setGuardName());

        $this->dehydrated(false);

        $this->required();

        $this->visible(fn ($get) => $get('type') === GuardType::Model);
    }

    public function setGuardName(): void
    {
        $set = $this->makeSetUtility();
        $state = $this->getState();
        $name = str($state)
            ->when(str($state)->startsWith('App\\Models\\'), fn ($stringable) => $stringable->afterLast('\\'))
            ->append(' Model Guard')
            ->toString();

        $set('name', $name);
        $set('slug', Terms::getModelSlug($state));
    }
}
