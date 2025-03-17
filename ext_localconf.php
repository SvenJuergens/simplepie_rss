<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'simplepie_rss',
    'Simplepierssviewer',
    [
        \SvenJuergens\SimplepieRss\Controller\SimplePieController::class => 'list',

    ],
    // non-cacheable actions
    [
        \SvenJuergens\SimplepieRss\Controller\SimplePieController::class => '',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
