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
