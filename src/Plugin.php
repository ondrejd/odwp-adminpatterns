<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ondrejd\adminpatterns;

/**
 * Main plugin's class.
 *
 * @author ondrejd
 */
class Plugin {
    /**
     * Plugin's options.
     * @var string
     */
    protected $options;

    /**
     * List of plugin's screens (instances of {@see Screen_Prototype}.
     * @var array
     */
    protected $screens;

    /**
     * Constructor.
     * @param array $options
     */
    public function __construct( $options = array() ) {
        $defaults = array(
            // Plugin's slug
            'slug'     => substr( md5( microtime() ),rand( 0, 26 ), 5 ),
            // Plugin's version
            'version'  => '1.0.0',
            // Screen of plugin
            'screens'  => array(),
            // Default options
            'defaults' => array(),
        );

        $this->options = array_merge( $defaults, $options );

        $this->init_screens();

        add_action( 'init', array( $this, 'init' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}
    }

    /**
     * Returns plugin's option with given key.
	 * @param string $key
	 * @param boolean $null_if_not_exist Optional. Default FALSE.
	 * @return mixed Returns empty string if option with given key was not found.
     */
    public function get_option( $key, $null_if_not_exist = false ) {
		$options = get_option( $this->get_slug() . '-options' );

		if ( array_key_exists( $key, $options ) ) {
			return $options[$key];
		}

		if ( $null_if_not_exist === true ) {
			return NULL;
		}

		return '';
    }

    /**
     * Returns all plugin options.
     * @return array
     */
    public function get_options() {
		$options = get_option( $this->get_slug() . '-options' );
		$need_update = false;

		if ( ! is_array( $options ) ) {
			$need_update = true;
			$options = array();
		}

		foreach ( $this->get_default_options() as $key => $value ) {
			if ( ! array_key_exists( $key, $options ) ) {
				$options[$key] = $value;
				$need_update = true;
			}
		}

		if ( ! array_key_exists( 'latest_used_version', $options ) ) {
			$options['latest_used_version'] = $this->get_version();
			$need_update = true;
		}

		if ( $need_update === true ) {
			update_option( $this->get_slug() . '-options', $options );
		}

		return $options;
    }

    /**
     * Returns default plugin options.
     * @return array
     */
    public function get_default_options() {
        return $this->options['defaults'];
    }

    /**
     * Returns plugin's slug.
     * @return string
     */
    public function get_slug() {
        return $this->options['slug'];
    }

    /**
     * Returns plugin's version.
     * @return string
     */
    public function get_version() {
        return $this->options['version'];
    }

    /**
     * Initializes screens included in plugin.
     */
    protected function init_screens() {
        foreach ( $this->options['screens'] as $screen ) {
            $this->screens[] = new $screen( array(
                'plugin_options' => $this->options,
            ) );
        }
    }

    /**
     * Initializes plugin.
     */
    public function init() {
        // Check that options are initialized
        $this->get_options();
    }

    /**
     * Initialize administration.
     */
    public function admin_init() {
        foreach ( $this->screens as $screen ) {
            $screen->admin_init();
        }
    }

    /**
     * Updates WP admin menu.
     */
    public function admin_menu() {
        foreach ( $this->screens as $screen ) {
            $screen->admin_menu();
        }
    }

    /**
     * Registers our scripts and styles.
     */
    public function admin_scripts() {
        /**
         * @var WP_Screen
         */
        $wp_screen = get_current_screen();

        foreach ( $this->screens as $screen ) {
            if ( $wp_screen->id == $screen->get_hookname() ) {
                $screen->admin_scripts();
            }
        }
    }
}
