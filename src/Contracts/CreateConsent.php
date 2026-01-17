<?php

namespace Betta\Terms\Contracts;

use App\Models\User;
use Betta\Terms\Models\Condition;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

interface CreateConsent
{
    /** @param Authenticatable | User | Model $user*/
    public function handle($user, Condition $condition, ?string $consentSlug = null): bool;
}
