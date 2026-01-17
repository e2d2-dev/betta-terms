<?php

namespace Betta\Terms\Filament\Forms\AcceptedCheckBox;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Actions\EmbedAction;
use Betta\Terms\Filament\Forms\Actions\TextAction;
use Betta\Terms\Filament\Forms\Actions\UrlAction;
use Filament\Actions\Action;

trait HasInfoAction
{
    public function getHintActions(): array
    {
        return [$this->getInfoAction()];
    }

    public function getInfoAction(): ?Action
    {
        $result = match (true) {
            $this->isSimple() => true,
            $this->isCompact() => true,
            default => false
        };

        if (! $result) {
            return null;
        }

        $action = match ($this->getConditionSource()) {
            Source::Pdf, Source::Iframe, Source::Image => EmbedAction::make(),
            Source::Text => TextAction::make(),
            Source::Link => UrlAction::make(),
            default => null,
        };

        if (! $action) {
            return null;
        }

        return $action->record($this->getConditionFromState());
    }
}
