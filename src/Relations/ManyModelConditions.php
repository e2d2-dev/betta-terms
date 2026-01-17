<?php

namespace Betta\Terms\Relations;

use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManyModelConditions extends HasMany
{
    public function __construct($query, public $parent)
    {
        parent::__construct($query, $parent, '', '');
    }

    public function getParentClassName(): string
    {
        return get_class($this->getParent());
    }

    public function getParentClassSlug(): string
    {
        return Terms::getModelSlug($this->getParentClassName());
    }

    public function addConstraints(): void
    {
        $query = $this->getRelationQuery();

        $query->whereRelation('guards', 'slug', $this->getParentClassSlug())->get();
    }

    public function addEagerConstraints(array $models): void
    {
        $this->query->whereRelation('guards', 'model', $this->getParentClassSlug());
    }

    public function match(array $models, EloquentCollection $results, $relation): array
    {
        foreach ($models as $model) {
            $conditions = $this->related->newCollection();

            $model->setRelation($relation, $conditions);
        }

        return $models;
    }

    public function initRelation(array $models, $relation): array
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    public function getResults()
    {
        return $this->query->get();
    }
}
