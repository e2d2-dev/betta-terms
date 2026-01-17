<?php

namespace Betta\Terms\Filament\Forms;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\AcceptedCheckBox\HasInfoAction;
use Betta\Terms\Filament\Forms\Actions\EmbedAction;
use Betta\Terms\Filament\Forms\Actions\TextAction;
use Betta\Terms\Filament\Forms\Actions\UrlAction;
use Betta\Terms\Filament\Forms\Concerns\CanHaveConditionFromState;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Illuminate\Database\Eloquent\Model;

class AcceptedCheckbox extends Checkbox
{
    use CanHaveConditionFromState;
    use HasInfoAction;

    protected null|Closure|bool $compact = null;

    protected Model $condition;

    public static function getDefaultName(): ?string
    {
        return 'accepted';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->belowContent(fn () => $this->getConditionDescription());

        $this->label(fn () => $this->getConditionLabel());

        $this->required(fn () => ! $this->getConditionRecord()->isSkippable());

        $this->validationMessages(
            __('betta-terms::fields.term.validation')
        );
    }

    protected function getConditionLabel(): string
    {
        return ($this->isCompact() || $this->isSimple())
            ? $this->getConditionName()
            : __('betta-terms::actions.accept.label');
    }

    public function isCompact(): bool
    {
        return (bool) $this->evaluate($this->compact);
    }

    public function compact(bool|Closure $condition = true): static
    {
        $this->compact = $condition;

        return $this;
    }
}
