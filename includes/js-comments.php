<?php
defined('ABSPATH') or die("Crap ! You can not access this directly.");

if (DISQUS_DEBUG) {
    echo "<p><strong>Disqus Debug</strong> thread_id: ".get_post_meta($post->ID, 'dsq_thread_id', true)."</p>";
}

require_once( dirname(__FILE__) . '/functions/js-options.php' );

	if((!js_check_shortcode('js-disqus') && $js_shortcode == 'yes') || $js_shortcode == 'no') {
?>
<div id="disqus_thread">
<?php if($js_type == 'click'){ ?>
    <div id='hidden-div' align='center'>
	<button id='js_comment_div' class="<?php echo $js_class; ?>" style="margin-bottom:20px;"><?php echo $js_button; ?></button>
	</div>
<?php } if (!get_option('disqus_disable_ssr') && have_comments()): ?>
        <div id="dsq-content"></div>

    <?php endif; ?>
</div>
<?php } ?>
<script type="text/javascript">
/* <![CDATA[ */
    var disqus_url = '<?php echo get_permalink(); ?>';
    var disqus_identifier = '<?php echo dsq_identifier_for_post($post); ?>';
    var disqus_container_id = 'disqus_thread';
    var disqus_domain = '<?php echo DISQUS_DOMAIN; ?>';
    var disqus_shortname = '<?php echo strtolower(get_option('disqus_forum_url')); ?>';
    var disqus_title = <?php echo cf_json_encode(dsq_title_for_post($post)); ?>;
    var disqus_config = function () {
        var config = this; // Access to the config object
        config.language = '<?php echo esc_js(apply_filters('disqus_language_filter', '')) ?>';

        /* Add the ability to add javascript callbacks */
        <?php do_action( 'disqus_config' ); ?>

        /*
           All currently supported events:
            * preData — fires just before we request for initial data
            * preInit - fires after we get initial data but before we load any dependencies
            * onInit  - fires when all dependencies are resolved but before dtpl template is rendered
            * afterRender - fires when template is rendered but before we show it
            * onReady - everything is done
         */

        config.callbacks.preData.push(function() {
            // clear out the container (its filled for SEO/legacy purposes)
            document.getElementById(disqus_container_id).innerHTML = '';
        });
        <?php if (!get_option('disqus_manual_sync')): ?>
        config.callbacks.onReady.push(function() {
            // sync comments in the background so we don't block the page
            var script = document.createElement('script');
            script.async = true;
            script.src = '?cf_action=sync_comments&post_id=<?php echo $post->ID; ?>';

            var firstScript = document.getElementsByTagName( "script" )[0];
            firstScript.parentNode.insertBefore(script, firstScript);
        });
        <?php endif; ?>
        <?php
        $sso = dsq_sso();
        if ($sso) {
            foreach ($sso as $k=>$v) {
                echo "this.page.{$k} = '{$v}';\n";
            }
            echo dsq_sso_login();
        }
        ?>
    };
/* ]]> */
</script>

<script type="text/javascript">
/* <![CDATA[ */
    var DsqLocal = {
        'trackbacks': [
<?php
    $count = 0;
    foreach ((array)$comments as $comment) {
        $comment_type = get_comment_type();
        if ( $comment_type != 'comment' ) {
            if( $count ) { echo ','; }
?>
            {
                'author_name':    <?php echo cf_json_encode(get_comment_author()); ?>,
                'author_url':    <?php echo cf_json_encode(get_comment_author_url()); ?>,
                'date':            <?php echo cf_json_encode(get_comment_date('m/d/Y h:i A')); ?>,
                'excerpt':        <?php echo cf_json_encode(str_replace(array("\r\n", "\n", "\r"), '<br />', get_comment_excerpt())); ?>,
                'type':            <?php echo cf_json_encode($comment_type); ?>
            }
<?php
            $count++;
        }
    }
?>
        ],
        'trackback_url': <?php echo cf_json_encode(get_trackback_url()); ?>
    };
/* ]]> */
</script>
<?php
if($js_type == 'normal'){
	add_action('wp_footer', 'js_normal_conditional_code', 100);
}
else
{
	add_action('wp_footer', 'js_comments_hash_load', 100);
	add_action('wp_footer', 'js_disqus_conditional_code', 100);
}