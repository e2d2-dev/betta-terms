<?php

namespace Betta\Terms\Actions;

use Betta\Terms\Events\ConditionConsent;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class ConsentBySlug
{
    use AsAction;

    public function handle(Model $user, ?string $slug, ?string $signedOn = null): void
    {
        $condition = Terms::getModel('condition')::bySlug($slug);

        if ($condition) {
            $consent = Terms::getModel('consent')::firstOrCreate([
                'user_id' => $user->getKey(),
                'condition_id' => $condition->getKey(),
            ], [
                'signed_on' => $signedOn,
            ]);

            ConditionConsent::dispatch($consent);
        }

    }
}
