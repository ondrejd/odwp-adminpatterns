add_action( 'admin_menu', function() {
    global $menu;

    foreach ( $menu as $key => $value ) {
        if ( $menu[$key][2] == 'users.php' ) {
            $menu[$key][0] .= sprintf( ' <span class="update-plugins count-%d"><span class="plugin-count">%d</span></span>', 10, 10);
            return;
        }
    }
} );