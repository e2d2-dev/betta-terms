<?php

return [
    'session' => [
        'key' => 'betta-terms',
    ],
    'tables' => [
        'condition' => 'term_conditions',
        'guard' => 'term_guards',
        'consent' => 'term_consent',
        'condition_guard_pivot' => 'term_condition_guard',
    ],
    'page' => [
        'consent_conditions' => [
            'topbar' => true,
            'global_search' => false,
            'navigation' => false,
            'component' => Betta\Terms\Filament\Pages\ConsentConditions::class,
            'slug' => 'consent-conditions',
        ],
    ],
    'resources' => [
        'slug-prefix' => 'terms',
        'group' => 'betta-terms::nav.group',
        'condition' => [
            'component' => Betta\Terms\Filament\Conditions\ConditionResource::class,
            'icon' => \Filament\Support\Icons\Heroicon::Newspaper,
            'registerNavigation' => true,
        ],
        'guard' => [
            'component' => Betta\Terms\Filament\Guards\GuardResource::class,
            'icon' => \Filament\Support\Icons\Heroicon::ShieldCheck,
            'registerNavigation' => true,
        ],
        'consent' => [
            'component' => Betta\Terms\Filament\Consents\ConsentResource::class,
            'icon' => \Filament\Support\Icons\Heroicon::CheckBadge,
            'registerNavigation' => true,
        ],
    ],
    'middleware' => [
        'panel' => Betta\Terms\Middleware\PanelConsentGuard::class,
    ],
    'fields' => [
        'file' => [
            'disk' => 'public',
            'visibility' => 'public',
            'directory' => 'terms',
        ],
    ],
    'models' => [
        'condition' => Betta\Terms\Models\Condition::class,
        'guard' => Betta\Terms\Models\Guard::class,
        'consent' => Betta\Terms\Models\Consent::class,
        'condition_guard' => Betta\Terms\Models\ConditionGuard::class,
        'user' => App\Models\User::class,
    ],
    'slug' => [
        'model' => [
            'prefix' => 'model//',
        ],
        'panel' => [
            'prefix' => 'panel//',
        ],
    ],
];
