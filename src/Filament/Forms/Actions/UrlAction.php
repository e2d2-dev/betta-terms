<?php

namespace Betta\Terms\Filament\Forms\Actions;

use Betta\Terms\Models\Condition;
use Filament\Support\Icons\Heroicon;

class UrlAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'url';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->openUrlInNewTab();

        $this->icon(Heroicon::ArrowRightStartOnRectangle);

        $this->link();

        $this->label(__('betta-terms::actions.goto.label'));

        $this->url(fn (Condition $record) => $record->getUrl(), true);
    }
}
