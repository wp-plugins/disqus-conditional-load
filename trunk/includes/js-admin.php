<?php
/*
* Admin setting form
* Using post values
*/
    if($_POST['oscimp_hidden'] == 'Y') {
        $type = $_POST['type'];
        update_option('type', $type);
		
		$disable = $_POST['disable'];
        update_option('disable', $disable);
         
        $username = $_POST['username'];
        update_option('username', $username);
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        $type = get_option('type');
        $username = get_option('username');
		$disable = get_option('disable');
    }
?>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Disqus Conditional Load Options', 'oscimp_trdom' ) . "</h2>"; ?>
     <h3><a href="http://www.joelsays.com/disqus-conditional-load-pro" target="_blank">PRO version</a> is now available with SHORTCODE facility. <font color="green">Load Disqus where ever on the page using SHORTCODE</font></h3>
	 <p>See more and buy Disqus Conditional Load PRO <font color="green"><b><a href="http://www.joelsays.com/disqus-conditional-load-pro" target="_blank">here</a></b></font></p>
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="oscimp_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Disqus Load Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Load Disqus when: " ); ?><select name='type'><option value='click' <?php if($type=='click'){echo 'selected';}?>>On Click</option><option value='scroll' <?php if($type=='scroll'){echo 'selected';}?>>On Scroll</option></select></p>
        <p><?php _e("Disable comments in home page: " ); ?><select name='disable'><option value='yes' <?php if($disable=='yes'){echo 'selected';}?>>Yes</option><option value='no' <?php if($disable=='no'){echo 'selected';}?>>No</option></select></p>
		<hr />
        <?php    echo "<h4>" . __( 'Disqus Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Disqus Site Identification Short Name: " ); ?><input type="text" name="username" value="<?php echo $username; ?>" size="20"><?php _e(" <font color='red'>Please make sure you are using username for this site</font>" ); ?></p>         
     
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
        </p>
    </form>
</div>
<h4>If you like my plugin please do contribute as by Paypal donation <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XUVWY8HUBUXY4"><font color="green">HERE</font></a>. That will really help me to make free plugins like this.<br/><br/>
<a href="http://www.joelsays.com/contact-me" target="_blank">Contact Me </a>if you have any doubts or feedback</h4>