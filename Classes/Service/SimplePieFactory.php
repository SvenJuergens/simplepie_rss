<?php

declare(strict_types=1);

namespace SvenJuergens\SimplepieRss\Service;

use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Client\ClientInterface;
use SimplePie\SimplePie;
use SvenJuergens\SimplepieRss\Cache\Psr16CacheAdapter;
use TYPO3\CMS\Core\Cache\CacheManager;

/**
 * Builds a SimplePie instance wired into TYPO3:
 * - PSR-16 cache backed by the TYPO3 Caching Framework cache "simplepie_rss"
 * - PSR-18 HTTP client resolved via DI, which TYPO3 aliases to the
 *   TYPO3-configured Guzzle client (honours $GLOBALS['TYPO3_CONF_VARS']['HTTP'],
 *   e.g. proxy and SSL).
 */
final class SimplePieFactory
{
    public const CACHE_IDENTIFIER = 'simplepie_rss';
    public const DEFAULT_CACHE_LIFETIME = 3600;

    public function __construct(
        private readonly CacheManager $cacheManager,
        private readonly ClientInterface $httpClient,
    ) {}

    public function create(string $feedUrl, int $cacheLifetime = self::DEFAULT_CACHE_LIFETIME): SimplePie
    {
        $feed = new SimplePie();
        $feed->set_cache(new Psr16CacheAdapter($this->cacheManager->getCache(self::CACHE_IDENTIFIER)));
        $feed->set_cache_duration($cacheLifetime);

        $httpFactory = new HttpFactory();
        $feed->set_http_client($this->httpClient, $httpFactory, $httpFactory);

        $feed->set_feed_url($feedUrl);
        $feed->enable_order_by_date(false);

        return $feed;
    }
}
