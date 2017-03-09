<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ondrejd\adminpatterns\screens;

/**
 * Description of ScreenPrototype
 *
 * @author ondrejd
 */
class Screen_Prototype {
    /**
     * Screen's options.
     * @var string
     */
    protected $options;

    /**
     * @var String
     */
    private $hookname;

    /**
     * Constructor.
     * @param array $options
     */
    public function __construct( $options = array() ) {
        $this->options = array_merge( $this->get_default_options(), $options );
    }

    /**
     * Returns menu hook's name.
     * @return string
     */
    public function get_hookname() {
        return $this->hookname;
    }

    /**
     * Returns screen's option with given key.
     * @param string $key
     * @return mixed
     */
    public function get_option( $key ) {
        return ( array_key_exists( $key, $array) ) ? $this->options[$key] : null;
    }

    /**
     * Returns all screen options.
     * @return array
     */
    public function get_options() {
        return $this->options;
    }

    /**
     * Returns default screen options.
     * @return array
     */
    public function get_default_options() {
        return array(
            'plugin_slug' => null,
            'slug' => null,
            'page_title' => null,
            'menu_title' => null,
        );
    }

    /**
     * Initialize administration.
     */
    public function admin_init() {
        // Main admin menu
        // ...
        // Process all screens
        foreach ( $this->screens as $screen ) {
            $screen->admin_init();
        }
    }

    /**
     * Updates WP admin menu.
     */
    public function admin_menu() {
        // Main admin menu
        // ...
        // Process all screens
        foreach ( $this->screens as $screen ) {
            $screen->admin_menu();
        }
    }

    /**
     * Enqueues our scripts and styles.
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
