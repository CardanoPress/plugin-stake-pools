<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use PBWebDev\CardanoPress\Manifest as BaseManifest;

class Manifest extends BaseManifest
{
    protected string $prefix = 'cp-stake-pools-';

    protected function fireInjectors(): void
    {
    }

    protected function getAssetsBase(): string
    {
        return plugin_dir_url(CP_STAKE_POOLS_FILE) . 'assets/dist/';
    }

    protected function autoEnqueues(): void
    {
    }
}
