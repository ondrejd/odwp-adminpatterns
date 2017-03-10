<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ondrejd\adminpatterns\screens;

/**
 * Description of Screen_OtherWidgets
 *
 * @author ondrejd
 */
class Screen_OtherWidgets extends Screen_Prototype {
    /**
     * Constructor.
     * @param array $options Should contains at least 'plugin_slug' key.
     */
    public function __construct( $options = array() ) {
        $options['slug'] = 'odwpap-screen_otherwidgets';
        $options['menu_title'] = 'Other Widgets';
        $options['page_title'] = 'Other Admin Widgets';

        parent::__construct( $options );
    }

    /**
     * Render screen.
     */
    public function render() {
        include_once( plugin_dir_path( dirname( __FILE__ ) ) . 'templates/otherwidgets.phtml' );
    }
}
