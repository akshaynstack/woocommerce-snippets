<?php
/*
Plugin Name: MyHeartCreative AI
Plugin URI: https://myheartcreative.com
Description: Custom plugin for MyHeartCreative users
Version: 1.0
Author: MyHeartCreative
Author URI: https://myheartcreative.com
*/

// New Super Administrator Role

// remove_role( 'administrator' );
// add_role( 'superadmin', 'Superadmin', get_role( 'administrator' )->capabilities );

// function add_superadmin_role() {
//     add_role( 'superadministrator', 'Super Administrator', array(
//         'switch_themes' => true,
//         'edit_themes' => true,
//         'activate_plugins' => true,
//         'edit_plugins' => true,
//         'edit_users' => true,
//         'edit_files' => true,
//         'manage_options' => true,
//         'moderate_comments' => true,
//         'manage_categories' => true,
//         'manage_links' => true,
//         'upload_files' => true,
//         'import' => true,
//         'unfiltered_html' => true,
//         'edit_posts' => true,
//         'edit_others_posts' => true,
//         'edit_published_posts' => true,
//         'publish_posts' => true,
//         'edit_pages' => true,
//         'read' => true,
//         'level_10' => true,
//         'level_9' => true,
//         'level_8' => true,
//         'level_7' => true,
//         'level_6' => true,
//         'level_5' => true,
//         'level_4' => true,
//         'level_3' => true,
//         'level_2' => true,
//         'level_1' => true,
//         'level_0' => true,
//         'edit_others_pages' => true,
//         'edit_published_pages' => true,
//         'publish_pages' => true,
//         'delete_pages' => true,
//         'delete_others_pages' => true,
//         'delete_published_pages' => true,
//         'delete_posts' => true,
//         'delete_others_posts' => true,
//         'delete_published_posts' => true,
//         'delete_private_posts' => true,
//         'edit_private_posts' => true,
//         'read_private_posts' => true,
//         'delete_private_pages' => true,
//         'edit_private_pages' => true,
//         'read_private_pages' => true
//     ) );
// }
// add_action( 'init', 'add_superadmin_role' );

function block_page_access() {
    if(!current_user_can('superadministrator')) {
        if (in_array($GLOBALS['pagenow'], array('themes.php','plugins.php','options-writing.php','tools.php','about.php'))) {
            wp_die("Access Denied: You do not have sufficient permissions to access this page. <a href='" . admin_url() . "'>Go to Dashboard</a>", "Access Denied");
        }

        remove_submenu_page('options-general.php','options-general.php'); // General Settings 
        remove_submenu_page('options-general.php','options-writing.php'); // Writing Settings 
        remove_submenu_page('options-general.php','options-reading.php'); // Reading Settings 
        remove_submenu_page('options-general.php','options-discussion.php'); // Discussion Settings 
        remove_submenu_page('options-general.php','options-media.php'); // Media Settings 
        remove_submenu_page('options-general.php','options-permalink.php'); // Permalink Settings 
        remove_submenu_page('options-general.php','options-privacy.php'); // Privacy Settings 
        remove_submenu_page('options-general.php','disable_comments_settings'); // Disable Comments Settings 
        remove_submenu_page('woocommerce','wc-settings'); // wc-settings Settings 
        remove_submenu_page('woocommerce','wc-addons'); // wc-addons Settings 
        remove_submenu_page('woocommerce','wc-status'); // wc-status Settings 

    }
}
add_action('admin_init', 'block_page_access');

// Removes WordPress Logo from Admin Bar

function example_admin_bar_remove_logo() {
    if(!current_user_can('superadministrator')) {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
    }
}
add_action( 'wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0 );

function remove_dashboard_widgets() {
    if(!current_user_can('superadministrator')) {
        remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //removing activity widget
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //removing right now widget
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //keeping quick press widget
        remove_meta_box('dashboard_primary', 'dashboard', 'side'); //keeping primary widget
        remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
        
    }
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

// Remove Add New User from Admin Bar Menu

function wpse_260669_remove_new_content_items(){
    if(!current_user_can('superadministrator')) {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu( 'new-user' );
    }
}
add_action( 'wp_before_admin_bar_render', 'wpse_260669_remove_new_content_items' );

// Remove all admin menu items
function remove_admin_menus() {
    if(!current_user_can('superadministrator')) {
    global $menu;
    $restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
    end ($menu);
    while (prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
    }
}
}
add_action( 'admin_menu', 'remove_admin_menus' );

// Add new menu items
function add_new_admin_menu() {
    if(!current_user_can('superadministrator')) {
    add_menu_page( 'Posts', 'Posts', 'manage_options', 'edit.php', '', 'dashicons-admin-post', 6 ); 
    add_menu_page( 'Pages', 'Pages', 'manage_options', 'edit.php?post_type=page', '', 'dashicons-admin-page', 10 ); 
    add_menu_page( 'Media', 'Media', 'manage_options', 'upload.php', '', 'dashicons-admin-media', 15 ); 
    add_menu_page( 'Settings', 'Settings', 'manage_options', 'options-general.php', '', 'dashicons-admin-settings', 99 ); 
    add_menu_page( 'Users', 'Users', 'manage_options', 'users.php', '', 'dashicons-admin-users', 99 ); 
}
}
add_action( 'admin_menu', 'add_new_admin_menu' );

// Read only admin email
function make_admin_email_readonly() {
    if(!current_user_can('superadministrator')) {
    global $pagenow;
    if ( 'options-general.php' != $pagenow ) {
        return;
    }
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#new_admin_email').attr('readonly','readonly');
            $('#siteurl').attr('readonly','readonly');
            $('#home').attr('readonly','readonly');
        });
    </script>
    <?php
}
}
add_action('admin_footer', 'make_admin_email_readonly');

// Deny Access and Redirection for Dashboard
function deny_access_to_dashboard() {
    global $pagenow;
    // Get the current user's username
    $username = wp_get_current_user()->user_login;
    if(!current_user_can('superadministrator') && $pagenow == "index.php") {
        wp_redirect(admin_url('edit.php'));
        exit;
    }
}
add_action( 'admin_init', 'deny_access_to_dashboard' );

// Disable editing super admin "myheartcreative"
function disable_user_edit( $actions, $user_object ) {
    if ( $user_object->user_login === 'myheartcreative' ) {
        if(!current_user_can('superadministrator')) {
        unset( $actions['edit'] );
        unset( $actions['delete'] );
        unset( $actions['view'] );
        unset( $actions['resetpassword'] );

        unset( $actions['edit'] );
    }
}
    return $actions;
}
add_filter( 'user_row_actions', 'disable_user_edit', 10, 2 );

// Ready only superadmin
function remove_user_link( $value, $column_name, $user_id ) {
    if ( 'username' === $column_name && get_userdata( $user_id )->user_login === 'myheartcreative' ) {
        return $value;
    }
    return $value = "<a href='users.php?page=users&action=edit&user=$user_id'>" . $value . "</a>";
}
add_filter( 'manage_users_custom_column', 'remove_user_link', 10, 3 );