<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'TYPO3.' . $_EXTKEY,
    'Simplepierssviewer',
    array(
        'SimplePie' => 'list',

    ),
    // non-cacheable actions
    array(
        'SimplePie' => '',

    )
);
