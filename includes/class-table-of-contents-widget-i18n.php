<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://matsakov.com
 * @since      1.0.0
 *
 * @package    Table_Of_Contents_Widget
 * @subpackage Table_Of_Contents_Widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Table_Of_Contents_Widget
 * @subpackage Table_Of_Contents_Widget/includes
 * @author     Evgeny Masakov <ematsakov@gmail.com>
 */
class Table_Of_Contents_Widget_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'table-of-contents-widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
