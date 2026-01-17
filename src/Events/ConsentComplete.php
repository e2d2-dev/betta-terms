<?php

namespace Betta\Terms\Events;

use Betta\Terms\Models\Guard;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsentComplete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($user, ?string $signedOn = null, ?Guard $guard = null)
    {
        //
    }
}
