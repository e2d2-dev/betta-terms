<?php

namespace Betta\Terms\Commands\Concerns;

use Filament\Support\Commands\Concerns\CanOpenUrlInBrowser;

use function Laravel\Prompts\confirm;

trait AskToStar
{
    use CanOpenUrlInBrowser;

    protected function askToStar(): void
    {
        if (! confirm('All done! Would you like to show some love by starring this package on GitHub?', default: true)) {
            return;
        }

        $this->openUrlInBrowser('https://github.com/e2d2-dev/betta-terms');
    }
}
