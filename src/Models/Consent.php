<?php

namespace Betta\Terms\Models;

use App\Models\User;
use Betta\Terms\Terms;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property Condition $condition
 * @property User $user
 * @property string $signed_on
 * @property CarbonInterface $created_at
 */
class Consent extends Pivot
{
    const UPDATED_AT = null;

    public function getTable()
    {
        return Terms::getTable('consent');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Terms::getModel('user'));
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Terms::getModel('condition'));
    }
}
