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
use SvenJuergens\SimplepieRss\Service\SimplePieFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SimplePieController extends ActionController
{
    public function __construct(
        private readonly SimplePieFactory $simplePieFactory,
    ) {}

    public function listAction(): ResponseInterface
    {
        $feedUrl = (string)($this->settings['feedUrl'] ?? '');
        if ($feedUrl === '') {
            $this->view->assign('simplePies', []);
            return $this->htmlResponse();
        }

        $cacheLifetime = (int)($this->settings['cacheLifetime'] ?? SimplePieFactory::DEFAULT_CACHE_LIFETIME);
        $feed = $this->simplePieFactory->create($feedUrl, $cacheLifetime);
        $feed->init();

        $items = [];
        foreach ($feed->get_items(0, (int)($this->settings['itemLimit'] ?? 0)) as $item) {
            $items[] = [
                'date' => $item->get_date('d.m.Y'),
                'title' => $this->decodeEntities((string)$item->get_title()),
                'text' => $this->decodeEntities((string)$item->get_content()),
                'link' => $item->get_permalink(),
            ];
        }

        $this->view->assign('simplePies', $items);
        return $this->htmlResponse();
    }

    private function decodeEntities(string $value): string
    {
        if ($value === '') {
            return $value;
        }
        return html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
