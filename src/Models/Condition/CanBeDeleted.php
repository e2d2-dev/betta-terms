<?php

namespace Betta\Terms\Models\Condition;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

trait CanBeDeleted
{
    protected static function bootCanBeDeleted(): void
    {
        static::deleting(function (self $condition) {
            $condition->deleteFile();
        });
    }

    public function isDeletable(): bool
    {
        return $this->consents()->count() === 0;
    }

    protected function deleteFile(): void
    {
        if (! $this->file) {
            return;
        }

        try {
            Storage::disk(config('betta-terms.fields.file.disk'))->delete($this->file);
        } catch (\Exception $e) {
            if (filament()->isServing()) {
                Notification::make()
                    ->danger()
                    ->body($e->getMessage())
                    ->send();
            }
        }
    }
}
