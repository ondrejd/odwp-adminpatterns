<?php
/**
 * Plugin Name: Admin Patterns
 * Plugin URI: https://github.com/ondrejd/odwp-adminpatterns
 * Description: Plugin that contains <strong>design pattern library</strong> to help with developing plugins that perfectly fit into <strong>WordPress</strong> administration. Original idea came with plugin <a href="https://github.com/helen/wp-style-guide" target="blank">WordPress Admin Pattern Library</a> by <a href="https://github.com/helen" target="blank">Helen Hou-Sandi</a>. Visit my homepage to see my other WordPress plugins or use <a href="https://www.paypal.me/ondrejd">this link</a> to make a donation if you are satisfied with this plugin.
 * Version: 0.1.0
 * Author: ondrejd
 * Author URI: http://ondrejd.com/
 * License: GPLv3
 * Requires at least: 4.7
 * Tested up to: 4.7.3
 *
 * @author  Ondřej Doněk, <ondrejd@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @link https://github.com/ondrejd/od-downloads-plugin for the canonical source repository
 * @package odwp-adminpatterns
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * @var string
 */
$odwpap_plugin_dir = plugin_dir_path( __FILE__ );

// Main sources
include_once( $odwpap_plugin_dir . 'src/Plugin.php' );
include_once( $odwpap_plugin_dir . 'src/Screen_Prototype.php' );
// Single screens
include_once( $odwpap_plugin_dir . 'src/Screen_Forms.php' );
include_once( $odwpap_plugin_dir . 'src/Screen_HelperClasses.php' );
include_once( $odwpap_plugin_dir . 'src/Screen_JqueryUi.php' );
include_once( $odwpap_plugin_dir . 'src/Screen_OtherWidgets.php' );
include_once( $odwpap_plugin_dir . 'src/Screen_Toc.php' );

/**
 * @var \com\ondrejd\adminpatterns\Plugin
 */
$odwpap_plugin = new \com\ondrejd\adminpatterns\Plugin( array(
        // Plugin's slug
        'slug'      => 'odwp-adminpatterns',
        // Plugin's version
        'version'   => '0.1.0',
        // Administration screens provided by the plugin.
        'screens'   => array(
            0 => '\com\ondrejd\adminpatterns\screens\Screen_Toc',
            1 => '\com\ondrejd\adminpatterns\screens\Screen_Forms',
            2 => '\com\ondrejd\adminpatterns\screens\Screen_OtherWidgets',
            3 => '\com\ondrejd\adminpatterns\screens\Screen_HelperClasses',
            4 => '\com\ondrejd\adminpatterns\screens\Screen_JqueryUi',
        ),
        // Default values of preferences of the plugin.
        'defaults'  => array(),
        // Main menu slug - all screens (without the one with the same slug) 
        // will be sub menu-items of these menu.
        'main_menu' => 'odwpap-screen_toc',
) );
