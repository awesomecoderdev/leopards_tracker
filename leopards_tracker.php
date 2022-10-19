<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 * @package           Leopards_tracker
 *
 * @wordpress-plugin
 * Plugin Name:       Leopards Tracker
 * Plugin URI:        https://awesomecoder.dev/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mohammad Ibrahim
 * Author URI:        https://awesomecoder.dev/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       leopards_tracker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('LEOPARDS_TRACKER_VERSION', '1.0.0');
define('LEOPARDS_TRACKER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LEOPARDS_TRACKER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('LEOPARDS_TRACKER_BLOG_URL', get_bloginfo('url'));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-leopards_tracker-activator.php
 */
function activate_leopards_tracker()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-leopards_tracker-activator.php';
	Leopards_tracker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-leopards_tracker-deactivator.php
 */
function deactivate_leopards_tracker()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-leopards_tracker-deactivator.php';
	Leopards_tracker_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_leopards_tracker');
register_deactivation_hook(__FILE__, 'deactivate_leopards_tracker');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-leopards_tracker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_leopards_tracker()
{

	$plugin = new Leopards_tracker();
	$plugin->run();
}
run_leopards_tracker();
