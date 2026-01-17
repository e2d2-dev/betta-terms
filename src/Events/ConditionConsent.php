<?php

namespace Betta\Terms\Events;

use Betta\Terms\Models\Consent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConditionConsent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  Consent  $consent
     */
    public function __construct($consent)
    {
        //
    }
}
