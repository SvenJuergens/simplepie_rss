<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    // Icon identifier
    'tx-simplepie-rss' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:simplepie_rss/Resources/Public/Icons/Extension.svg',
    ],
];
