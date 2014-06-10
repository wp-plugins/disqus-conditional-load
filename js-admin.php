<?php
    if($_POST['oscimp_hidden'] == 'Y') {
        //Form data sent
        $type = $_POST['type'];
        update_option('type', $type);
         
        $username = $_POST['username'];
        update_option('username', $username);
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        //Normal page display
        $type = get_option('type');
        $username = get_option('username');
    }
?>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Disqus Conditional Load Options', 'oscimp_trdom' ) . "</h2>"; ?>
     <h3><font color="green">Please make sure that you have not enabled comments on the posts/pages</font></h3>
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="oscimp_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Disqus Load Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Load Disqus when: " ); ?><select name='type'><option value='click' <?php if($type=='click'){echo 'selected';}?>>On Click</option><option value='scroll' <?php if($type=='scroll'){echo 'selected';}?>>On Scroll</option></select></p>
        <hr />
        <?php    echo "<h4>" . __( 'Disqus Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Your Disqus username: " ); ?><input type="text" name="username" value="<?php echo $username; ?>" size="20"><?php _e(" <font color='red'>Please make sure you are using username for this site</font>" ); ?></p>         
     
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
        </p>
    </form>
</div>
<h4>If you like my plugin please do contribute as by Paypal donation (<font color="green">mr.joelcj@gmail.com</font>). That will really help me to make free plugins like this.<br/><br/>
<a href="http://www.joelsays.com/contact-me" target="_blank">Contact Me </a>if you have any doubts or feedback</h4>