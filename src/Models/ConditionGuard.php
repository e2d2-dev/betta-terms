<?php

namespace Betta\Terms\Models;

use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConditionGuard extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'condition_id',
        'guard_id',
    ];

    public function getTable()
    {
        return Terms::getTable('condition_guard_pivot');
    }

    public function guardRecord(): BelongsTo
    {
        return $this->belongsTo(Terms::getModel('guard'));
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Terms::getModel('condition'));
    }
}
