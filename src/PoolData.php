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
    private int $expiration = 5;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }

    public function toArray()
    {
        return Cache::remember(
            'cp_stake_pool_' . $this->postId,
            [$this, 'getAll'],
            $this->expiration * MINUTE_IN_SECONDS
        );
    }

    public function getInfo(): array
    {
        $poolId = get_post_meta($this->postId, 'pool_id', true);
        $network = get_post_meta($this->postId, 'pool_network', true);

        return (new Blockfrost($network))->getPoolInfo($poolId);
    }

    public function getDetails(): array
    {
        $poolId = get_post_meta($this->postId, 'pool_id', true);
        $network = get_post_meta($this->postId, 'pool_network', true);

        return (new Blockfrost($network))->getPoolDetails($poolId);
    }

    public function getAll(): array
    {
        return array_merge($this->getInfo(), $this->getDetails());
    }
}
