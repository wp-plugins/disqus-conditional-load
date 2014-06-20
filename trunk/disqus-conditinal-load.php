<?php
    /*
    Plugin Name: Disqus Conditional Load
    Plugin URI: http://www.joelsays.com/disqus-conditional-load/
    Description: Plugin to prevent loading disqus on all posts and pages. Disqus will be loaded only when button is clicked.
    Author: Joel James
    Version: 6.1
    Author URI: http://www.joelsays.com/about
	Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XUVWY8HUBUXY4
	Copyright (c) 2014 Joel James
    */
?>
<?php
function js_emptying($file) {
$disable = get_option('disable');
if($disable=='no') :
$file = dirname( __FILE__ ) . '/empty.php';
return $file;
endif;
if($disable=='yes') :
if (!is_front_page() && !is_home()):
$file = dirname( __FILE__ ) . '/empty.php';
return $file;
endif;
endif;
}
add_filter('comments_template', 'js_emptying');
$disable = get_option('disable');
if($disable=='no') :
include('includes/js-common.php');
endif;
if($disable=='yes') :
include('includes/js-advanced.php');
endif;
add_action('admin_menu', 'js_settings_menu');	 
function js_settings_menu() {
	 	    add_menu_page('Conditional Load', 'Conditional Load', 'administrator', 'js_settings', 'js_admin',plugin_dir_url( __FILE__ ) . 'images/js-icon.png');	 
			}
function js_admin() {
    include('includes/js-admin.php');
}

register_activation_hook(__FILE__, 'my_plugin_activate');
add_action('admin_init', 'my_plugin_redirect');

function my_plugin_activate() {
    add_option('my_plugin_do_activation_redirect', true);
}
function my_plugin_redirect() {
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        wp_redirect('admin.php?page=js_settings');
    }
}

function js_conditional_load_action_links($links, $file) {
    $plugin_file = basename(__FILE__);
    if (basename($file) == $plugin_file) {

            $settings_link = '<a href="admin.php?page=js_settings">Settings</a>';    

        array_unshift($links, $settings_link);
    }
    return $links;
}
add_filter('plugin_action_links', 'js_conditional_load_action_links', 10, 2);
