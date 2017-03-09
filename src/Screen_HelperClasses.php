<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ondrejd\adminpatterns\screens;

/**
 * Description of Screen_HelperClasses
 *
 * @author ondrejd
 */
class Screen_HelperClasses extends Screen_Prototype {
    /**
     * Constructor.
     * @param array $options Should contains at least 'plugin_slug' key.
     */
    public function __construct( $options = array() ) {
        $options['slug'] = 'odwpap-screen_helperclasses';
        $options['menu_title'] = 'CSS Classes';
        $options['page_title'] = 'CSS Helper Classes';

        parent::__construct( $options );
    }
}
