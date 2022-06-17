<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use PBWebDev\CardanoPress\Blockfrost;
use WP_Error;

class PoolData
{
    protected int $postId;
    protected string $poolId;
    protected string $network;

    public const EXPIRATION = 15; // in minutes

    public const INFO_STRUCTURE = [
        'pool_id' => '',
        'hex' => '',
        'vrf_key' => '',
        'blocks_minted' => 0,
        'blocks_epoch' => 0,
        'live_stake' => 0,
        'live_size' => 0.0,
        'live_saturation' => 0.0,
        'live_delegators' => 0,
        'active_stake' => 0,
        'active_size' => 0.0,
        'declared_pledge' => 0,
        'live_pledge' => 0,
        'margin_cost' => 0.0,
        'fixed_cost' => 0,
        'reward_account' => '',
        'owners' => [''],
        'registration' => [''],
        'retirement' => [''],
    ];

    public const DETAILS_STRUCTURE = [
        'url' => '',
        'hash' => '',
        'ticker' => '',
        'name' => '',
        'description' => '',
        'homepage' => '',
    ];

    public function __construct(int $postId)
    {
        $this->postId = $postId;
        $this->poolId = get_post_meta($this->postId, 'pool_id', true);
        $this->network = get_post_meta($this->postId, 'pool_network', true);
    }

    public function toArray()
    {
        $poolData = Application::getInstance()->cacheManager()->assign('post_' . $this->postId)->remember(
            'cp_stake_pool',
            [$this, 'getAll'],
            self::EXPIRATION * MINUTE_IN_SECONDS
        );

        if (empty($poolData) || is_wp_error($poolData)) {
            return array_merge(self::INFO_STRUCTURE, self::DETAILS_STRUCTURE);
        }

        return $poolData;
    }

    public function getInfo(): array
    {
        if (! Application::getInstance()->isReady()) {
            return self::INFO_STRUCTURE;
        }

        return (new Blockfrost($this->network))->getPoolInfo($this->poolId);
    }

    public function getDetails(): array
    {
        if (! Application::getInstance()->isReady()) {
            return self::DETAILS_STRUCTURE;
        }

        return (new Blockfrost($this->network))->getPoolDetails($this->poolId);
    }

    public function getAll()
    {
        $poolData = array_merge($this->getInfo(), $this->getDetails());

        if ($poolData === array_merge(self::INFO_STRUCTURE, self::DETAILS_STRUCTURE)) {
            return new WP_Error(Admin::OPTION_KEY, __('Application not ready', 'cardanopress-stake-pools'));
        }

        if (empty($poolData)) {
            return new WP_Error(Admin::OPTION_KEY, __('Blockfrost not ready', 'cardanopress-stake-pools'));
        }

        return $poolData;
    }
}
