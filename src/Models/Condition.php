<?php

namespace Betta\Terms\Models;

use Betta\Terms\Models\Condition\CanBeDeleted;
use Betta\Terms\Models\Condition\CanBeReplaced;
use Betta\Terms\Models\Condition\CanBeSkipped;
use Betta\Terms\Models\Condition\CanBeUsable;
use Betta\Terms\Models\Condition\HasConsents;
use Betta\Terms\Models\Condition\HasGuards;
use Betta\Terms\Models\Condition\HasSlug;
use Betta\Terms\Models\Condition\HasSource;
use Betta\Terms\Terms;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Condition extends Model
{
    use CanBeDeleted;
    use CanBeReplaced;
    use CanBeSkipped;
    use CanBeUsable;
    use HasConsents;
    use HasGuards;
    use HasSlug;
    use HasSource;

    public function getTable()
    {
        return Terms::getTable('condition');
    }

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
    ];

    public static function getPublicFillableAttributes(): array
    {
        return ['name', 'description', 'slug', 'source', 'text', 'url', 'file', 'has_file', 'created_at'];
    }

    public function isAccepted(): bool
    {
        return (bool) $this->accepted ?? false;
    }

    public function scopeGuard(Builder $query, ?Guard $guard): void
    {
        $query->whereRelation('guards', 'id', $guard?->getKey());
    }
}
