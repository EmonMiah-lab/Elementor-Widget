<?php
/**
 * Plugin Name: Custom Elementor Form Widget
 * Description: A custom form widget for Elementor.
 * Version: 1.0
 * Author:Emon Miah
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Include the Elementor Widget Class.
function register_custom_elementor_form_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/custom-form-widget.php' );
    $widgets_manager->register( new \Custom_Form_Widget() );
}
add_action( 'elementor/widgets/register', 'register_custom_elementor_form_widget' );

add_action('init', function() {
    if (class_exists('Custom_Form_Widget')) {
        $widget = new Custom_Form_Widget();
        $widget->handle_form_submission();
    }
});


add_action('wp_ajax_submit_custom_form', 'submit_custom_form');
add_action('wp_ajax_nopriv_submit_custom_form', 'submit_custom_form');

function submit_custom_form() {
    if (isset($_POST['custom_email'])) {
        $name    = sanitize_text_field($_POST['custom_name']);
        $email   = sanitize_email($_POST['custom_email']);
        $message = sanitize_textarea_field($_POST['custom_message']);

        if (empty($name) || empty($email) || empty($message)) {
            echo '<div class="form-error">Please fill in all fields.</div>';
            wp_die();
        }
        if (!is_email($email)) {
            echo '<div class="form-error">Please enter a valid email address.</div>';
            wp_die();
        }

        // Process the form data.
        $to      = 'your-email@example.com';
        $subject = 'New Form Submission';
        $body    = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = ['Content-Type: text/plain; charset=UTF-8'];

        wp_mail($to, $subject, $body, $headers);

        echo '<div class="form-success">Thank you for your message!</div>';
        wp_die();
    }
}

// Include the Elementor Widget CSS style.
function custom_form_enqueue_styles() {
    wp_enqueue_style('custom-form-css', plugins_url('/assets/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'custom_form_enqueue_styles');
