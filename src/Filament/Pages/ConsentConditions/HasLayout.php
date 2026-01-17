<?php

namespace Betta\Terms\Filament\Pages\ConsentConditions;

use Betta\Terms\Traits\ResolveClosure;
use Closure;
use Illuminate\Contracts\Support\Htmlable;

trait HasLayout
{
    use ResolveClosure;

    protected static ?Closure $generateHeadingUsing = null;

    public static function isSimple(): bool
    {
        return false;
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function getHeading(): string|Htmlable|null
    {
        $using = self::$generateHeadingUsing;
        if (is_callable($using)) {
            return $this->resolveClosure($using, ['livewire' => $this]);
        }

        return __('betta-terms::models.term.plural');
    }

    public static function generateHeadingUsing(Closure $callback): void
    {
        static::$generateHeadingUsing = $callback;
    }

    public function getTitle(): string|Htmlable
    {
        return __('betta-terms::models.condition.plural');
    }
}
