<?php
/*
Plugin Name: Simple Contact Form
Description: A simple contact form plugin where admins can view messages in the dashboard.
Version: 1.0
Author: Laes Uddin
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Register Custom Post Type for Messages
function scf_create_message_post_type() {
    register_post_type('scf_message', array(
        'labels' => array(
            'name' => __('Messages'),
            'singular_name' => __('Message'),
        ),
        'public' => false,
        'has_archive' => false,
        'show_ui' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-email-alt',
        'capabilities' => array(
            'create_posts' => false, // Disables "Add New" button
        ),
        'map_meta_cap' => true, // Maps default capabilities to roles
    ));
}
add_action('init', 'scf_create_message_post_type');

// Shortcode to Display Contact Form
function scf_contact_form_shortcode() {
    ob_start();
    include 'templates/contact-form.php';
    return ob_get_clean();
}
add_shortcode('simple_contact_form', 'scf_contact_form_shortcode');

// Handle Form Submission
function scf_handle_form_submission() {
    if (isset($_POST['scf_submit'])) {
        $name = sanitize_text_field($_POST['scf_name']);
        $email = sanitize_email($_POST['scf_email']);
        $message = sanitize_textarea_field($_POST['scf_message']);

        // Create a new message post
        $new_post = array(
            'post_title'   => $name,
            'post_content' => 'Email: ' . $email . "\n\nMessage: " . $message,
            'post_status'  => 'publish',
            'post_type'    => 'scf_message',
        );

        wp_insert_post($new_post);
    }
}
add_action('wp', 'scf_handle_form_submission');

function scf_contact_form_enqueue_scripts() {
    wp_enqueue_style('scf-contact-form-style', plugins_url('assets/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'scf_contact_form_enqueue_scripts');