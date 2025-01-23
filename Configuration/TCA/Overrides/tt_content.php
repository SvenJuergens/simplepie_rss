<?php

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'simplepie_rss',
    'Simplepierssviewer',
    'SimplePie RSS'
);

$pluginSignature = str_replace('_', '', 'simplepie_rss') . '_simplepierssviewer';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $pluginSignature, 'after:subheader');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:simplepie_rss/Configuration/FlexForms/flexform__simplepierssviewer.xml',
    $pluginSignature
);

/***************
 * TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'simplepie_rss',
    'Configuration/TypoScript',
    'SimplePie RSS'
);
