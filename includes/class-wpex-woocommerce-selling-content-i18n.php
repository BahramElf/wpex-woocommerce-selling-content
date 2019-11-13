<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       wpex.ir
 * @since      1.0.0
 *
 * @package    Wpex_Woocommerce_Content_Selling
 * @subpackage Wpex_Woocommerce_Content_Selling/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wpex_Woocommerce_Content_Selling
 * @subpackage Wpex_Woocommerce_Content_Selling/includes
 * @author     BahramElf <bhrm.ch@gmail.com>
 */
class Wpex_Woocommerce_Content_Selling_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpex-woocommerce-selling-content',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
