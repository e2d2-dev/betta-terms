<?php

namespace Betta\Terms\Filament\Pages\ConsentConditions;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

trait HasContent
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = null;

    public function content(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->record($this->getRecord())
            ->model($this->getRecord())
            ->schema([
                ...static::getComponents(),

                Actions::make([
                    $this->getCancelAction(),
                    $this->getSaveAction(),
                ])->fullWidth(),
            ]);
    }
}
