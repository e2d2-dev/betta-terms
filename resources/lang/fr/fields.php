<?php

return [
    'source' => [
        'label' => 'Source',
        'description' => 'Sera verrouillée dès qu’une personne aura accepté cette condition.',
        'url' => [
            'label' => 'URL',
            'validation' => [
                'url' => 'URL invalide',
                'required' => 'L’URL est requise',
                'check' => 'Erreur lors de la vérification : :code',
            ],
        ],
    ],
    'is_active' => [
        'label' => 'Actif',
    ],
    'consent' => [
        'label' => 'Consentement',
    ],
    'accepted' => [
        'label' => 'Accepté',
    ],
    'created' => [
        'label' => 'Créé',
    ],
    'created_at' => [
        'label' => 'Créé le',
    ],
    'at' => [
        'label' => 'À',
    ],
    'term' => [
        'validation' => [
            'required' => 'Doit être accepté',
        ],
    ],
    'file' => [
        'validation' => [
            'required' => 'Un fichier est obligatoire',
        ],
    ],
    'text' => [
        'validation' => [
            'required' => 'Le texte est obligatoire',
        ],
    ],
    'email' => [
        'label' => 'E-mail',
    ],
    'name' => [
        'label' => 'Nom',
    ],
    'signed_on' => [
        'label' => 'Le',
    ],
    'skippable' => [
        'label' => 'Ignorable',
    ],
    'description' => [
        'label' => 'Description',
    ],
    'as_file' => [
        'label' => 'Comme fichier',
    ],
    'compact' => [
        'label' => 'Compact',
        'view' => 'Version compacte',
    ],
];
