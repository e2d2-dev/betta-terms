<?php

namespace Betta\Terms\Filament\Conditions\Pages;

use Betta\Terms\Filament\Conditions\Schemas\ConditionCreateForm;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

/**
 * @method Condition getRecord()
 */
class CreateCondition extends CreateRecord
{
    public static function getResource(): string
    {
        return Terms::getConditionResource();
    }

    public function form(Schema $schema): Schema
    {
        return ConditionCreateForm::configure($schema);
    }

    public function mount(): void
    {
        parent::mount();

        $this->form->fill(['guard_id' => $this->getGuardFromPreviousUrl()]);
    }

    protected function getGuardFromPreviousUrl(): ?string
    {
        $url = $this->previousUrl;
        if (! $url) {
            return null;
        }

        $str = str($url);
        if (! $str->contains('guards')) {
            return null;
        }

        return str($url)->after('guards/')->before('/')->toString();
    }

    public function afterCreate(): void
    {
        $guardId = $this->data['guard_id'] ?? null;

        if ($guardId === null) {
            return;
        }

        $this->getRecord()->guards()->attach($guardId);
    }
}
