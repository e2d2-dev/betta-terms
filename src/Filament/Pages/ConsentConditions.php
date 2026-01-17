<?php

namespace Betta\Terms\Filament\Pages;

use Betta\Terms\Events\ConsentComplete;
use Betta\Terms\Filament\Forms\ConsentComponent;
use Betta\Terms\Filament\Pages\ConsentConditions\HasContent;
use Betta\Terms\Filament\Pages\ConsentConditions\HasContentActions;
use Betta\Terms\Filament\Pages\ConsentConditions\HasLayout;
use Betta\Terms\Terms;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Schema $content
 */
class ConsentConditions extends Page implements HasActions, HasSchemas
{
    use HasContent;
    use HasContentActions;
    use HasLayout;

    protected string $view = 'betta-terms::conditions';

    protected Width|string|null $maxContentWidth = '4xl';

    protected static bool $shouldRegisterNavigation = true;

    public function __construct()
    {
        Terms::setUpConsentConditions();
    }

    public function getRecord(): Model
    {
        return auth()->user();
    }

    public function mount(): void
    {
        if (! Terms::hasNextSessionGuard()) {
            $url = redirect()->back()->getTargetUrl();
            $this->redirect($url, navigate: FilamentView::hasSpaMode($url));
        }
        $this->content->fill();
    }

    public static function getComponents(): array
    {
        return [
            ConsentComponent::make()
                ->hiddenLabel(),
        ];
    }

    public function save(): void
    {
        $this->content->saveRelationships();

        $guard = Terms::getGuard();

        ConsentComplete::dispatch(
            auth()->user(),
            Terms::getIntendedUrl(),
            $guard,
        );

        Terms::clearSessionGuard($guard);

        $url = Terms::getNextUrl();

        $this->redirect($url, navigate: FilamentView::hasSpaMode($url));
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return config('betta-terms.page.consent_conditions.slug', 'consent-conditions');
    }
}
