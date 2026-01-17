<?php

namespace Betta\Terms\Events\Condition;

use Betta\Terms\Models\Condition;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuccessorActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  Condition  $condition
     */
    public function __construct($condition)
    {
        //
    }
}
