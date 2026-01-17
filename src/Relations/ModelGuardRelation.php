<?php

namespace Betta\Terms\Relations;

use Betta\Terms\Terms;

trait ModelGuardRelation
{
    public function hasModelGuard(): HasModelGuard
    {
        $instance = $this->newRelatedInstance(Terms::getModel('guard'));

        $query = $instance->newQuery();

        return new HasModelGuard(
            $query,
            $this,
        );
    }
}
