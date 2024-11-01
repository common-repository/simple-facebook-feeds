<?php

/*
* Plugin Name: Simple Facebook Feeds
* Plugin URI: http://www.base29.com
* Description: A simple and easy to use plugin to display your facebook feeds in your wordpress blog and website.
* Version: 1.0.1
* Author: Base29
* Author URI: http://www.base29.com
* Text Domain: simple-facebook-feeds
* Domain Path: /languages
*/

/**
 * Plugin Textdomain
 *
 * Set and define textdomain class
 *
 * @since 1.0
**/
function sff_plugin_load_textdomain() {
    load_plugin_textdomain( 'simple-facebook-feeds', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( "init", "sff_plugin_load_textdomain");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin version
 *
 * Define plugin version
 *
 * @since 1.0
**/
define("SFF_PLUGIN_VER", "1.0.1");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin directory, uri
 *
 * Set constants for pluign dirctory path and uri path
 *
 * @since 1.0
 *
 * @param 1) plugin_dir_path(__FILE__) => Get the filesystem directory path (with trailing slash) for the plugin __FILE__ passed in.
 * @param 2) plugin_dir_url(__FILE__) => Gets the URL (with trailing slash) for the plugin __FILE__ passed in.
**/
define("SFF_PLUIGN_DIR", plugin_dir_path(__FILE__));
define("SFF_OLUGIN_URI", plugin_dir_url(__FILE__));
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin Menu
 *
 * Create menu for plugin
 *
 * @since 1.0
**/
function sff_plugin_menu() {
    add_menu_page(__("Facebook Settings","simple-facebook-feeds"), __("Simple Facebook","simple-facebook-feeds"), "manage_options", "sff-fb-feeds", "sff_plugin_settings");
}
add_action("admin_menu", "sff_plugin_menu");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin Settings
 *
 * Register settings for movie plugin using "register_setting" function
 *
 * @since 1.0
 *
 * @param settings group name "sff_facebook_feed_settings"
 * @param settings register name "sff_facebook_feed_options"
**/
function sff_register_plugin_settings() {
	register_setting('sff_facebook_feed_settings', 'sff_facebook_feed_options');
}
add_action("admin_init","sff_register_plugin_settings");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin Activation Hook
 *
 * Use register activation hook for plugin. Some functionality on plugin activate
 * Add plugin setting values on plugin activate.
 *
 * @since 1.0
**/
function sff_plugin_hook() {
	$sff_facebook_feeds = array(
								'sff_page_id' => '',
							    'sff_api_token' => '',
							    'sff_show_post_by' => 'sff_me',
							    'sff_container_width' => '',
							    'sff_container_height' => '',
							    'sff_display_name_avatar' => 'on',
							    'sff_display_date' => 'on',
							    'sff_display_links' => 'on',
							    'sff_display_msg' => 'on',
							    'sff_display_view' => 'on',
							    'sff_display_cover' => 'on',
							    'sff_display_like' => 'on'
						  );

	add_option('sff_facebook_feed_options', $sff_facebook_feeds, '', 'yes');
}
register_activation_hook(__FILE__, "sff_plugin_hook");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Setting Menu
 *
 * Settings link under plugin name in plugins page
 *
 * @since 1.0.1
**/
function sff_action_links( $links ) {

    $plugin_links = array(
        '<a href="' . esc_url( admin_url( 'admin.php?page=sff-fb-feeds' ) ) . '">' . __( 'Settings', 'simple-facebook-feeds' ) . '</a>',
    );

    return array_merge( $plugin_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'sff_action_links' );
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Enqueue JS, CSS Files in admin
 *
 * Enqueue js and css files in admin area
 *
 * @since 1.0
 *
 * @param for enqueue styling "wp_register_style" and "wp_enqueue_style" use these functions
 * @param for enqueue scripts "wp_register_script" and "wp_enqueue_script" use these functions
**/
function sff_admin_scripts_styles() {
	//Enqueue admin styles
    wp_register_style("sff-admin-style", plugins_url("admin/assets/css/sff-admin-style.css",__FILE__), array(), SFF_PLUGIN_VER);
    wp_enqueue_style("sff-admin-style");

    wp_register_style("sff-admin-fontawesome", plugins_url("admin/assets/css/font-awesome.css",__FILE__), array(), SFF_PLUGIN_VER);
    wp_enqueue_style("sff-admin-fontawesome");
}
add_action("admin_enqueue_scripts", "sff_admin_scripts_styles");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Admin Head
 *
 * Call any js scripts or css code in admin head area
 *
 * @since 1.0
**/
function sff_admin_head() {
?>
	<style type='text/css' media='screen'>
        #adminmenu #toplevel_page_sff-fb-feeds div.wp-menu-image:before {
            font-family: 'FontAwesome' !important;
            content: '\f082';
        }
    </style>
<?php
}
add_action("admin_head", "sff_admin_head");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Enqueue JS, CSS Files in site
 *
 * Enqueue js and css files in front end area
 *
 * @since 1.0
 *
 * @param for enqueue styling "wp_register_style" and "wp_enqueue_style" use these functions
 * @param for enqueue scripts "wp_register_script" and "wp_enqueue_script" use these functions
**/
function sff_plugin_scripts_styles() {
	//Enqueue admin styles
    wp_register_style("sff-plugin-style", plugins_url("assets/css/sff_plugin_style.css",__FILE__), array(), SFF_PLUGIN_VER);
    wp_enqueue_style("sff-plugin-style");

    wp_register_style("sff-plugin-fontawesome", plugins_url("admin/assets/css/font-awesome.css",__FILE__), array(), SFF_PLUGIN_VER);
    wp_enqueue_style("sff-plugin-fontawesome");
}
add_action("wp_enqueue_scripts", "sff_plugin_scripts_styles");
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Front End Head
 *
 * Call any js scripts or css code in site head area
 *
 * @since 1.0
**/
function sff_plugin_head() {
	$facebook_feed_options = get_option('sff_facebook_feed_options');

	$sff_container_width = $facebook_feed_options['sff_container_width'];
	$sff_container_height = $facebook_feed_options['sff_container_height'];
?>
	<style type="text/css">
		.sff_facebook_feed {
			clear: both;
			width: <?php echo (!empty($sff_container_width) ? $sff_container_width : '100%'); ?>;
			height: <?php echo (!empty($sff_container_height) ? $sff_container_height : 'auto'); ?>;
			<?php echo (!empty($sff_container_height) ? 'overflow: auto;' : ''); ?>
		}
	</style>
<?php
}
add_action('wp_head', 'sff_plugin_head');
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin Setting Page
 *
 * Require sff-settings.php file in "sff_plugin_settings" call back funtion
 *
 * @since 1.0
**/
function sff_plugin_settings() {
	require "includes/sff-settings.php";
}
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin shortcode
 *
 * Require sff-shortcode.php file. In file shortcode created for plugin
 *
 * @since 1.0
**/
require "includes/sff-shortcode.php";
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin Widget
 *
 * Require sff-widget.php file. In file widget created for plugin
 *
 * @since 1.0.1
**/
require "includes/sff-widget.php";
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

/**
 * Plugin Snippet
 *
 * Plguin snippet 'simple_facebook_feed' for developers
 *
 * @since 1.0.1
 *
 * @param int limit in snippet for feeds
**/
function simple_facebook_feed($limit) {
	echo do_shortcode('[simple-facebook-feed limit=' . $limit . ']');
}
/*_ +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ _*/

