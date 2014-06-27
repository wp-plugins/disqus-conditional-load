<?php

/*
  Plugin Name: Disqus Conditional Load
  Plugin URI: http://www.joelsays.com/disqus-conditional-load/
  Description: Plugin to prevent loading disqus on all posts and pages. Disqus will be loaded only when button is clicked or scroll.
  Author: Joel James
  Version: 7.2
  Author URI: http://www.joelsays.com/about
  Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XUVWY8HUBUXY4
  Copyright (c) 2014 Joel James
 */
?>
<?php

$shortcode = get_option('shortcode');

if ($shortcode == 'yes') {
if(!function_exists('add_js_disqus_div')) {
    function add_js_disqus_div($js_div) {
	if (get_option('button')) {
    $button = get_option('button');
	}
else {
    $button = 'Load Comment';
	}
        $click_hide = get_option('click_hide');
        $type = get_option('type');
        if ($type == 'click') {
            $js_div .= "<div id='hidden-div' align='center'><button id='js_comment_div' onclick='load_disqus();'>".$button."</button></div>
						<div id='disqus_thread'></div>";
        }
		else if ($type = 'scroll') {
						$js_div .= "<div id='disqus_thread'></div>";
        }
        return $js_div;
    }
}
add_filter('comments_template', 'emptying');
add_shortcode('js-disqus', 'add_js_disqus_div');
}
else {
if(!function_exists('js_emptying')) {
    function js_emptying($file) {
				$disable = get_option('disable');
				if ($disable == 'no') :
				$file = dirname(__FILE__) . '/includes/comments.php';
					return $file;
				endif;
				if ($disable == 'yes') :
				if (!is_front_page() && !is_home()):
                $file = dirname(__FILE__) . '/includes/comments.php';
                return $file;
				endif;
				endif;
    }
}
add_filter('comments_template', 'js_emptying');
}



$disable = get_option('disable');
if ($disable == 'no') :
    include('includes/js-common.php');
endif;
if ($disable == 'yes') :
    include('includes/js-advanced.php');
endif;



add_action('admin_menu', 'js_settings_menu');
if(!function_exists('js_settings_menu')) {
function js_settings_menu() {
    add_menu_page('Conditional Load', 'Conditional Load', 'administrator', 'js_settings', 'js_admin', plugin_dir_url(__FILE__) . 'images/js-icon.png');
}
}

if(!function_exists('js_admin')) {
function js_admin() {
    include('includes/js-admin.php');
}
}

register_activation_hook(__FILE__, 'js_my_plugin_activate');
add_action('admin_init', 'js_my_plugin_redirect');

if(!function_exists('js_my_plugin_activate')) {
function js_my_plugin_activate() {
    add_option('js_my_plugin_do_activation_redirect', true);
}
}

if(!function_exists('js_my_plugin_redirect')) {
function js_my_plugin_redirect() {
    if (get_option('js_my_plugin_do_activation_redirect', false)):
        delete_option('js_my_plugin_do_activation_redirect');
        wp_redirect('admin.php?page=js_settings');
    endif;
}
}

if(!function_exists('js_conditional_load_action_links')) {
function js_conditional_load_action_links($links, $file) {
    $plugin_file = basename(__FILE__);
    if (basename($file) == $plugin_file) :
		$settings_link = '<a href="admin.php?page=js_settings">Settings</a>';
		array_unshift($links, $settings_link);
    endif;
    return $links;
}
}

add_filter('plugin_action_links', 'js_conditional_load_action_links', 10, 2);

if(!function_exists('emptying')) {
function emptying($file) {
    if (is_single()) :
        $file = dirname(__FILE__) . '/includes/empty.php';
    endif;
    return $file;
}
}
