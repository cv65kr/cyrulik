<?php

declare(strict_types=1);

namespace App\Service;

use App\Api\PlanHandler;
use App\Model\Plan\PlanCollection;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

final class PlanService
{
    private const CACHE_PLANS_KEY = 'cache.plans';

    /** @var PlanHandler */
    private $planHandler;

    /** @var CacheItemPoolInterface */
    private $cacheItemPool;

    /** @var LoggerInterface */
    private $logger;

    /**
     * PlanService constructor.
     */
    public function __construct(PlanHandler $planHandler, CacheItemPoolInterface $cacheItemPool, LoggerInterface $logger)
    {
        $this->planHandler = $planHandler;
        $this->cacheItemPool = $cacheItemPool;
        $this->logger = $logger;
    }

    public function getPlans(): PlanCollection
    {
        try {
            $plansCache = $this->cacheItemPool->getItem(self::CACHE_PLANS_KEY);
            if (!$plansCache->isHit()) {
                $plans = $this->planHandler->getPlans();
                if (null === $plans) {
                    return new PlanCollection();
                }

                $plansCache->set($plans);
                $this->cacheItemPool->save($plansCache);
            } else {
                $plans = $plansCache->get();
            }

            return $plans;
        } catch (\Exception $e) {
            $this->logger->error('ERROR', [
                'message' => $e->getMessage(),
            ]);
        }

        return new PlanCollection();
    }
}
