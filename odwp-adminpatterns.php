<?php
/**
 * Plugin Name: Admin Patterns
 * Plugin URI: https://github.com/ondrejd/odwp-adminpatterns
 * Description: Plugin that contains <strong>design pattern library</strong> to help with developing plugins that perfectly fit into <strong>WordPress</strong> administration. Original idea came with plugin <a href="https://github.com/helen/wp-style-guide" target="blank">WordPress Admin Pattern Library</a> by <a href="https://github.com/helen" target="blank">Helen Hou-Sandi</a>. Visit my homepage to see my other WordPress plugins or use <a href="https://www.paypal.me/ondrejd">this link</a> to make a donation if you are satisfied with this plugin.
 * Version: 0.1.0
 * Author: Ondřej Doněk
 * Author URI: http://ondrejd.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Requires at least: 4.7
 * Requires PHP: 7.0
 * Tested up to: 4.9.8
 * Tags: development,plugins
 * Donate link: https://www.paypel.me/ondrejd
 * Text Domain: odwp-adminpatterns
 * Domain Path: /languages/
 *
 * WordPress plugin Admin Patterns that contains design patterns library
 * to help with developing plugins that perfectly fit into WordPress.
 *
 * Copyright (C) 2018 Ondřej Doněk
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @link https://github.com/ondrejd/odwp-adminpatterns for the canonical source repository
 * @package odwp-adminpatterns
 * @since 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

defined( 'ODWPAP_SLUG' ) ||
	/**
	 * Summary.
	 *
	 * @since x.x.x (if available)
	 * @var type ODWPAP_SLUG
	 */
	define( 'ODWPAP_SLUG', 'odwpap' );

defined( 'ODWPAP_DOMAIN' ) ||
	/**
	 * Plugin's domain.
	 *
	 * @since 0.1.0
	 * @var string ODWPAP_DOMAIN
	 */
	define( 'ODWPAP_DOMAIN', 'odwp-adminpatterns' );

defined( 'ODWPAP_FILE' ) ||
	/**
	 * Plugin's file.
	 *
	 * @since 0.1.0
	 * @var string ODWPAP_FILE
	 */
	define( 'ODWPAP_FILE', __FILE__ );

defined( 'ODWPAP_DIR' ) ||
	/**
	 * Full path to plugin's directory.
	 *
	 * @since 0.1.0
	 * @var string ODWPAP_DIR
	 */
	define( 'ODWPAP_DIR', plugin_dir_path( ODWPAP_FILE ) );

defined( 'ODWPAP_URL' ) ||
	/**
	 * URL to plugin's directory.
	 *
	 * @since 0.1.0
	 * @var string ODWPAP_URL
	 */
	define( 'ODWPAP_URL', plugin_dir_url( ODWPAP_FILE ) );

// Main sources
include_once( ODWPAP_DIR . 'src/Plugin.php' );
include_once( ODWPAP_DIR . 'src/Snippets_Manager.php' );

// Screens
include_once( ODWPAP_DIR . 'src/Screen/Screen_Prototype.php' );
include_once( ODWPAP_DIR . 'src/Screen/Screen_Forms.php' );
include_once( ODWPAP_DIR . 'src/Screen/Screen_HelperClasses.php' );
include_once( ODWPAP_DIR . 'src/Screen/Screen_JqueryUi.php' );
include_once( ODWPAP_DIR . 'src/Screen/Screen_OtherWidgets.php' );
include_once( ODWPAP_DIR . 'src/Screen/Screen_Toc.php' );

// Initialize our plugin
\com\ondrejd\adminpatterns\Plugin::get_instance( array(
	'base_path'   => ODWPAP_DIR,
	'base_url'    => ODWPAP_URL,
	'defaults'    => array(),
	'main_menu'   => 'odwpap-screen_toc',
	'plugin_file' => ODWPAP_FILE,
	'screens'     => array(
		'\com\ondrejd\adminpatterns\Screen\Screen_Toc',
		'\com\ondrejd\adminpatterns\Screen\Screen_Forms',
		'\com\ondrejd\adminpatterns\Screen\Screen_OtherWidgets',
		'\com\ondrejd\adminpatterns\Screen\Screen_HelperClasses',
		'\com\ondrejd\adminpatterns\Screen\Screen_JqueryUi',
	),
	'slug'        => ODWPAP_SLUG,
	'version'     => '0.1.0',
) );
