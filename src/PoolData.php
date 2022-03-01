<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use ThemePlate\Cache;

class PoolData
{
    private int $postId;
    private string $poolId;
    private string $network;
    private const EXPIRATION = 5;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
        $this->poolId = get_post_meta($this->postId, 'pool_id', true);
        $this->network = get_post_meta($this->postId, 'pool_network', true);
    }

    public function toArray()
    {
        return Cache::remember(
            'cp_stake_pool_' . $this->postId,
            [$this, 'getAll'],
            self::EXPIRATION * MINUTE_IN_SECONDS
        );
    }

    public function getInfo(): array
    {
        $application = Application::instance();

        if (! $application->coreActive()) {
            return [];
        }

        return (new Blockfrost($this->network))->getPoolInfo($this->poolId);
    }

    public function getDetails(): array
    {
        $application = Application::instance();

        if (! $application->coreActive()) {
            return [];
        }

        return (new Blockfrost($this->network))->getPoolDetails($this->poolId);
    }

    public function getAll(): array
    {
        return array_merge($this->getInfo(), $this->getDetails());
    }
}
