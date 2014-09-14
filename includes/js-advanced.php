<div id="dsq-advanced" class="dsq-content dsq-advanced"<?php if (!$show_advanced) echo ' style="display:none;"'; ?>>
	<div class="wrap">
        <h3><?php echo dsq_i('Disqus Conditional Load'); ?> <a href='http://www.joelsays.com/plugins/disqus-conditional-load/' target='_blank'>Plugin Website</a></h3>
        <?php echo dsq_i('<h4>Version: 8.0.9</h4>') ?>
        <?php
        if (get_option('disqus_active') == '0') {
            // disqus is not active
            echo dsq_i('<p class="status">Disqus comments are currently <span class="dsq-disabled-text">disabled</span>. (<a href="?page=disqus&amp;active=1">Enable</a>)</p>');
        } else {
            echo dsq_i('<p class="status">Disqus comments are currently <span class="dsq-enabled-text">enabled</span>. (<a href="?page=disqus&amp;active=0">Disable</a>)</p>');
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
        <?php wp_nonce_field('dsq-wpnonce_settings', 'dsq-form_nonce_settings'); ?>
        <div>
		
                <?php echo dsq_i('<h3>General</h3>'); ?>
            
            
                <?php echo dsq_i('<b>Forum Shortname</b>'); ?>
                
                    <input type="hidden" name="disqus_forum_url" value="<?php echo esc_attr($dsq_forum_url); ?>"/>
                    <code><?php echo esc_attr($dsq_forum_url); ?></code>
                    <br />
                    <?php echo dsq_i('This is the unique identifier for your website in Disqus, automatically set during installation.'); ?>
                
            <br/><br/><hr/>	
            
                <?php echo dsq_i('<h3>Appearance</h3>'); ?>
            
            
                <?php echo dsq_i('Use Disqus Comments on'); ?>
                
                    <select name="disqus_replace" tabindex="1" class="disqus-replace">
                        <option value="all" <?php if($dsq_replace == 'all'){echo 'selected';}?>><?php echo dsq_i('All blog posts.'); ?></option>
                        <option value="closed" <?php if('closed'==$dsq_replace){echo 'selected';}?>><?php echo dsq_i('Blog posts with closed comments only.'); ?></option>
                    </select>
                    <br />
                    <?php 
                        if ($dsq_replace == 'closed') echo '<p class="dsq-alert">'.dsq_i('You have selected to only enable Disqus on posts with closed comments. If you aren\'t seeing Disqus on new posts, change this option to <strong>All blog posts</strong>.').'</p>';
                        else echo dsq_i('Shows comments on either all blog posts, or ones with closed comments. Select the <strong>Blog posts with closed comments only</strong> option if you plan on disabling Disqus, but want to keep it on posts which already have comments.'); 
                    ?>
                
            
			<br/><br/><hr/>
			
            
                <?php echo dsq_i('<h3>Sync</h3>'); ?>
            
            
                <?php echo dsq_i('<h4>Comment Importing</h4>'); ?>
                
                    <input type="checkbox" id="disqus_manual_sync" name="disqus_manual_sync" <?php if($dsq_manual_sync){echo 'checked="checked"';}?> >
                    <label for="disqus_manual_sync"><?php echo dsq_i('Disable automated comment importing'); ?></label>
                    <br /><?php echo dsq_i('If you have problems with WP-Cron taking too long, or have a large number of comments, you may wish to disable automated sync. Comments will only be imported to your local Wordpress database if you do so manually.'); ?>
                <br/><br/>
            
            
                <?php echo dsq_i('<h4>Server-Side Rendering</h4>'); ?>
                
                    <input type="checkbox" id="disqus_disable_ssr" name="disqus_disable_ssr" <?php if($dsq_disable_ssr){echo 'checked="checked"';}?> >
                    <label for="disqus_disable_ssr"><?php echo dsq_i('Disable server-side rendering of comments'); ?></label>
                    <br /><?php echo dsq_i('Hides comments from nearly all search engines.'); ?><br/><br/>
                
            
			<hr/>
			
            
                <?php echo dsq_i('<h3>Patches</h3>'); ?>
            

            
                <?php echo dsq_i('<h4>Template Conflicts</h4>'); ?>
                
                    <input type="checkbox" id="disqus_comment_count" name="disqus_cc_fix" <?php if($dsq_cc_fix == '1'){ echo 'checked="checked"'; } ?> >
                    <label for="disqus_comment_count"><?php echo dsq_i('Output JavaScript in footer'); ?></label>
                    <br /><?php echo dsq_i('Enable this if you have problems with comment counts or other irregularities. For example: missing counts, counts always at 0, Disqus code showing on the page, broken image carousels, or longer-than-usual home page load times (<a href="%s" onclick="window.open(this.href); return false">more info</a>).', 'https://help.disqus.com/customer/portal/articles/472005-wordpress-troubleshooting'); ?>
                
            <br/>
			
			<br/><hr/>
            
                <?php echo dsq_i('<h3>Advanced</h3><h4>Single Sign-On</h4><p>Allows users to log in to Disqus via WordPress. (<a href="%s" onclick="window.open(this.href); return false">More info on SSO</a>)</p>', 'https://help.disqus.com/customer/portal/articles/684744'); ?>
            
            <?php if (!empty($dsq_partner_key)) {// this option only shows if it was already present ?>
            
                <?php echo dsq_i('Disqus Partner Key'); ?>
                
                    <input type="text" name="disqus_partner_key" value="<?php echo esc_attr($dsq_partner_key); ?>" tabindex="2"><br/>
                
            
            <?php } ?>
            
                <?php echo dsq_i('API Application Public Key'); ?>
                
                    <input type="text" name="disqus_public_key" value="<?php echo esc_attr($dsq_public_key); ?>" tabindex="2">
                    <?php echo dsq_i('Found at <a href="%s">Disqus API Applications</a>.','https://disqus.com/api/applications/'); ?><br/><br/>
                
            
            
                <?php echo dsq_i('API Application Secret Key'); ?>
                
                    <input type="text" name="disqus_secret_key" value="<?php echo esc_attr($dsq_secret_key); ?>" tabindex="2">
                    <?php echo dsq_i('Found at <a href="%s">Disqus API Applications</a>.','https://disqus.com/api/applications/'); ?><br/><br/>
                
            
            
                <?php echo dsq_i('Custom Log-in Button'); ?>
                
                    <?php if (!empty($dsq_sso_button)) { ?>
                    <img src="<?php echo esc_attr($dsq_sso_button); ?>" alt="<?php echo esc_attr($dsq_sso_button); ?>" />
                    <br />
                    <?php } ?>

                    <?php if ( version_compare($wp_version, '3.5', '>=') ) {
                        // HACK: Use WP's new (as of WP 3.5), streamlined, much-improved built-in media uploader

                        // Use WP 3.5's new consolidated call to get all necessary media uploader scripts and styles
                        wp_enqueue_media(); ?>

                        <script type="text/javascript">
                        // Uploading files
                        var file_frame;

                          jQuery('.upload_image_button').live('click', function( event ){

                            event.preventDefault();

                            // If the media frame already exists, reopen it.
                            if ( file_frame ) {
                              file_frame.open();
                              return;
                            }

                            // Create the media frame.
                            file_frame = wp.media.frames.file_frame = wp.media({
                              title: jQuery( this ).data( 'uploader_title' ),
                              button: {
                                text: jQuery( this ).data( 'uploader_button_text' ),
                              },
                              multiple: false  // Set to true to allow multiple files to be selected
                            });

                            // When an image is selected, run a callback.
                            file_frame.on( 'select', function() {
                              // We set multiple to false so only get one image from the uploader
                              attachment = file_frame.state().get('selection').first().toJSON();

                              // Do something with attachment.id and/or attachment.url here
                              jQuery('#disqus_sso_button').val(attachment.url);
                            });

                            // Finally, open the modal
                            file_frame.open();
                          });
                        </script>

                        <input type="button" value="<?php echo ($dsq_sso_button ? dsq_i('Change') : dsq_i('Choose')).' '.dsq_i('button'); ?>" class="button upload_image_button" tabindex="2">
                        <input type="hidden" name="disqus_sso_button" id="disqus_sso_button" value=""/>
                    <?php } else { // use pre-WP 3.5 media upload functionality ?>
                        <input type="file" name="disqus_sso_button" value="<?php echo esc_attr($dsq_sso_button); ?>" tabindex="2">
                    <?php } ?>
                    <br />
                    <?php echo dsq_i('Adds a button to the Disqus log-in interface. (<a href="%s">Example screenshot</a>.)','https://d8v2sqslxfuhj.cloudfront.net/docs/sso-button.png'); ?>
                    <?php echo dsq_i('<br />See <a href="%s">our SSO button documentation</a> for a template to create your own button.','https://help.disqus.com/customer/portal/articles/236206#sso-login-button'); ?>
                
            
			
        </div>

        <p class="submit" style="text-align: left">
            <input type="hidden" name="disqus_api_key" value="<?php echo esc_attr($dsq_api_key); ?>"/>
            <input type="hidden" name="disqus_user_api_key" value="<?php echo esc_attr($dsq_user_api_key); ?>"/>
            <input name="submit" type="submit" value="Save" class="button-primary button" tabindex="4">
        </p>
        </form>

		<br/><hr/>
		
        <h3>Import and Export</h3>

   
            <?php if (DISQUS_CAN_EXPORT): ?>

                <?php echo dsq_i('<h4>Export comments to Disqus</h4>'); ?>
                
                    <div id="dsq_export">
                        <p class="status"><a href="#" class="button"><?php echo dsq_i('Export Comments'); ?></a>  <?php echo dsq_i('This will export your existing WordPress comments to Disqus'); ?></p>
                    </div><br/><br/>
                
            
            <?php endif; ?>
            
                <?php echo dsq_i('<h4>Sync Disqus with WordPress</h4>'); ?>
                
                    <div id="dsq_import">
                        <div class="status">
                            <p><a href="#" class="button"><?php echo dsq_i('Sync Comments'); ?></a>  <?php echo dsq_i('This will download your Disqus comments and store them locally in WordPress'); ?></p>
                            <label><input type="checkbox" id="dsq_import_wipe" name="dsq_import_wipe" value="1"/> <?php echo dsq_i('Remove all imported Disqus comments before syncing.'); ?></label><br/>
                        </div>
                    </div><br/><br/>
                
            
        <hr/>

        <h3>Reset</h3>

            
                <?php echo dsq_i('<h4>Reset Disqus</h4>'); ?>
                
                    <form action="?page=disqus" method="POST">
                        <?php wp_nonce_field('dsq-wpnonce_reset', 'dsq-form_nonce_reset'); ?>
                        <p><input type="submit" value="Reset" name="reset" onclick="return confirm('<?php echo dsq_i('Are you sure you want to reset the Disqus plugin?'); ?>')" class="button" /> <?php echo dsq_i('This removes all Disqus-specific settings. Comments will remain unaffected.') ?></p>
                        <?php echo dsq_i('If you have problems with resetting taking too long you may wish to first manually drop the <code>disqus_dupecheck</code> index from your <code>commentmeta</code> table.') ?>
                    </form>
                
            
        
        <br/>
    </div>
	</div>