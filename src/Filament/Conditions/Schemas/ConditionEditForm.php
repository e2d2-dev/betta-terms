<?php

namespace Betta\Terms\Filament\Conditions\Schemas;

use Betta\Terms\Filament\Conditions\Forms\DescriptionInput;
use Betta\Terms\Filament\Conditions\Forms\NameInput;
use Betta\Terms\Filament\Conditions\Schemas\Sections\LabelSection;
use Betta\Terms\Filament\Conditions\Schemas\Sections\PreviewSection;
use Betta\Terms\Filament\Conditions\Schemas\Sections\SourceSection;
use Betta\Terms\Models\Condition;
use Filament\Schemas\Schema;

class ConditionEditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                LabelSection::make()
                    ->schema([
                        NameInput::make()
                            ->disabled(fn (?Condition $record) => $record?->isObsolete())
                            ->hint(fn (?Condition $record) => $record && $record->revision
                                ? __('betta-terms::entities.revision.singular').': '.$record->revision
                                : ''),

                        DescriptionInput::make()
                            ->disabled(fn (?Condition $record) => $record && $record->isObsolete()),
                    ]),

                SourceSection::make(),

                PreviewSection::make(),
            ]);

    }
}
