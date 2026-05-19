<?php

declare(strict_types=1);

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'simplepie_rss',
    'Simplepierssviewer',
    [
        \SvenJuergens\SimplepieRss\Controller\SimplePieController::class => 'list',
    ],
    [
        \SvenJuergens\SimplepieRss\Controller\SimplePieController::class => '',
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][\SvenJuergens\SimplepieRss\Service\SimplePieFactory::CACHE_IDENTIFIER] ??= [
    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
    'backend' => \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class,
    'options' => [
        'defaultLifetime' => \SvenJuergens\SimplepieRss\Service\SimplePieFactory::DEFAULT_CACHE_LIFETIME,
    ],
    'groups' => ['system'],
];
