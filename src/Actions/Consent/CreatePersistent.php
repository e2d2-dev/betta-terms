<?php

namespace Betta\Terms\Actions\Consent;

use Betta\Terms\Contracts\CreateConsent;
use Betta\Terms\Events\ConditionConsent;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;

class CreatePersistent implements CreateConsent
{
    public function handle($user, Condition $condition, ?string $consentSlug = null): bool
    {
        $consent = Terms::getConsentModel()::create([
            'user_id' => $user->getKey(),
            'condition_id' => $condition->getKey(),
            'signed_on' => $consentSlug,
            'is_repeating' => true,
        ]);

        ConditionConsent::dispatch($consent);

        return true;
    }
}
