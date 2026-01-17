<?php

return [
    'source' => [
        'label' => 'Quelle',
        'description' => 'Gesperrt sobald mindestens einmal zugestimmt',
        'url' => [
            'label' => 'Url',
            'validation' => [
                'url' => 'Keine gültige Url',
                'required' => 'Eingabe der Url ist erforderlich',
                'check' => 'Beim Überprüfen ist ein Fehler aufgetreten: :code',
            ],
        ],
    ],
    'is_active' => [
        'label' => 'Aktiv',
    ],
    'consent' => [
        'label' => 'Zugestimmt',
    ],
    'accepted' => [
        'label' => 'Zugestimmt',
    ],
    'created' => [
        'label' => 'Erstellt',
    ],
    'created_at' => [
        'label' => 'Erstellt am',
    ],
    'at' => [
        'label' => 'Am',
    ],
    'term' => [
        'validation' => [
            'required' => 'Muss akzeptiert werden',
        ],
    ],
    'file' => [
        'validation' => [
            'required' => 'Eine Datei ist erforderlich',
        ],
    ],
    'text' => [
        'validation' => [
            'required' => 'Text ist erforderlich',
        ],
    ],
    'email' => [
        'label' => 'E-Mail',
    ],
    'name' => [
        'label' => 'Name',
    ],
    'signed_on' => [
        'label' => 'Auf',
    ],
    'skippable' => [
        'label' => 'Überspringbar',
    ],
    'description' => [
        'label' => 'Beschreibung',
    ],
    'as_file' => [
        'label' => 'Als Datei',
    ],
    'compact' => [
        'label' => 'Kompakt',
        'view' => 'Kompakte Anzeige',
    ],
];
