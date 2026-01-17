<?php

namespace Betta\Terms\Filament\Forms;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class TermRepeater extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        // $this->aside();

        $this->compact();

        $this->heading(fn ($state) => count($state) > 1
            ? __('betta-terms::models.term.singular')
            : __('betta-terms::models.term.plural')
        );

        $this->schema([

            Repeater::make('terms')
                ->deletable(false)
                ->addable(false)
                ->reorderable(false)
                ->hiddenLabel()
                ->schema([
                    Group::make(function ($state) {
                        return [
                            Checkbox::make('accepted')
                                ->belowContent($state['description'] ?? null)
                                ->hintAction(
                                    Action::make('accepted')
                                        ->modalHeading($state['name'])
                                        ->modalDescription($state['description'] ?? null)
                                        ->modalSubmitAction(false)
                                        ->modalIcon(Heroicon::MagnifyingGlass)
                                        ->icon(Heroicon::MagnifyingGlass)
                                        ->color('warning')
                                        ->iconButton()
                                        ->schema(fn () => [
                                            TextEntry::make('text')
                                                ->hiddenLabel()
                                                ->html()
                                                ->state($state['text']),
                                        ])
                                )
                                ->label(fn ($get) => $get('name'))
                                ->required()
                                ->validationMessages(
                                    __('betta-terms::fields.term.validation')
                                ),
                        ];
                    }),
                ]),
        ]);
    }
}
