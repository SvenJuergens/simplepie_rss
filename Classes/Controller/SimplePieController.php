<?php

declare(strict_types=1);

namespace SvenJuergens\SimplepieRss\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use Psr\Http\Message\ResponseInterface;
use SimplePie;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SimplePieController extends ActionController
{
    protected function initializeAction(): void
    {
        if (!is_dir($this->getCacheFolder())) {
            GeneralUtility::mkdir($this->getCacheFolder());
        }
    }

    /**
     * action list
     */
    public function listAction(): ResponseInterface
    {
        $feed = new SimplePie\SimplePie();
        $feed->enable_cache(true);
        $feed->set_cache_duration(3600);
        $feed->set_cache_location($this->getCacheFolder());
        // Set which feed to process.
        $feed->set_feed_url($this->settings['feedUrl']);
        $feed->enable_order_by_date(false);

        // Run SimplePie.
        $feed->init();

        // This makes sure that the content is sent to the browser as
        // text/html and the UTF-8 character set (since we didn't change it).
        $feed->handle_content_type();
        $items = [];
        foreach ($feed->get_items(0, (int)($this->settings['itemLimit']?? 0)) as $item) {
            $markerArray = [
                'date' => $item->get_local_date('%d.%m.%Y'),
                'title' => $this->cleanContent(html_entity_decode((string)$item->get_title())) ,
                'text' => $this->cleanContent((string)$item->get_content()),
                'link' => $item->get_permalink(),
            ];
            $items[] = $markerArray;
        }

        $this->view->assign('simplePies', $items);
        return $this->htmlResponse();
    }

    private function getCacheFolder(): string
    {
        $pathSite = Environment::getPublicPath() . '/';
        return  $pathSite . 'typo3temp' . DIRECTORY_SEPARATOR . 'tx_simplepierss' . DIRECTORY_SEPARATOR;
    }

    public function cleanContent(string $string = ''): string
    {
        if (empty($string)) {
            return $string;
        }
        //unicode Symbole wie '&#xfc;' ersetzen
        // html_entity_decode holft da nicht
        $replace = [
            '&Uuml;' => 'Ü',
            '&#xDC;' => 'Ü',
            '&uuml;' => 'ü',
            '&#xfc;' => 'ü',
            '&Auml;' => 'Ä',
            '&#xC4;' => 'Ä',
            '&auml;' => 'ä',
            '&#xE4;' => 'ä',
            '&Ouml;' => 'Ö',
            '&#xD6;' => 'Ö',
            '&ouml;' => 'ö',
            '&#xF6;' => 'ö',
            '&szlig' => 'ß',
            '&#xDF;' => 'ß',
            '&#xdf;' => 'ß',
            '&#x2014;' => '—',

        ];
        return strtr($string, $replace);
    }
}
