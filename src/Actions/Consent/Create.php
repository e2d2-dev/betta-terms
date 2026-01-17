<?php

namespace Betta\Terms\Actions\Consent;

use Betta\Terms\Contracts\CreateConsent;
use Betta\Terms\Events\ConditionConsent;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\Consent;
use Betta\Terms\Terms;

class Create implements CreateConsent
{
    public function handle($user, Condition $condition, ?string $consentSlug = null): bool
    {
        /** @var Consent $consent */
        $consent = Terms::getConsentModel()::firstOrCreate([
            'user_id' => $user->getKey(),
            'condition_id' => $condition->getKey(),
        ], [
            'signed_on' => $consentSlug,
            'is_repeating' => false,
        ]);

        $isFresh = $consent->wasRecentlyCreated;

        if ($isFresh) {
            ConditionConsent::dispatch($consent);
        }

        return $isFresh;
    }
}
