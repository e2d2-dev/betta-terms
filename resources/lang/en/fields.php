<?php

return [
    'source' => [
        'label' => 'Source',
        'description' => 'Will be locked as soon as someone agreed to this condition.',
        'url' => [
            'label' => 'Url',
            'validation' => [
                'url' => 'Not a valid Url',
                'required' => 'Eingabe der Url ist erforderlich',
                'check' => 'Beim Überprüfen ist ein Fehler aufgetreten: :code',
            ],
        ],
    ],
    'is_active' => [
        'label' => 'Active',
    ],
    'consent' => [
        'label' => 'Consent',
    ],
    'accepted' => [
        'label' => 'Accepted',
    ],
    'created' => [
        'label' => 'Created',
    ],
    'created_at' => [
        'label' => 'Created at',
    ],
    'at' => [
        'label' => 'At',
    ],
    'term' => [
        'validation' => [
            'required' => 'Needs to be accepted',
        ],
    ],
    'file' => [
        'validation' => [
            'required' => 'A file is mandatory',
        ],
    ],
    'text' => [
        'validation' => [
            'required' => 'Text is mandatory',
        ],
    ],
    'email' => [
        'label' => 'E-Mail',
    ],
    'name' => [
        'label' => 'Name',
    ],
    'signed_on' => [
        'label' => 'On',
    ],
    'skippable' => [
        'label' => 'Skippable',
    ],
    'description' => [
        'label' => 'Description',
    ],
    'as_file' => [
        'label' => 'As file',
    ],
    'compact' => [
        'label' => 'Compact',
        'view' => 'Compact version',
    ],
    'persistent' => [
        'label' => 'Persistent',
    ],
];
