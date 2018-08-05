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

namespace com\ondrejd\adminpatterns;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Main plugin's class.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 *
 * @todo Implement `Plugin::getInstance()` and make singleton from it!
 */
class Plugin {

	/**
	 * Plugin's base path.
	 * @since 0.1.0
	 * @var string $base_path
	 */
	protected $base_path;

    /**
     * Plugin's options.
     * @since 0.1.0
     * @var string $options
     */
    protected $options;

    /**
     * List of plugin's screens (instances of {@see Screen_Prototype}.
     * @since 0.1.0
     * @var array $screens
     */
    protected $screens;

	/**
	 * Hold instance of snippets manager. Part of singleton implementation.
	 *
	 * @since 0.1.0
	 * @var \com\ondrejd\adminpatterns\Snippets_Manager $instance
	 */
	private static $instance;

	/**
	 * Return instance of our plugin. Part of singleton implementation.
	 *
	 * @param array $options
	 * @return \com\ondrejd\adminpatterns\Plugin
	 * @since 0.1.0
	 * @throws \Exception Whenever passed options are not correct.
	 */
	public static function get_instance( $options = array() ) {
		if ( ! ( self::$instance instanceof Plugin ) ) {
			self::$instance = new Plugin( $options );
		}

		return self::$instance;
	}

    /**
     * Constructor.
     *
     * Array with options should contains these keys:
     *
     * - `base_path` : full path to the plugin's directory,
     * - `defaults`  : array with default options,
     * - `main_menu` : slug of the main menu item (can be null),
     * - `screens`   : array with all included administration screens (should be class names with namespace if necessary),
     * - `slug`      : plugin's slug,
     * - `version`   : version of the plugin.
     *
     * @param array $options
     * @return void
     * @since 0.1.0
     * @throws \Exception Whenever passed options are not correct.
     * @uses add_action()
     * @uses is_admin()
     */
    private function __construct( $options = array() ) {

        // Check if options are valid
	    if (
		    ! array_key_exists( 'base_path', $options ) ||
		    ! array_key_exists( 'base_url', $options ) ||
		    ! array_key_exists( 'defaults', $options ) ||
		    ! array_key_exists( 'main_menu', $options ) ||
		    ! array_key_exists( 'plugin_file', $options ) ||
		    ! array_key_exists( 'screens', $options ) ||
		    ! array_key_exists( 'slug', $options ) ||
		    ! array_key_exists( 'version', $options )
	    ) {
	    	throw new \Exception( 'Passed options are not valid!' );
	    }

	    // Check plugin's slug
	    if ( empty( $options['slug'] ) ) {
	    	throw new \Exception( 'Plugin\'s slug is not set correctly!' );
	    }

	    // Check plugin's file
	    if ( empty( $options['plugin_file'] ) || ! file_exists( $options['plugin_file'] ) ) {
		    throw new \Exception( 'Plugin\'s base path is not set correctly!' );
	    }

	    // Check plugin's base path
	    if ( empty( $options['base_path'] ) || ! file_exists( $options['base_path'] ) ) {
	    	throw new \Exception( 'Plugin\'s base path is not set correctly!' );
	    }

	    // Ensure base URL is set
	    if ( empty( $options['base_url'] ) ) {
		    if ( ! empty( $options['plugin_file'] ) ) {
			    $options['base_url'] = plugin_dir_url( $options['plugin_file'] );
		    }
	    }

	    // Ensure that version is set
	    if ( empty( $options['version'] ) ) {
	    	$options['version'] = '1.0.0';
	    }

        $this->options = $options;
	    $this->base_path = $options['base_path'];

        $this->init_screens();

        add_action( 'init', array( $this, 'init' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 98 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 99 );
		}
    }

