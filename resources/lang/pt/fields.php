<?php

return [
    'source' => [
        'label' => 'Fonte',
        'description' => 'Será bloqueada assim que alguém aceitar esta condição.',
        'url' => [
            'label' => 'URL',
            'validation' => [
                'url' => 'URL inválida',
                'required' => 'A URL é obrigatória',
                'check' => 'Ocorreu um erro ao verificar: :code',
            ],
        ],
    ],
    'is_active' => [
        'label' => 'Ativo',
    ],
    'consent' => [
        'label' => 'Consentimento',
    ],
    'accepted' => [
        'label' => 'Aceito',
    ],
    'created' => [
        'label' => 'Criado',
    ],
    'created_at' => [
        'label' => 'Criado em',
    ],
    'at' => [
        'label' => 'Em',
    ],
    'term' => [
        'validation' => [
            'required' => 'Deve ser aceito',
        ],
    ],
    'file' => [
        'validation' => [
            'required' => 'Um arquivo é obrigatório',
        ],
    ],
    'text' => [
        'validation' => [
            'required' => 'O texto é obrigatório',
        ],
    ],
    'email' => [
        'label' => 'E-mail',
    ],
    'name' => [
        'label' => 'Nome',
    ],
    'signed_on' => [
        'label' => 'Em',
    ],
    'skippable' => [
        'label' => 'Ignorável',
    ],
    'description' => [
        'label' => 'Descrição',
    ],
    'as_file' => [
        'label' => 'Como arquivo',
    ],
    'compact' => [
        'label' => 'Compacto',
        'view' => 'Versão compacta',
    ],
];
