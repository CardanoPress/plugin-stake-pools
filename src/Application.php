<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use ThemePlate\CPT\PostType;
use ThemePlate\Meta\Post;

class Application
{
    private static Application $instance;

    public static function instance(): Application
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        new PostType([
            'name' => 'stake-pool',
            'plural' => __('Stake Pools', 'cardanopress-stake-pools'),
            'singular' => __('Stake Pool', 'cardanopress-stake-pools'),
            'args' => [
                'menu_position' => 5,
                'menu_icon' => 'dashicons-database',
                'supports' => ['title'],
                'has_archive' => true,
            ],
        ]);

        new Post([
            'id' => 'pool',
            'title' => __('Pool Settings', 'cardanopress-stake-pools'),
            'fields' => array(
                'id' => [
                    'title' => __('ID', 'cardanopress-stake-pools'),
                    'type' => 'text',
                ],
            ),
        ]);
    }
}
