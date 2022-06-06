<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Foundation\AbstractInstaller;

class Installer extends AbstractInstaller
{
    public const DATA_PREFIX = 'cp_stake-pools_';

    protected function initialize(): void
    {
    }

    public function setupHooks(): void
    {
        parent::setupHooks();

        add_action('admin_notices', [$this, 'noticeNeedingCorePlugin']);
    }
}
