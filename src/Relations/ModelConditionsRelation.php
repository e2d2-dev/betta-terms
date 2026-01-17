<?php

namespace Betta\Terms\Relations;

use Betta\Terms\Terms;

trait ModelConditionsRelation
{
    public function manyModelConditions(): ManyModelConditions
    {
        $instance = $this->newRelatedInstance(Terms::getConditionModel());

        $query = $instance->newQuery();

        return new ManyModelConditions(
            $query,
            $this,
        );
    }
}
