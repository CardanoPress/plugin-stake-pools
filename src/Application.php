<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use ThemePlate\Cache;
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
        add_action('admin_notices', [$this, 'notice']);
        add_action('cardanopress_loaded', [$this, 'init']);
        add_action('init', [$this, 'setup']);
    }

    private function coreActive()
    {
        $function = function_exists('cardanoPress');
        $namespace = 'PBWebDev\\CardanoPress\\';
        $blockfrost = class_exists($namespace . 'Blockfrost');
        $manifest = class_exists($namespace . 'Manifest');

        return $function && $blockfrost && $manifest;
    }

    public function notice()
    {
        if ($this->coreActive()) {
            return;
        }

        ob_start();

        ?>
        <div class="error">
            <p>
                <strong>CardanoPress - Stake Pools</strong>:
                CardanoPress core plugin is required or current installed version is incompatible.
            </p>
        </div>';
        <?php

        echo ob_get_clean();
    }

    public function init(): void
    {
        add_action('admin_print_footer_scripts-post.php', [$this, 'poolResetScript']);
        add_filter('template_include', [$this, 'templateLoader']);

        $load_path = plugin_dir_path(CP_STAKE_POOLS_FILE);
        $processor = Cache::processor();

        new Manifest($load_path . 'assets');
        $processor->report(function ($output) {
            error_log(print_r($output, true));
        });
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

    protected function inCorrectPage()
    {
        if (wp_doing_ajax() || ! is_admin()) {
            return false;
        }

        global $pagenow;

        return 'post.php' === $pagenow && 'stake-pool' === get_post_type($_REQUEST['post']);
    }

    public function poolResetScript()
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

    public function templateLoader($template)
    {
        if (is_embed()) {
            return $template;
        }

        if (is_singular('stake-pool')) {
            $default = 'single-stake-pool.php';
        } elseif (is_post_type_archive('stake-pool')) {
            $default = 'archive-stake-pool.php';
        } else {
            $default = '';
        }

        if ($default) {
            $template = locate_template($default);

            if (! $template) {
                $template = plugin_dir_path(CP_STAKE_POOLS_FILE) . 'templates/' . $default;
            }
        }

        return $template;
    }
}
