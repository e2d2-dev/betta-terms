<?php

namespace Betta\Terms\Actions\Model;

use Betta\Terms\Contracts\CreateConsent;
use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\Guard;
use Illuminate\Database\Eloquent\Collection;

class CommitConsent
{
    public function handle(ModelConditions $record): void
    {
        $guard = $record->consentGuard;
        $conditions = $this->filterConditions($guard, $record->getSavedGuardConditions('consent'));

        $consentSlug = app(ModelConsentSlug::class);

        $committed = $record->getSavedGuardConditions('committed');

        /** @var Condition $condition */
        foreach ($conditions as $key => $condition) {
            $slug = $condition->slug;

            $action = app(CreateConsent::class, ['condition' => $condition]);

            $action->handle(auth()->user(), $condition, $consentSlug->generate($record));

            $committed[] = $slug;
            unset($conditions[$key]);
        }
        $consent = $conditions->keyBy('slug')->keys()->toArray();
        $committed = array_unique($committed);

        $this->handleRecord($record, $consent, $committed);
    }

    protected function handleRecord(ModelConditions $record, array $consent, array $committed): void
    {
        $record->updateQuietly([
            $record->guardConditionsAttribute() => array_filter([
                'consent' => $consent,
                'committed' => $committed,
            ]),
        ]);
    }

    protected function filterConditions(Guard $guard, array $consents): Collection
    {
        return $guard->activeConditions()->whereIn('slug', $consents)->get();
    }
}
