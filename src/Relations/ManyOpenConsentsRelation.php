<?php

namespace Betta\Terms\Relations;

trait ManyOpenConsentsRelation
{
    public function manyOpenConsents(string $related, ?string $foreignKey = null, ?string $localKey = null, string $consentRelation = 'consents'): ManyOpenConsents
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        $query = $instance->newQuery();

        return new ManyOpenConsents(
            $query,
            $this,
            $foreignKey,
            $localKey,
            $consentRelation,
        );
    }
}
