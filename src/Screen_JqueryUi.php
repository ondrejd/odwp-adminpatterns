<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ondrejd\adminpatterns\screens;

/**
 * Description of Screen_JqueryUi
 *
 * @author ondrejd
 */
class Screen_JqueryUi extends Screen_Prototype {
    /**
     * Constructor.
     * @param array $options Should contains at least 'plugin_slug' key.
     */
    public function __construct( $options = array() ) {
        $options['slug'] = 'odwpap-screen_jqueryui';
        $options['menu_title'] = 'jQuery UI';
        $options['page_title'] = 'jQuery UI Components';

        parent::__construct( $options );
    }

    /**
     * Render screen.
     */
    public function render() {
        include_once( plugin_dir_path( dirname( __FILE__ ) ) . 'templates/jqueryui.phtml' );
    }
}
