<?php

namespace Betta\Terms\Models;

use Betta\Terms\Models\Guard\HasConditions;
use Betta\Terms\Models\Guard\HasModel;
use Betta\Terms\Models\Guard\HasName;
use Betta\Terms\Models\Guard\HasPanel;
use Betta\Terms\Models\Guard\HasSlug;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Model;

class Guard extends Model
{
    use HasConditions;
    use HasModel;
    use HasName;
    use HasPanel;
    use HasSlug;

    public function getTable()
    {
        return Terms::getTable('guard');
    }

    public function authHasOpenConsents(): bool
    {
        $user = auth()->user();

        if(!$user) return false;

        $consented = $user->consents->pluck('id');

        return $this->activeConditions()->whereNotIn('id', $consented)->count() > 0;
    }
}