	/**
	 * Returns path to plugin's base directory.
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_base_path() {
		return $this->base_path;
	}

	/**
	 * Returns URL of plugin's base directory.
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_base_url() {
		return $this->options['base_url'];
	}

    /**
     * Returns plugin's option with given key.
     *
	 * @param string $key
	 * @param boolean $null_if_not_exist Optional. Default FALSE.
	 * @return mixed Returns empty string if option with given key was not found.
     * @since 0.1.0
     * @uses get_option()
     */
    public function get_option( $key, $null_if_not_exist = false ) {
		$options = get_option( $this->get_slug() . '-options' );

		if ( array_key_exists( $key, $options ) ) {
			return $options[$key];
		}

		if ( $null_if_not_exist === true ) {
			return null;
		}

		return '';
    }

    /**
     * Returns all plugin options.
     *
     * @return array
     * @since 0.1.0
     * @uses get_option()
     * @uses update_option()
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
     *
     * @return array
     * @since 0.1.0
     */
    public function get_default_options() {
        return $this->options['defaults'];
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
     * Returns plugin's version.
     *
     * @return string
     * @since 0.1.0
     */
    public function get_version() {
        return $this->options['version'];
    }

    /**
     * Returns administration screens implemented by the plugin.
     *
     * @return array
     * @since 0.1.0
     */
    public function get_screens() {
        return $this->screens;
    }

    /**
     * Initializes screens included in plugin.
     *
     * @return void
     * @since 0.1.0
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
     *
     * @return void
     * @since 0.1.0
     */
    public function init() {
        // Check that options are initialized
        $this->get_options();
    }

    /**
     * Initialize administration.
     *
     * @return void
     * @since 0.1.0
     */
    public function admin_init() {
        foreach ( $this->screens as $screen ) {
            $screen->admin_init();
        }
    }

    /**
     * Updates WP admin menu.
     *
     * @return void
     * @since 0.1.0
     */
    public function admin_menu() {
        foreach ( $this->screens as $screen ) {
            $screen->admin_menu();
        }
    }

    /**
     * Registers our scripts and styles.
     *
     * @deprecated 0.1.0 Use `Plugin::admin_enqueue_scripts` instead.
     * @return void
     * @since 0.1.0
     * @uses get_current_screen()
     */
    public function admin_scripts() {

        /**
         * @var WP_Screen $wp_screen
         */
        $wp_screen = get_current_screen();

        foreach ( $this->screens as $screen ) {
            if ( $wp_screen->id == $screen->get_hookname() ) {
                $screen->admin_scripts();
            }
        }
    }

	/**
	 * Hook for "admin_enqueue_scripts" action.
	 *
	 * @return void
	 * @since 0.1.0
	 * @uses wp_enqueue_script()
	 * @uses wp_enqueue_style()
	 * @uses wp_localize_script()
	 */
	public function admin_enqueue_scripts() {

		// JavaScript
		$js_file = 'assets/js/admin.js';
		$js_path = $this->get_base_path() . $js_file;

		if ( file_exists( $js_path ) && is_readable( $js_path ) ) {
			wp_enqueue_script( $this->get_slug(), $this->get_base_url() . $js_file, ['jquery'] );
			wp_localize_script( $this->get_slug(), $this->get_slug(), [
				// Put variables you want to pass into JS here...
			] );
		}

		// CSS
		$css_file = 'assets/css/admin.css';
		$css_path = $this->get_base_path() . $css_file;

		if ( file_exists( $css_path ) && is_readable( $css_path ) ) {
			wp_enqueue_style( $this->get_slug(), $this->get_base_url() . $css_file );
		}

		$this->screens_call_method( 'admin_enqueue_scripts' );
	}

	/**
	 * On all screens call method with given name.
	 *
	 * Used for calling hook's actions of the existing screens.
	 * See {@see DL_Plugin::admin_menu} for an example how is used.
	 *
	 * If method doesn't exist in the screen object it means that screen
	 * do not provide action for the hook.
	 *
	 * @access private
	 * @param string $method
	 * @return void
	 * @since 0.1.0
	 */
	private function screens_call_method( $method ) {
		foreach ( $this->screens as $slug => $screen ) {
			if ( method_exists( $screen, $method ) ) {
				call_user_func( array( $screen, $method ) );
			}
		}
	}

}
