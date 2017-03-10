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
abstract class Screen_Prototype {
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
     * Returns plugin's menu title.
     * @return string
     */
    public function get_menu_title() {
        return $this->options['menu_title'];
    }

    /**
     * Returns plugin's page title.
     * @return string
     */
    public function get_page_title() {
        return $this->options['page_title'];
    }

    /**
     * Returns plugin's slug.
     * @return string
     */
    public function get_slug() {
        return $this->options['slug'];
    }

    /**
     * Initialize administration.
     */
    public function admin_init() {
        //...
    }

    /**
     * Updates WP admin menu.
     */
    public function admin_menu() {
        $main_menu_slug = '';

        if ( array_key_exists( 'plugin_options', $this->options ) ) {
            if (array_key_exists( 'main_menu', $this->options['plugin_options'] ) ) {
                $main_menu_slug = $this->options['plugin_options']['main_menu'];
            }
        }

        if ( $this->options['slug'] == $main_menu_slug ) {
            $this->hookname = add_menu_page(
                    $this->get_page_title(),
                    $this->get_menu_title(),
                    'read',
                    $this->get_slug(),
                    array( $this, 'render' )
            );
            add_action( 'load-' . $this->hookname, array( $this, 'help' ) );
        }
        else {
            $this->hookname = add_submenu_page(
                    $main_menu_slug,
                    $this->get_page_title(),
                    $this->get_menu_title(),
                    'read',
                    $this->get_slug(),
                    array( $this, 'render' )
            );
			add_action( 'load-' . $this->hookname, array( $this, 'help' ) );
        }
    }

    /**
     * Renders screen's help.
     */
    public function help() {
        // ...
    }

    /**
     * Enqueues our scripts and styles.
     */
    public function admin_scripts() {
        //...
    }

    /**
     * Render screen.
     */
    abstract public function render();
}
