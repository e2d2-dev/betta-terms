<?php

return [
    'source' => [
        'label' => 'Fuente',
        'description' => 'Se bloqueará tan pronto como alguien acepte esta condición.',
        'url' => [
            'label' => 'URL',
            'validation' => [
                'url' => 'No es una URL válida',
                'required' => 'La URL es obligatoria',
                'check' => 'Se produjo un error durante la verificación: :code',
            ],
        ],
    ],
    'is_active' => [
        'label' => 'Activo',
    ],
    'consent' => [
        'label' => 'Consentimiento',
    ],
    'accepted' => [
        'label' => 'Aceptado',
    ],
    'created' => [
        'label' => 'Creado',
    ],
    'created_at' => [
        'label' => 'Creado el',
    ],
    'at' => [
        'label' => 'En',
    ],
    'term' => [
        'validation' => [
            'required' => 'Debe ser aceptado',
        ],
    ],
    'file' => [
        'validation' => [
            'required' => 'El archivo es obligatorio',
        ],
    ],
    'text' => [
        'validation' => [
            'required' => 'El texto es obligatorio',
        ],
    ],
    'email' => [
        'label' => 'Correo electrónico',
    ],
    'name' => [
        'label' => 'Nombre',
    ],
    'signed_on' => [
        'label' => 'El',
    ],
    'skippable' => [
        'label' => 'Omitible',
    ],
    'description' => [
        'label' => 'Descripción',
    ],
    'as_file' => [
        'label' => 'Como archivo',
    ],
    'compact' => [
        'label' => 'Compacto',
        'view' => 'Versión compacta',
    ],
];
