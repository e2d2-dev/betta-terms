<?php

namespace Betta\Terms\Filament\Guards\Schemas\Components;

use Betta\Terms\Enums\GuardType;
use Betta\Terms\Terms;
use Filament\Forms\Components\Select;

class PanelSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'panel_slug';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Panel');

        $this->options(fn () => Terms::listPanels());

        $this->reactive();

        $this->required();

        $this->dehydrated(false);

        $this->visible(fn ($get, $operation) => $operation === 'create' and $get('type') === GuardType::Panel);

        $this->afterStateUpdated(fn () => $this->setGuardName());
    }

    public function setGuardName(): void
    {
        $set = $this->makeSetUtility();
        $state = $this->getState();
        $name = str($state)
            ->append(' Panel Guard')
            ->toString();

        $set('name', ucfirst($name));
        $set('slug', Terms::getPanelSlug($state));
    }
}
