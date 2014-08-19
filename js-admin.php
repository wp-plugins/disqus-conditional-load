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
</h3><br/><br/><br/><br/><hr/>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XUVWY8HUBUXY4" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif"></a><br/>
<h4>If you think my plugin is useful, please consider a small donation.</h4>
<h3>Feel free to <a href="http://www.joelsays.com/contact-me" target="_blank">Contact Me </a>if you have any doubts or feedback</h4></div></div>
<script src='//code.jquery.com/jquery-1.11.0.min.js'></script>
<script type="text/javascript">
$('#type').change(function(){
    var selected = $(this).val();
    if (selected == 'scroll') { $('#button_prop').hide(); }
	if (selected == 'click') { $('#button_prop').show(); }
    //etc ...
});
$( document ).ready(function() {
var bu = $( "#type" ).val();
if (bu == 'scroll') { $('#button_prop').hide(); }
if (bu == 'click') { $('#button_prop').show(); }
});

$('#submit').click(function() {
    $(".help-block").hide();
    var js_username = $( "#username" ).val();
    if(js_username==''){
        $('#username').after('<p class="help-block"><font color="red">Disqus identification name required !</font></p>');
        return false;
    }
});
</script>