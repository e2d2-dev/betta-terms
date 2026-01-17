<?php

namespace Betta\Terms\Filament\Conditions\Schemas\Sections;

use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class LabelSection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->heading(__('betta-terms::entities.label.plural'));

        $this->icon(Heroicon::PencilSquare);

        $this->columns();

        $this->columnSpanFull();
    }
}
