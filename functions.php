/* Send 'wp-admin' to '404' page. */

add_action('login_form','redirect_wp_admin');
 
function redirect_wp_admin(){
$redirect_to = $_SERVER['REQUEST_URI'];
 
 if(count($_REQUEST)> 0 && array_key_exists('redirect_to', $_REQUEST)){
    $redirect_to = $_REQUEST['redirect_to'];
    $check_wp_admin = stristr($redirect_to, 'wp-admin');
    
    if($check_wp_admin){
        wp_safe_redirect( '404.php' );
    }
 }
}

/* Send 'wp-login' to '404' page. */
add_action( 'init', 'force_404', 1 );
function force_404() {
    $requested_uri = $_SERVER["REQUEST_URI"];
    if (strpos( $requested_uri, '/wp-login.php') !== false ) {
        // The redirect code
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
        die();
    }
}
