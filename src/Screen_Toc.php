<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ondrejd\adminpatterns\screens;

/**
 * Description of Screen_Toc
 *
 * @author ondrejd
 */
class Screen_Toc extends Screen_Prototype {
    /**
     * Constructor.
     * @param array $options Should contains at least 'plugin_slug' key.
     */
    public function __construct( $options = array() ) {
        $options['slug'] = 'odwpap-screen_toc';
        $options['menu_title'] = 'Pattern Library';
        $options['page_title'] = 'WordPress Admin Pattern Library';

        parent::__construct( $options );
    }
}