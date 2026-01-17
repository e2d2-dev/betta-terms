<?php

namespace Betta\Terms\Filament\Forms;

use Betta\Terms\Filament\Forms\Consent\HasLayout;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;

class ConsentComponent extends Group
{
    use HasLayout;

    protected function setUp(): void
    {
        $this->schema(fn () => $this->isSection()
            ? $this->getAsSection()
            : [$this->getConsentPicker()]
        );

        $this->visible(fn() => !empty($this->getChildComponents()));
    }

    protected function getConsentPicker(): ConsentPicker
    {
        return ConsentPicker::make()
            ->hiddenLabel($this->isLabelHidden())
            ->compact($this->isCompact());
    }

    protected function getAsSection(): array
    {
        return [
            Section::make(fn () => $this->getLabel() ?: $this->getSectionLabel())
                ->icon($this->getIcon())
                ->aside($this->isAside())
                ->compact($this->isCompact())
                ->schema([
                    $this->getConsentPicker()
                        ->hiddenLabel()
                        ->compact(),
                ]),
        ];
    }
}
