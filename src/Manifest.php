<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Foundation\AbstractManifest;

class Manifest extends AbstractManifest
{
    public const HANDLE_PREFIX = 'cp-stake-pools-';

    protected function initialize(): void
    {
    }

    public function setupHooks(): void
    {
        parent::setupHooks();
        add_action('wp_enqueue_scripts', [$this, 'autoEnqueues'], 25);
    }

    public function autoEnqueues(): void
    {
        if (is_singular('stake-pool') || is_post_type_archive('stake-pool')) {
            wp_enqueue_script(self::HANDLE_PREFIX . 'script');
        }
    }
}
