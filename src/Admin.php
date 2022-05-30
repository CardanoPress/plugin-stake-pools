<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Foundation\AbstractAdmin;
use Exception;
use ThemePlate\CPT\PostType;
use ThemePlate\CPT\Taxonomy;
use ThemePlate\Meta\Post;

class Admin extends AbstractAdmin
{
    protected function initialize(): void
    {
    }

    public function setupHooks(): void
    {
        add_action('admin_print_footer_scripts-post.php', [$this, 'poolResetScript']);

        add_action('init', function () {
            $this->registerPostType();
            $this->registerTaxonomy();
            $this->poolSettingsMetaBox();
        });
    }

    private function registerPostType(): void
    {
        try {
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
        } catch (Exception $exception) {
            $this->log($exception->getMessage());
        }
    }

    private function registerTaxonomy(): void
    {
        try {
            new Taxonomy([
                'name' => 'stake-pool-category',
                'type' => 'stake-pool',
                'plural' => __('Categories', 'cardanopress-stake-pools'),
                'singular' => __('Category', 'cardanopress-stake-pools'),
            ]);
        } catch (Exception $exception) {
            $this->log($exception->getMessage());
        }
    }

    private function poolSettingsMetaBox(): void
    {
        try {
            $post = new Post([
                'id' => 'pool',
                'title' => __('Pool Settings', 'cardanopress-stake-pools'),
                'screen' => ['stake-pool'],
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

            $this->storeConfig($post->get_config());
        } catch (Exception $exception) {
            $this->log($exception->getMessage());
        }
    }

    protected function getPoolData()
    {
        if (! $this->inCorrectPage()) {
            return '';
        }

        $poolData = new PoolData($_REQUEST['post']);

        ob_start();

        ?>
        <table>
            <?php foreach ($poolData->toArray() as $key => $value) : ?>
                <tr>
                    <th><?php echo $key; ?></th>
                    <td>
                        <pre><?php print_r($value); ?></pre>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php

        return ob_get_clean();
    }

    protected function inCorrectPage(): bool
    {
        if (wp_doing_ajax() || ! is_admin() || empty($_REQUEST['post'])) {
            return false;
        }

        global $pagenow;

        return 'post.php' === $pagenow && 'stake-pool' === get_post_type($_REQUEST['post']);
    }

    public function poolResetScript(): void
    {
        if (! $this->inCorrectPage()) {
            return;
        }

        ob_start(); ?>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var $poolId = $('#pool_id')
                var $poolNetwork = $('#pool_network input')
                var lastIdVal = $poolId.val()
                var lastNetworkVal = $poolNetwork.filter(':checked').val()

                $poolNetwork.on('change', function(e) {
                    e.preventDefault()

                    var currentIdValue = $poolId.val()
                    var currentNetworkValue = $(e.currentTarget).val()

                    if (currentNetworkValue === lastNetworkVal) {
                        if (!currentIdValue) {
                            $poolId.val(lastIdVal)
                        }
                    } else if (currentIdValue === lastIdVal) {
                        $poolId.val('')
                    }
                })
            })
        </script>

        <?php
        echo wp_kses(ob_get_clean(), ['script' => []]);
    }
}
