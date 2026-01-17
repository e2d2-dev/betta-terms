<?php

namespace Betta\Terms\Models\Condition;

use Betta\Terms\Actions\Condition\Replace;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\Condition\CanBeReplaced\CanBeObsolete;
use Betta\Terms\Models\Condition\CanBeReplaced\HasPredecessor;
use Betta\Terms\Models\Condition\CanBeReplaced\HasRevision;
use Betta\Terms\Models\Condition\CanBeReplaced\HasSuccessor;

trait CanBeReplaced
{
    use CanBeObsolete;
    use HasPredecessor;
    use HasRevision;
    use HasSuccessor;

    public function replace(): Condition
    {
        return Replace::run($this);
    }

    public function getPivotActive(): bool
    {
        return (bool) $this->pivot->is_active;
    }

    public function willBeReplaced(): bool
    {
        return $this->hasSuccessor() and $this->getPivotActive() == true;
    }

    public function willReplace(): bool
    {
        return $this->hasPredecessor() and $this->getPivotActive() == false;
    }
}
