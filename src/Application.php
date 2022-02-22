<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use PBWebDev\CardanoPress\Blockfrost;
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
        $this->setup();

        add_filter('update_post_metadata', [$this, 'getPoolDetails'], 10, 5);
    }

    public function setup(): void
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
            'fields' => [
                'network' => [
                    'title' => __('Network', 'cardanopress-stake-pools'),
                    'type' => 'radio',
                    'options' => [
                        'mainnet' => 'Mainnet',
                        'testnet' => 'Testnet',
                    ],
                ],
                'id' => [
                    'title' => __('ID', 'cardanopress-stake-pools'),
                    'type' => 'text',
                ],
                'data' => [
                    'type' => 'html',
                    'default' => $this->getPoolData(),
                ],
            ],
        ]);
    }

    public function getPoolDetails($check, $postId, $metaKey, $newValue, $oldValue)
    {
        if ('pool_id' !== $metaKey || empty($newValue) || ($newValue === $oldValue)) {
            return $check;
        }

        $network = get_post_meta($postId, 'pool_network', true);
        $blockfrost = new Blockfrost($network);
        $poolDetails = $blockfrost->getPoolDetails($newValue);

        update_post_meta($postId, 'pool_data', $poolDetails);

        return $check;
    }

    protected function getPoolData()
    {
        $meta = get_post_meta($_REQUEST['post'] ?? get_the_ID(), 'pool_data', true) ?: [];
        error_log(print_r($_REQUEST, true));

        ksort($meta);
        ob_start();

        ?>
        <table>
            <?php foreach ($meta as $key => $value) : ?>
                <tr>
                    <th><?php echo $key; ?></th>
                    <td><?php echo $value; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php

        return ob_get_clean();
    }
}
