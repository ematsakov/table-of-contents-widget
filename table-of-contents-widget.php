<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://matsakov.com
 * @since             1.0.0
 * @package           Table_Of_Contents_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Table of Contents Widget
 * Plugin URI:        https://matsakov.com
 * Description:       Automatically generate a table of contents for your posts.
 * Version:           1.0.0
 * Author:            Evgeny Masakov
 * Author URI:        https://matsakov.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       table-of-contents-widget
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
define( 'TABLE_OF_CONTENTS_WIDGET_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-table-of-contents-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_table_of_contents_widget() {

	$plugin = new Table_Of_Contents_Widget();
	$plugin->run();

}
run_table_of_contents_widget();
