<?php

namespace Betta\Terms\Models;

use Betta\Terms\Models\Condition\CanBeDeleted;
use Betta\Terms\Models\Condition\CanBePersistent;
use Betta\Terms\Models\Condition\CanBeReplaced;
use Betta\Terms\Models\Condition\CanBeSkipped;
use Betta\Terms\Models\Condition\CanBeUsable;
use Betta\Terms\Models\Condition\HasConsents;
use Betta\Terms\Models\Condition\HasGuards;
use Betta\Terms\Models\Condition\HasSlug;
use Betta\Terms\Models\Condition\HasSource;
use Betta\Terms\Terms;
use Betta\Terms\Traits\FromArray;
use Carbon\CarbonInterface;
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
    use CanBePersistent;
    use CanBeReplaced;
    use CanBeSkipped;
    use CanBeUsable;
    use FromArray;
    use HasConsents;
    use HasGuards;
    use HasSlug;
    use HasSource;

    public function getTable()
    {
        return Terms::getTable('condition');
    }

    protected $fillable = [
        'name',
        'description',
        'accepted',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
    ];
}
