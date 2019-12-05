<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


function dcms_insertar_js(){

    	wp_register_script('miscript', get_stylesheet_directory_uri(). '/js/menumovil.js', array('jquery'), '1', true );
    	wp_enqueue_script('miscript');
    
}

add_action("wp_enqueue_scripts", "dcms_insertar_js");

function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

function wpdocs_child_theme_setup() {
    // load translation file for the child theme
    load_child_theme_textdomain( 'Divi', get_stylesheet_directory() . '/lang' );
}
add_action( 'after_setup_theme', 'wpdocs_child_theme_setup' );


function child_remove_parent_function() {
    remove_action( 'et_header_top', 'et_add_mobile_navigation' );
}
add_action( 'wp_loaded', 'child_remove_parent_function' );

function et_add_mobile_navigation_child(){
	if ( is_customize_preview() || ( 'slide' !== et_get_option( 'header_style', 'left' ) && 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) ) {
		printf(
			'<div id="et_mobile_nav_menu">
				<div class="mobile_nav closed">
					<span class="mobile_menu_bar mobile_menu_bar_toggle"></span>
					<span class="select_page">%1$s</span>
				</div>
			</div>',
			esc_html__( 'MENU', 'Divi' )
		);
	}
}
add_action( 'et_header_top', 'et_add_mobile_navigation_child' );

function registrar_sidebar(){
  register_sidebar(array(
   'name' => 'Menú TOP',
   'id' => 'top-bar',
   'description' => 'Widget de Traducción',
   'class' => 'sidebar',
   'before_widget' => '<div id="%1$s" class="widget %2$s">',
   'after_widget' => '</div>',
   'before_title' => '',
   'after_title' => '',
  ));
}
add_action( 'widgets_init', 'registrar_sidebar');

// remove dashicons in frontend to non-admin 
    function wpdocs_dequeue_dashicon() {
        if (current_user_can( 'update_core' )) {
            return;
        }
        wp_deregister_style('dashicons');
    }
    add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );


/**
 * Use WC 2.0 variable price format, now include sale price strikeout
 *
 * @param  string $price
 * @param  object $product
 * @return string
 */
function wc_wc20_variation_price_format( $price, $product ) {
    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( 'Desde: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'Desde: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    if ( $price !== $saleprice ) {
        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }
    
    return $price;
}
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}

/* IPROJECT RECAPTCHA Y CONTACT FORM solo carga en contacto */

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

function googleRecaptchaRemove() {
    wp_dequeue_script( 'google-recaptcha' );
}
add_action( 'wp_print_scripts', 'googleRecaptchaRemove', 100 );

function googleRecaptchaAdd() {
	if ( is_page( 'contacto' ) ) {
		wp_enqueue_script( 'google-recaptcha' );
	}
}
add_action( 'wp_print_scripts', 'googleRecaptchaAdd', 100 );

function ceramica_scripts() {
    if ( is_page( 'contacto' ) ) {
        if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
            wpcf7_enqueue_scripts();
			wpcf7_enqueue_styles();
        }
    }
}
add_action( 'wp_enqueue_scripts', 'ceramica_scripts' );


// Remove cross-sells at cart
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

