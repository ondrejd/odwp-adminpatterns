jQuery( document ).ready( function() {
    jQuery( ".submit-example button" ).click( function() {

        /* Here you should have just:
         *
         * jQuery(this).next().css( "visibility", "visible" );
         *
         * ... and some code that follows. When is execution of this code
         *
         * finished don\'t forgot to hide spinner again:
         *
         * jQuery(this).next().css( "visibility", "collapse" );
         */

        // In our demo we just toggling visibility of the spinner:
        var $elm = jQuery( this ).next();
        var sVis = $elm.css( "visibility" );
        $elm.css( "visibility", sVis == "collapse" ? "visible" : "collapse" );
    } );
} );