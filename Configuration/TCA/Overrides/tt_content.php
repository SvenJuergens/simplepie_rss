<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'simplepie_rss',
    'Simplepierssviewer',
    'SimplePie RSS'
);

$pluginSignature = str_replace('_', '', 'simplepie_rss') . '_simplepierssviewer';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]=
    'layout, select_key, pages, recursive';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:simplepie_rss/Configuration/FlexForms/flexform__simplepierssviewer.xml'
);

/***************
 * TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'simplepie_rss',
    'Configuration/TypoScript',
    'SimplePie RSS'
);
