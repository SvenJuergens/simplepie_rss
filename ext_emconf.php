<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'SimplePie RSS',
    'description' => 'Show an RSS Feed with SimplePie',
    'category' => 'plugin',
    'author' => 'Sven Juergens',
    'author_email' => '',
    'state' => 'stable',
    'version' => '3.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
