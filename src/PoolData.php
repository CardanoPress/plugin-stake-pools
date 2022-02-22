<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use ThemePlate\Cache;

class PoolData
{
    private string $id;
    private int $expiration = 5;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function toArray()
    {
        return Cache::remember(
            'cp_stake_pool_' . $this->id,
            [$this, 'getDetails'],
            $this->expiration * MINUTE_IN_SECONDS
        );
    }

    public function getDetails()
    {
        $network = get_post_meta($this->id, 'pool_network', true);
        $blockfrost = new Blockfrost($network);
        $poolId = get_post_meta($this->id, 'pool_id', true);

        return $blockfrost->getPoolInfo($poolId);
    }
}
