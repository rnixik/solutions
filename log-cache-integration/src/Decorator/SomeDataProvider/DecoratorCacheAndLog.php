<?php

namespace src\Decorator\SomeDataProvider;

use Psr\Cache\CacheException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\SomeDataProviderInterface;

class DecoratorCacheAndLog implements SomeDataProviderInterface
{
    /** @var SomeDataProviderInterface */
    protected $dataProvider;

    /** @var CacheItemPoolInterface */
    protected $cache;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(SomeDataProviderInterface $dataProvider, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->dataProvider = $dataProvider;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function get(array $request)
    {
        try {
            $cacheKey = $this->getCacheKey($request);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->dataProvider->get($request);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );

            $this->cache->save($cacheItem);

            return $result;
        } catch (CacheException $exception) {
            $this->logger->warning('Cache Exception at getting from SomeDataProvider', [
                'exception' => $exception,
            ]);
        } catch (\Exception $exception) {
            $this->logger->error('Exception at getting from SomeDataProvider', [
                'exception' => $exception,
                'some_data_provider_request' => $request,
            ]);
        } catch (\Throwable $exception) {
            $this->logger->critical('Critical error at getting from SomeDataProvider', [
                'exception' => $exception,
                'some_data_provider_request' => $request,
            ]);
        }

        return [];
    }

    /**
     * @param array $request
     * @return bool
     */
    public function clearCacheForRequest(array $request)
    {
        try {
            $cacheKey = $this->getCacheKey($request);
            return $this->cache->deleteItem($cacheKey);
        } catch (\Throwable $exception) {
            $this->logger->warning('Error at clearing cache for SomeDataProvider', [
                'exception' => $exception,
                'some_data_provider_request' => $request,
            ]);
        }

        return false;
    }

    /**
     * @param array $input
     * @return string|bool
     */
    protected function getCacheKey(array $input)
    {
        return json_encode($input);
    }
}
