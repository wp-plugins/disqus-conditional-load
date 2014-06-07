<?php
    /*
    Plugin Name: Disqus Conditional Load
    Plugin URI: http://www.joelsays.com
    Description: Plugin to prevent loading disqus on all posts and pages. Disqus will be loaded only when button is clicked.
    Author: Joel James
    Version: 1.0
    Author URI: http://www.joelsays.com/about
	Copyright (c) 2014 Joel James
    */
?>
<?php
function add_post_content($content) {
	if(is_single() || is_page()) {
	$content .= "<button onclick='load_disqus();'>Load Comments</button>
<div id='disqus_thread'></div>
<script>
function load_disqus() {
    var disqus_shortname = 'joeljames';
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
return $content;
}
add_filter('the_content', 'add_post_content');
?>