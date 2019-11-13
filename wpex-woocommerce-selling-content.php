<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              wpex.ir
 * @since             1.0.0
 * @package           Wpex_Woocommerce_Content_Selling
 *
 * @wordpress-plugin
 * Plugin Name:       Wpex Woocommerce selling content
 * Plugin URI:        wpex.ir
 * Description:       Show custom content on a single product page only to users who have purchased the product.
 * Version:           1.2.0
 * Author:            WPEX
 * Author URI:        wpex.ir
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpex-woocommerce-selling-content
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPEX_WOOCOMMERCE_SELLING_CONTENT_VERSION', '1.2.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpex-woocommerce-selling-content-activator.php
 */
function activate_wpex_woocommerce_selling_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpex-woocommerce-selling-content-activator.php';
	Wpex_Woocommerce_Content_Selling_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpex-woocommerce-selling-content-deactivator.php
 */
function deactivate_wpex_woocommerce_selling_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpex-woocommerce-selling-content-deactivator.php';
	Wpex_Woocommerce_Content_Selling_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpex_woocommerce_selling_content' );
register_deactivation_hook( __FILE__, 'deactivate_wpex_woocommerce_selling_content' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpex-woocommerce-selling-content.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpex_woocommerce_selling_content() {

	$plugin = new Wpex_Woocommerce_Content_Selling();
	$plugin->run();

}
run_wpex_woocommerce_selling_content();
