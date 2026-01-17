<?php
namespace Betta\Terms\Actions\Model;

use Betta\Terms\Actions\ConsentBySlug;
use Betta\Terms\Contracts\ModelConditions;
use Lorisleiva\Actions\Concerns\AsAction;

class CommitConsent
{
    use AsAction;

    public function handle(ModelConditions $record): void
    {
        $consent = $record->getSavedGuardConditions('consent');
        $slug = app(ModelConsentSlug::class);

        $committed = [];
        foreach ($consent as $key => $condition) {
            ConsentBySlug::run(auth()->user(), $slug->generate($record));
            $committed[] = $condition;
            unset($consent[$key]);
        }

        $record->updateQuietly([
            $record->guardConditionsAttribute() => array_filter([
                'consent' => $consent,
                'committed' => $committed,
            ]),
        ]);
    }
}
