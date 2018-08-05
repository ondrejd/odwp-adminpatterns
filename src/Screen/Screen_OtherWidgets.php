<?php
/**
 * WordPress plugin Admin Patterns that contains design patterns library
 * to help with developing plugins that perfectly fit into WordPress.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @link https://github.com/ondrejd/odwp-adminpatterns for the canonical source repository
 * @package odwp-adminpatterns
 * @since 0.1.0
 */

namespace com\ondrejd\adminpatterns\Screen;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Description of Screen_OtherWidgets.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class Screen_OtherWidgets extends Screen_Prototype {

    /**
     * Constructor.
     *
     * @param array $options Should contains at least 'plugin_slug' key.
     * @return void
     * @since 0.1.0
     */
    public function __construct( $options = array() ) {
        $options['slug'] = 'odwpap-screen_otherwidgets';
        $options['menu_title'] = __( 'Other Widgets', ODWPAP_DOMAIN );
        $options['page_title'] = __( 'Other Admin Widgets', ODWPAP_DOMAIN );
	    $options['page_description'] = sprintf( __( 'Page with snippets of some other widgets commonly used within %sWordPress%s administration.', ODWPAP_DOMAIN ), '<strong>', '</strong>' );

        parent::__construct( $options );
    }

    /**
     * Render screen.
     *
     * @return void
     * @since 0.1.0
     */
    public function render() {
    	parent::_render( 'otherwidgets.phtml' );
    }
}
