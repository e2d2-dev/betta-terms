<?php

namespace Betta\Terms\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class ManyOpenConsents extends HasOneOrMany
{
    public function __construct(Builder $query, Model $parent, $foreignKey, $localKey, protected $consentRelation)
    {
        $this->localKey = $localKey;
        $this->foreignKey = $foreignKey;

        parent::__construct($query, $parent, $foreignKey, $localKey);
    }

    public function addConstraints(): void
    {
        $query = $this->getRelationQuery();

        $query->whereDoesntHaveRelation(
            $this->getConsentRelationName(),
            $this->getForeignKeyName(),
            '!=',
            $this->getLocalKeyName()
        );
    }

    public function initRelation(array $models, $relation)
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

    public function addEagerConstraints(array $models): void
    {

        $this->query
            ->select('id', 'name', 'description', 'slug', 'data')
            ->where('is_active', true)
            ->whereDoesntHaveRelation('consents', $this->getForeignKeyName(), $models[0]->getKey());
    }

    public function match(array $models, Collection $results, $relation): array
    {
        foreach ($models as $user) {
            $terms = $this->related->newCollection()->only('id', 'name', 'description', 'slug', 'data');

            $user->setRelation($relation, $terms);
        }

        return $models;
    }

    public function getConsentRelationName(): string
    {
        return $this->consentRelation;
    }
}
