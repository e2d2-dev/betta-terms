<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Terms;
use Illuminate\Support\Collection;

trait HasConsentConditions
{
    public function getConsentConditions(): Collection
    {
        return auth()->user()->consents;
    }

    public function getConsentConditionIds($user = null): array
    {
        $user = $user ?: auth()->user();

        return Terms::getModel('consent')::query()
            ->where('user_id', $user->getKey())
            ->select('condition_id')
            ->pluck('condition_id')
            ->toArray();
    }
}
