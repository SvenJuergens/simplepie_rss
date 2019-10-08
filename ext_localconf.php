<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SvenJuergens.simplepie_rss',
    'Simplepierssviewer',
    [
        'SimplePie' => 'list',

    ],
    // non-cacheable actions
    [
        'SimplePie' => '',

    ]
);

require_once(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('simplepie_rss') .
    'Resources/Private/Libraries/vendor/autoload.php'
);
