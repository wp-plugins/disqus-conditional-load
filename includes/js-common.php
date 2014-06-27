<?php

$username = get_option('username');
if ($username !== '') {
if(!function_exists('js_add_post_content')) {
    function js_add_post_content($content) {
        $type = get_option('type');
        $username = get_option('username');
        if (is_single() || is_page()) {
            if ($type == 'click') {
                $content .= "<script>
							function load_disqus() {
							var disqus_shortname = '" . $username . "';
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
			else if ($type = 'scroll') {
                $content .= "<script src='//code.jquery.com/jquery-1.11.0.min.js'></script>
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
										dsq.src = 'http://" . $username . ".disqus.com/embed.js';
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
        }
    }
}
add_filter('the_content', 'js_add_post_content');
}
