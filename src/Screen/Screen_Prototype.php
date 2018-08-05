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
 * Description of ScreenPrototype.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
abstract class Screen_Prototype {

    /**
     * Screen's options.
     *
     * @since 0.1.0
     * @var array $options
     */
    protected $options;

    /**
     * Name of the hook for menu item.
     *
     * @since 0.1.0
     * @var String $hookname
     */
    private $hookname;

    /**
     * Constructor.
     *
     * @param array $options
     * @return void
     * @since 0.1.0
     */
    public function __construct( $options = array() ) {
        $this->options = array_merge( $this->get_default_options(), $options );
    }

    /**
     * Returns menu hook's name.
     *
     * @return string
     * @since 0.1.0
     */
    public function get_hookname() {
        return $this->hookname;
    }

    /**
     * Returns screen's option with given key.
     *
     * @param string $key
     * @return mixed
     * @since 0.1.0
     */
    public function get_option( $key ) {
    	if ( array_key_exists( $key, $this->options ) ) {
    		return $this->options[$key];
	    }

        return null;
    }

    /**
     * Returns all screen options.
     * @return array
     * @since 0.1.0
     */
    public function get_options() {
        return $this->options;
    }

    /**
     * Returns default screen options.
     *
     * @return array
     * @since 0.1.0
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
     *
     * @return string
     * @since 0.1.0
     */
    public function get_menu_title() {
        return $this->options['menu_title'];
    }

	/**
	 * Returns plugin's page description.
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_page_description() {
		return $this->options['page_description'];
	}

    /**
     * Returns plugin's page title.
     *
     * @return string
     * @since 0.1.0
     */
    public function get_page_title() {
        return $this->options['page_title'];
    }

    /**
     * Returns plugin's slug.
     *
     * @return string
     * @since 0.1.0
     */
    public function get_slug() {
        return $this->options['slug'];
    }

    /**
     * Initialize administration.
     *
     * @return void
     * @since 0.1.0
     */
    public function admin_init() {
        //...
    }

    /**
     * Updates WP admin menu.
     *
     * @return void
     * @since 0.1.0
     * @uses add_action()
     * @uses add_menu_page()
     * @uses add_submenu_page()
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
     *
     * @return void
     * @since 0.1.0
     */
    public function help() {
        // ...
    }

    /**
     * Enqueues our scripts and styles.
     *
     * @return void
     * @since 0.1.0
     */
    public function admin_scripts() {
        //...
    }

    /**
     * Render screen.
     *
     * @return void
     * @since 0.1.0
     */
    abstract public function render();

	/**
	 * Render given template.
	 *
	 * @param string $template Name of template's source file.
	 * @return void
	 * @since 0.1.0
	 */
    protected function _render( $template ) {

	    try {
		    $plugin = \com\ondrejd\adminpatterns\Plugin::get_instance();
		    include_once( $plugin->get_base_path() . 'templates/' . $template );
	    } catch ( \Exception $e ) {

		    // There can be thrown error if Plugin wasn't properly constructed...
	    }
    }
}
