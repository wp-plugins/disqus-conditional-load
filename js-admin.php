<?php
/*
* Admin setting form
* Using post values
*/
	// Checking for post value - Suggested by Jeff Behnke
    if( isset($_POST['js_hidden']) && $_POST['js_hidden'] == 'Y' ) {
        $type = $_POST['type'];
        update_option('type', $type);
		
		$button = $_POST['button'];
        update_option('button', $button);
        
        $class = $_POST['class'];
        update_option('class', $class);
		
		$shortcode = $_POST['shortcode'];
        update_option('shortcode', $shortcode);
         
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        $type = get_option('type');
		$button = get_option('button');
                $class = get_option('class');
		$hide = get_option('hide');
		$shortcode = get_option('shortcode');
    }
?>
<div class="wrap" style="padding-top: 1.5cm;">
<div style="width:70%; float:left;">
    <?php    echo "<h3>" . __( 'Disqus Conditional Load', 'oscimp_trdom' ) . " <a href='http://www.joelsays.com/disqus-conditional-load' target='_blank'>Plugin Website</a></h3>"; ?>
    <form name="oscimp_form" method="post" action="?page=disqus">
	<?php wp_nonce_field('dsq-wpnonce_js', 'dsq-form_nonce_js'); ?>
        <input type="hidden" name="js_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Disqus Load Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Load Disqus when: " ); ?><select name='type' id='type'><option value='click' <?php if($type=='click'){echo 'selected';}?>>On Click</option><option value='scroll' <?php if($type=='scroll'){echo 'selected';}?>>On Scroll</option></select></p>
		<p>This option will prevent Disqus from automatically loading comments and scripts on pages or posts.</p>
		<hr />
		<div id='button_prop'><?php echo "<h4>" . __( 'Button Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Button Name: " ); ?><input type="text" name="button" value="<?php echo $button; ?>" size="20"></p>
        <p><?php _e("Button Class: " ); ?><input type="text" name="class" value="<?php echo $class; ?>" size="20"><br/>
        By using custom class you can use your own style for comment button. Leave empty if you don't want.</p>	
		<hr /></div>
		<?php    echo "<h4>" . __( 'ShortCode Settings', 'oscimp_trdom' ) . "</h4>"; ?>
                <p><?php _e("Load Comments where <b>Short Code</b> used: " ); ?><select name='shortcode'><option value='no' <?php if($shortcode=='no'){echo 'selected';}?>>No</option><option value='yes' <?php if($shortcode=='yes'){echo 'selected';}?>>Yes</option></select><br/>
                    Please note that if you enable this comments will be loaded only where shortcode <b>[js-disqus]</b> used.</p>
        <p class="submit">
        <button class="button-primary button" type="submit" name="Submit" id="submit"><?php _e('Update Options', 'oscimp_trdom' ) ?></button>
        </p>
    </form>
</div>
<div style="width:30%; float:right;" align="center">
<?php
$base = is_ssl() ? 'https://' : 'http://';
$url = get_option('disqus_forum_url');
if ($url) { $mod_url = $base.$url.'.'.DISQUS_DOMAIN.'/admin/moderate/';}
else { $mod_url = DISQUS_URL.'admin/moderate/'; }
?>
<h3><a href="<?php echo $mod_url;?>" target="_blank"><strong>Moderate Comments</strong></a>
</h3><br/><hr/>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XUVWY8HUBUXY4" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif"></a><br/>
<h4>It takes a lot of my time while developing and giving plugin support for free. Please consider a small donation if you found this plugin useful..</h4>
<h3>Feel free to <a href="http://www.joelsays.com/contact-me" target="_blank">Contact Me </a>if you have any doubts or feedback</h4>
<h3><a href="http://www.joelsays.com/members-area/support/plugin-support-disqus-conditional-load/" target="_blank">Support Forum</a></h4><br/>

<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2FSaysJoel&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=1406599162929386" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe>
<a href="https://twitter.com/Joel_James" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @Joel_James</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script><br/><br/>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/0/105457272740332174541" data-rel="author"></div>
</div></div>

<script type="text/javascript">
jQuery('#type').change(function(){
    var selected = jQuery(this).val();
    if (selected == 'scroll') { jQuery('#button_prop').hide(); }
	if (selected == 'click') { jQuery('#button_prop').show(); }
    //etc ...
});
jQuery( document ).ready(function() {
var bu = jQuery( "#type" ).val();
if (bu == 'scroll') { jQuery('#button_prop').hide(); }
if (bu == 'click') { jQuery('#button_prop').show(); }
});

jQuery('#submit').click(function() {
    jQuery(".help-block").hide();
    var js_username = jQuery( "#username" ).val();
    if(js_username==''){
        jQuery('#username').after('<p class="help-block"><font color="red">Disqus identification name required !</font></p>');
        return false;
    }
});
</script>