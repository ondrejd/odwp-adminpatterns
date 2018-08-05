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
 * Simple snippets manager (used for loading code examples).
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class Snippets_Manager {

	/**
	 * Hold instance of snippets manager. Part of singleton implementation.
	 *
	 * @since 0.1.0
	 * @var \com\ondrejd\adminpatterns\Snippets_Manager $instance
	 */
	private static $instance;

	/**
	 * @since 0.1.0
	 * @var string $base_path;
	 */
	protected $base_path;

	/**
	 * Return instance of snippets manager. Part of singleton implementation.
	 *
	 * @return \com\ondrejd\adminpatterns\Snippets_Manager
	 * @since 0.1.0
	 */
	protected static function get_instance() {
		if ( ! ( self::$instance instanceof Snippets_Manager ) ) {
			self::$instance = new Snippets_Manager();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @global string $odwpap_plugin_dir
	 * @return void
	 * @since 0.1.0
	 */
	private function __construct() {
		try {
			$this->base_path = Plugin::get_instance()->get_base_path() . 'assets/snippets/';
		} catch ( \Exception $e ) {

			// There can be thrown error if Plugin wasn't properly constructed...
			global $odwpap_plugin_dir;

			$this->base_path = $odwpap_plugin_dir . 'snippets/';
		}
	}

	/**
	 * Return base path of snippets directory.
	 *
	 * @return string
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public static function get_base_path() {
		$self = self::get_instance();

		/**
		 * Filter for base path of snippets directory.
		 *
		 * @since 0.1.0
		 *
		 * @param string $base_path Base path of snippets directory.
		 */
		return apply_filters( 'odwpap_snippets_base_path', $self->base_path );
	}

	/**
	 * Return contents of the snippet file.
	 *
	 * @param string $snippet Name of the snippet file (with relative path within `base_path` if necessary).
	 * @return string
	 * @since 0.1.0
	 * @throws \Exception Whenever snippet file doesn't exist or is not readable.
	 * @uses apply_filters()
	 */
	public static function get_snippet( $snippet ) {
		$base_path = self::get_base_path();
		$full_path = $base_path . $snippet . '.tpl';

		if ( ! file_exists( $full_path ) ) {
			throw new \Exception( sprintf( 'Snippet file ("%s") does not exist!', $full_path ) );
		}

		if ( ! is_readable( $full_path ) ) {
			throw new \Exception( sprintf( 'Snippet file ("%s") is not readable!', $full_path ) );
		}

		$contents = file_get_contents( $full_path );
		$contents = htmlentities( $contents );

		/**
		 * Filter for snippet.
		 *
		 * Name of filter is for example `odwpap_snippet_contents-forms/helper-functions-1`.
		 *
		 * @since 0.1.0
		 *
		 * @param string $contents Contents of the snippet.
		 */
		return apply_filters( 'odwpap_snippet_contents' . $snippet, $contents );
	}

	public static function render_snippet( $snippet, $language = 'language-php', $show_hide = false, $output = true ) {

		// Firstly prepare ID - we want it without full relative path.
		$parts = explode( '/', $snippet );
		$snippet_id = array_pop( $parts );

		// Get contents of snippet file.
		try {
			$contents = Snippets_Manager::get_snippet( $snippet );
		} catch ( \Exception $e ) {

			// Snippets manager was unable to load contents of the snippet file...
			$contents = '';
		}

		// Prepare output
		$out = self::render_snippet_start( $snippet_id, $language, false ) .
		       $contents .
		       self::render_snippet_end( $snippet_id, $show_hide, false );

		// Print it's if needed
		if ( $output !== true ) {
			return $out;
		}

		echo $out;
	}

	/**
	 * Render HTML before the rendered snippet.
	 *
	 * @param string $id
	 * @param string $language
	 * @param bool $output
	 * @return string|void
	 * @since 0.1.0
	 * @uses apply_filters()
	 *
	 * @todo Don't use inline CSS rules but normal CSS classes!
	 */
	protected static function render_snippet_start( $id, $language = 'language-php', $output = true ) {

		// Get `display_source_code_examples` option
		try {
			// FIXME $display = ( bool ) Plugin::get_instance()->get_option( 'display_source_code_examples' );
			$display = true;
		} catch ( \Exception $e ) {

			// There can be thrown error if Plugin wasn't properly constructed...
			$display = true;
		}

		$style = 'max-width: 1000px;';

		if ( $display !== true ) {
			$style .= ' display: none;';
		}

		$out = sprintf(
			'<div id="code_example-%s" class="code-example"><pre style="%s"><code class="%s">',
			$id, $style, $language
		);

		/**
		 * Filter for part before the rendered snippet.
		 *
		 * @since 0.1.0
		 *
		 * @param string $before_snippet
		 */
		$before_snippet = apply_filters( 'odwpap_render_snippet_start', $out );

		// Print it's if needed
		if ( $output !== true ) {
			return $before_snippet;
		}

		echo $before_snippet;
	}

	/**
	 * Render HTML before the rendered snippet.
	 *
	 * @param string $id
	 * @param bool $show_hide
	 * @param bool $output
	 * @return string|void
	 * @since 0.1.0
	 * @uses apply_filters()
	 *
	 * @todo Don't use inline CSS rules but normal CSS classes!
	 */
	protected static function render_snippet_end( $id, $show_hide = false, $output = true ) {

		// Get `display_source_code_examples` option
		try {
			// FIXME $display = ( bool ) Plugin::get_instance()->get_option( 'display_source_code_examples' );
			$display = true;
		} catch ( \Exception $e ) {

			// There can be thrown error if Plugin wasn't properly constructed...
			$display = true;
		}

		$out = '</code></pre>';

		$label1 = __( 'Show code example', ODWPAP_DOMAIN );
		$label2 = __( 'Hide code example', ODWPAP_DOMAIN );

		if ( $show_hide === true ) {
			if ( $display === true ) {
				$visibility = 'visible';
				$label = $label2;
			} else {
				$visibility = 'collapsed';
				$label = $label1;
			}

			$out .= '' .
			        '<ul class="subsubsub" style="float: none; margin: 0px;">' .
				        '<li>' .
				            '<a href="#tr' . $id . '" class="code-example-link" data-example_id="code_example-' . $id . '" data-visibility="' . $visibility . '" data-label1="' . $label1 . '" data-label2="' . $label2 . '">' . $label . '</a>' .
				        '</li>' .
			        '</ul>';
		}

		$out .= '</div>';

		/**
		 * Filter for part after the rendered snippet.
		 *
		 * @since 0.1.0
		 *
		 * @param string $after_snippet
		 */
		$after_snippet = apply_filters( 'odwpap_render_snippet_start', $out );

		// Print it's if needed
		if ( $output !== true ) {
			return $after_snippet;
		}

		echo $after_snippet;
	}
}
