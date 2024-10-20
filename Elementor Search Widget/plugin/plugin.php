<?php
/**
 * Plugin Name: Elementor Search Widget
 * Description: A custom search widget for Elementor"
 * Version: 1.0
 * Author: Emon Miah
 * Author URI: https://wpmkr.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function register_custom_widget() {
    require_once plugin_dir_path( __FILE__ ) . 'widget.php';
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new My_Custom_Widget() );
}
add_action( 'elementor/widgets/widgets_registered', 'register_custom_widget' );


// Register Scripts & Styles
function enqueue_elementor_search_widget_assets() {
    wp_enqueue_style( 'search-widget-css', plugin_dir_url( __FILE__ ) . 'style.css' );
    wp_enqueue_script( 'search-widget-js', plugin_dir_url( __FILE__ ) . 'script.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_elementor_search_widget_assets' );
