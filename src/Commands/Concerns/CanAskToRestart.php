<?php

namespace Betta\Terms\Commands\Concerns;

trait CanAskToRestart
{
    protected function shouldRestart(): bool
    {
        $choice = $this->choice('Do you want to restart?', ['no', 'yes'], 'yes');

        return $choice === 'yes';
    }
}
