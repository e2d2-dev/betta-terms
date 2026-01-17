<?php

namespace Betta\Terms\Filament\Guards\Tables\Actions;

use Betta\Terms\Filament\Guards\Tables\Columns\Concerns\HasPredecessor;
use Betta\Terms\Models\Condition;
use Filament\Actions\DetachAction as BaseDetachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method Condition getRecord()
 */
class DetachAction extends BaseDetachAction
{
    use HasPredecessor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabled(
            /** @param Condition $record */
            fn (Model $record) => $record->isObsolete() || $this->hasActivePredecessor($record)
        );

        /** @param Condition $record */
        $this->using(function (Model $record, Table $table): void {
            $successor = $record->successor;

            /** @var BelongsToMany $relationship */
            $relationship = $table->getRelationship();

            $relationship->detach($record);

            if ($successor) {
                $relationship->detach($successor);
            }
        });
    }
}
