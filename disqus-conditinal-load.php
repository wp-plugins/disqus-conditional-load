<?php
    /*
    Plugin Name: Disqus Conditional Load
    Plugin URI: http://www.joelsays.com/disqus-conditional-load/
    Description: Plugin to prevent loading disqus on all posts and pages. Disqus will be loaded only when button is clicked.
    Author: Joel James
    Version: 4.0
    Author URI: http://www.joelsays.com/about
	Copyright (c) 2014 Joel James
    */
?>
<?php
$username = get_option('username');
if($username!==''){

function add_post_content($content) {
$type = get_option('type');
$username = get_option('username');
	if(is_single() || is_page()) {
	if($type=='click'){
	$content .= "<button onclick='load_disqus();'>Load Comments</button>
<div id='disqus_thread'></div>
<script>
function load_disqus() {
    var disqus_shortname = '".$username."';
    (function () {
        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
}
</script>";
}
else if($type='scroll'){
$content .= "<div id='disqus_thread'></div>
<script src='//code.jquery.com/jquery-1.11.0.min.js'></script>
<script src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script>
$(function(){
var disqus_div = $('#disqus_thread');
if (disqus_div.size() > 0 ) {
var ds_loaded = false,
top = disqus_div.offset().top,
disqus_data = disqus_div.data(),
check = function(){
if ( !ds_loaded && $(window).scrollTop() + $(window).height() > top ) {
ds_loaded = true;
for (var key in disqus_data) {
if (key.substr(0,6) == 'disqus') {
window['disqus_' + key.replace('disqus','').toLowerCase()] = disqus_data[key];
}
}
var dsq = document.createElement('script');
dsq.type = 'text/javascript';
dsq.async = true;
dsq.src = 'http://' + window.".$username." + '.disqus.com/embed.js';
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
}
};
$(window).scroll(check);
check();
}
});
</script>";
}
return $content;
}}
add_filter('the_content', 'add_post_content');
}
add_action('admin_menu', 'js_settings_menu');
	 
function js_settings_menu() {
	 	    add_menu_page('JS Settings', 'JS Settings', 'administrator', 'js_settings', 'js_admin');	 
			}
function js_admin() {
    include('js-admin.php');
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
?>