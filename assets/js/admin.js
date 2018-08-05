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

jQuery( document ).ready( function() {
    jQuery( ".code-example-link" ).click( function() {
        var example_id = jQuery( this ).data( "example_id" ),
            visibility = jQuery( this ).data( "visibility" ),
            label1 = jQuery( this ).data( "label1" ),
            label2 = jQuery( this ).data( "label2" );

        if ( visibility === "collapsed" ) {
            jQuery( "#" + example_id + " pre" ).css( "display", "block" );
            jQuery( this ).data( "visibility", "visible" ).text( label2 );
        } else {
            jQuery( "#" + example_id + " pre" ).css( "display", "none" );
            jQuery( this ).data( "visibility", "collapsed" ).text( label1 );
        }
        return false;
    } );
} );