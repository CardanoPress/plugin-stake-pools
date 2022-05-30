<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Foundation\AbstractTemplates;

class Templates extends AbstractTemplates
{
    public const OVERRIDES_PREFIX = 'cardanopress/stake-pools/';

    protected function initialize(): void
    {
    }

    protected function getLoaderFile(): string
    {
        $template = '';

        if (is_singular('stake-pool')) {
            $template = 'single-stake-pool.php';
        } elseif (is_post_type_archive('stake-pool')) {
            $template = 'archive-stake-pool.php';
        }

        return $template;
    }
}
