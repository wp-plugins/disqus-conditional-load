<?php
/*
* Admin setting form
* Using post values
*/
	// Checking for post value - Suggested by Jeff Behnke
    if( isset($_POST['oscimp_hidden']) && $_POST['oscimp_hidden'] == 'Y' ) {
        $type = $_POST['type'];
        update_option('type', $type);
		
		$button = $_POST['button'];
        update_option('button', $button);
		
		$click_hide = $_POST['click_hide'];
        update_option('click_hide', $click_hide);
		
		$disable = $_POST['disable'];
        update_option('disable', $disable);
		
		$shortcode = $_POST['shortcode'];
        update_option('shortcode', $shortcode);
         
        $username = $_POST['username'];
        update_option('username', $username);
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        $type = get_option('type');
        $username = get_option('username');
		$button = get_option('button');
		$click_hide = get_option('click_hide');
		$shortcode = get_option('shortcode');
		$disable = get_option('disable');
    }
?>
<div class="wrap">
<table width="100%">
<tr><td width="70%">
    <?php    echo "<h2>" . __( 'Disqus Conditional Load', 'oscimp_trdom' ) . " <a href='http://www.joelsays.com/disqus-conditional-load' target='_blank'>Plugin Website</a></h2>"; ?>
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="oscimp_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Disqus Load Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Load Disqus when: " ); ?><select name='type' id='type'><option value='click' <?php if($type=='click'){echo 'selected';}?>>On Click</option><option value='scroll' <?php if($type=='scroll'){echo 'selected';}?>>On Scroll</option></select></p>
        <p><?php _e("Disable comments in home page: " ); ?><select name='disable'><option value='yes' <?php if($disable=='yes'){echo 'selected';}?>>Yes</option><option value='no' <?php if($disable=='no'){echo 'selected';}?>>No</option></select></p>
		<hr />
		<div id='button_prop'><?php echo "<h4>" . __( 'Button Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Button Name: " ); ?><input type="text" name="button" value="<?php echo $button; ?>" size="20"></p>
		<p><?php _e("Hide After Click: " ); ?><select name='click_hide'><option value='yes' <?php if($click_hide=='yes'){echo 'selected';}?>>Yes</option><option value='no' <?php if($click_hide=='no'){echo 'selected';}?>>No</option></select></p>		
		<hr /></div>
		<?php    echo "<h4>" . __( 'ShortCode Settings', 'oscimp_trdom' ) . "</h4>"; ?>
		<p><?php _e("Load Comments where <b>Short Code</b> used: " ); ?><select name='shortcode'><option value='no' <?php if($shortcode=='no'){echo 'selected';}?>>No</option><option value='yes' <?php if($shortcode=='yes'){echo 'selected';}?>>Yes</option></select></p>		
		
		<hr />
		<?php    echo "<h4>" . __( 'Disqus Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Disqus Site Identification Short Name: " ); ?><input type="text" id="username" name="username" value="<?php echo $username; ?>" size="20"><br/>
		<?php _e(" <font color='green'>Please make sure you are using username for this site</font>" ); ?></p>         
     
        <p class="submit">
        <input type="submit" name="Submit" id="submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
        </p>
    </form>
</td><td width="30%" align="center">
<?php if(get_option('username')!=='') {?>
<h2><a href="https://<?php echo $username;?>.disqus.com/admin/moderate/" target="_blank"><strong>Moderate Comments</strong></a>
</h2><br/><br/><br/><br/><hr/><?php }?>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XUVWY8HUBUXY4" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif"></a><br/>
<h4>If you think my plugin is useful, please consider a small donation.</h4>
<h3>Feel free to <a href="http://www.joelsays.com/contact-me" target="_blank">Contact Me </a>if you have any doubts or feedback</h4></td></tr></table></div>
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