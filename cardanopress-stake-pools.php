<?php

/**
 * Plugin Name: CardanoPress - Stake Pools
 * Plugin URI:  https://github.com/CardanoPress/plugin-stake-pools
 * Author:      Gene Alyson Fortunado Torcende
 * Author URI:  https://cardanopress.io
 * Description: A CardanoPress extension for stake pools
 * Version:     0.3.0
 * License:     GPL-2.0-only
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
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
require_once plugin_dir_path(CP_STAKE_POOLS_FILE) . 'vendor/autoload.php';

// Instantiate the updater
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
