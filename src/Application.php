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
        add_action('admin_print_footer_scripts-post.php', [$this, 'poolResetScript']);
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

    public function poolResetScript()
    {
        ob_start(); ?>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var $poolId = $('#pool_id');
                var $poolNetwork = $('#pool_network input');
                var lastIdVal = $poolId.val();
                var lastNetworkVal = $poolNetwork.filter(':checked').val();

                $poolNetwork.on('change', function(e) {
                    e.preventDefault();

                    var currentIdValue = $poolId.val();
                    var currentNetworkValue = $(e.currentTarget).val();

                    if (currentNetworkValue === lastNetworkVal) {
                        if (!currentIdValue) {
                            $poolId.val(lastIdVal);
                        }
                    } else if (currentIdValue === lastIdVal) {
                        $poolId.val('');
                    }
                })
            })
        </script>

        <?php
        echo wp_kses(ob_get_clean(), ['script' => []]);
    }
}
