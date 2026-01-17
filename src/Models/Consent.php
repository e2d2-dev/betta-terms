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
 * @property bool $is_repeating
 * @property CarbonInterface $created_at
 */
class Consent extends Pivot
{
    const UPDATED_AT = null;

    protected $casts = [
        'is_repeating' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return Terms::getTable('consent');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Terms::getUserModel());
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Terms::getConditionModel());
    }
}
