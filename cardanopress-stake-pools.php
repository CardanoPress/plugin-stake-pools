<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

/**
 * Plugin Name: CardanoPress - Stake Pools
 * Plugin URI:  https://github.com/CardanoPress/plugin-stake-pools
 * Author:      CardanoPress
 * Author URI:  https://cardanopress.io
 * Description: A CardanoPress extension for stake pools
 * Version:     0.8.0
 * License:     GPL-2.0-only
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: cardanopress-stake-pools
 *
 * Requires at least: 5.9
 * Requires PHP:      7.4
 *
 * Requires Plugins: cardanopress
 *
 * @package ThemePlate
 * @since   0.1.0
 */

// Accessed directly
if (! defined('ABSPATH')) {
    exit;
}

use PBWebDev\CardanoPress\StakePools\Application;
use PBWebDev\CardanoPress\StakePools\Installer;

/* ==================================================
Global constants
================================================== */

if (! defined('CP_STAKE_POOLS_FILE')) {
    define('CP_STAKE_POOLS_FILE', __FILE__);
}

// Load the main plugin class
require_once plugin_dir_path(CP_STAKE_POOLS_FILE) . 'dependencies/vendor/autoload_packages.php';

// Instantiate the updater
// phpcs:ignore Generic.Files.LineLength.TooLong
EUM_Handler::run(CP_STAKE_POOLS_FILE, 'https://raw.githubusercontent.com/CardanoPress/plugin-stake-pools/main/update-data.json');

// Instantiate
function cpStakePools(): Application
{
    static $application;

    if (null === $application) {
        $application = new Application(CP_STAKE_POOLS_FILE);
    }

    return $application;
}

cpStakePools()->setupHooks();
(new Installer(cpStakePools()))->setupHooks();
