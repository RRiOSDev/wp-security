<?php

// THIS WILL ALLOW ADDING CUSTOM CSS TO THE style.css FILE and JS code to /js/zn_script_child.js

add_action( 'wp_enqueue_scripts', 'kl_child_scripts',11 );
function kl_child_scripts() {

	wp_deregister_style( 'kallyas-styles' );
    wp_enqueue_style( 'kallyas-styles', get_template_directory_uri().'/style.css', '' , ZN_FW_VERSION );
    wp_enqueue_style( 'kallyas-child', get_stylesheet_uri(), array('kallyas-styles') , ZN_FW_VERSION );

	/**
	 **** Uncomment this line if you want to add custom javascript file
	 */
	// wp_enqueue_script( 'zn_script_child', get_stylesheet_directory_uri() .'/js/zn_script_child.js' , '' , ZN_FW_VERSION , true );

}

/* ======================================================== */

/**
 * Load child theme's textdomain.
 */
add_action( 'after_setup_theme', 'kallyasChildLoadTextDomain' );
function kallyasChildLoadTextDomain(){
   load_child_theme_textdomain( 'zn_framework', get_stylesheet_directory().'/languages' );
}

/* ======================================================== */

/**
 * Example code loading JS in Header. Uncomment to use.
 */

/* ====== REMOVE COMMENT

add_action('wp_head', 'KallyasChild_loadHeadScript' );
function KallyasChild_loadHeadScript(){

	echo '
	<script type="text/javascript">

	// Your JS code here

	</script>';

}
 ====== REMOVE COMMENT */

/* ======================================================== */

/**
 * Example code loading JS in footer. Uncomment to use.
 */

/* ====== REMOVE COMMENT

add_action('wp_footer', 'KallyasChild_loadFooterScript' );
function KallyasChild_loadFooterScript(){

	echo '
	<script type="text/javascript">

	// Your JS code here

	</script>';

}
 ====== REMOVE COMMENT */

/* ======================================================== */


//* Remove query strings from static resources 
function remove_css_js_ver( $src ) {
	if( strpos( $src, '?ver=' ) )
	$src = remove_query_arg( 'ver', $src );
	return $src;
	}
	add_filter( 'style_loader_src', 'remove_css_js_ver', 10, 2 );
	add_filter( 'script_loader_src', 'remove_css_js_ver', 10, 2 );

//* Defer parsing of javascript
if (!(is_admin() )) {

    function defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        
        // return "$url' defer ";
        return "$url' defer onload='";
    }
    add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
}

/* ======================================================== */
/* Change wp-admin file path. */

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



