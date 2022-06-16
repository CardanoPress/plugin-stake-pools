<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Foundation\AbstractAdmin;
use ThemePlate\CPT\PostType;
use ThemePlate\CPT\Taxonomy;
use ThemePlate\Meta\PostMeta;

class Admin extends AbstractAdmin
{
    public const OPTION_KEY = 'cp-stake-pools';

    protected function initialize(): void
    {
    }

    public function setupHooks(): void
    {
        $this->registerPostType();
        $this->registerTaxonomy();
        $this->poolSettingsMetaBox();

        add_action(Installer::DATA_PREFIX . 'activating', [$this, 'pluginActivating']);
        add_action('admin_print_footer_scripts-post.php', [$this, 'poolResetScript']);
    }

    public function pluginActivating(): void
    {
        $this->registerPostType();
        flush_rewrite_rules();
    }

    private function registerPostType(): void
    {
        $postType = new PostType('stake-pool', [
            'menu_position' => 5,
            'menu_icon' => 'dashicons-database',
            'supports' => ['title'],
            'has_archive' => true,
        ]);

        $postType->register();
    }

    private function registerTaxonomy(): void
    {
        $taxonomy = new Taxonomy('stake-pool-category');

        $taxonomy->labels(__('Category', 'cardanopress-stake-pools'), __('Categories', 'cardanopress-stake-pools'));
        $taxonomy->associate('stake-pool')->register();
    }

    private function poolSettingsMetaBox(): void
    {
        $postMeta = new PostMeta(__('Pool Settings', 'cardanopress-stake-pools'), [
            'data_prefix' => 'pool_',
        ]);

        $postMeta->fields([
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
            ]
        ]);

        $postMeta->location('stake-pool')->create();
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
                var $poolId = $('#themeplate_pool_id')
                var $poolNetwork = $('#themeplate_pool_network input')
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
