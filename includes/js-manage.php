<?php
// HACK: For old versions of WordPress
if ( !function_exists('wp_nonce_field') ) {
    function wp_nonce_field() {}
}

global $dsq_api;

require(ABSPATH . 'wp-includes/version.php');

if ( !current_user_can('moderate_comments') ) {
    die('The account you\'re logged in to doesn\'t have permission to access this page.');
}

function has_valid_nonce() {
    $nonce_actions = array('upgrade', 'reset', 'install', 'settings', 'js');
    $nonce_form_prefix = 'dsq-form_nonce_';
    $nonce_action_prefix = 'dsq-wpnonce_';

    // Check all available nonce actions
    foreach ( $nonce_actions as $key => $value ) {
        if ( isset($_POST[$nonce_form_prefix.$value]) ) {
            check_admin_referer($nonce_action_prefix.$value, $nonce_form_prefix.$value);
            return true;
        }
    }

    return false;
}

if ( ! empty($_POST) ) {
    $nonce_result_check = has_valid_nonce();
    if ($nonce_result_check === false) {
        die('Unable to save changes. Make sure you are accessing this page from the Wordpress dashboard.');
    }
}

if( isset($_POST['dsq_username']) ) {
    $_POST['dsq_username'] = stripslashes($_POST['dsq_username']);
}

if( isset($_POST['dsq_password']) ) {
    $_POST['dsq_password'] = stripslashes($_POST['dsq_password']);
}

// Handle export function.
if( isset($_POST['export']) and DISQUS_CAN_EXPORT ) {
    require_once(dirname(__FILE__) . '/js-export.php');
    dsq_export_wp();
}

// Handle resetting.
if ( isset($_POST['reset']) ) {
    foreach (dsq_options() as $opt) {
        delete_option($opt);
    }
	delete_option('type');
	delete_option('button');
	delete_option('class');
	delete_option('message');
	delete_option('shortcode');
	delete_option('count_send');
    unset($_POST);
    dsq_reset_database();
?>
<div class="wrap">
    <h2><?php echo dsq_i('Disqus Reset'); ?></h2>
    <form method="POST" action="?page=disqus">
        <?php wp_nonce_field('dsq-wpnonce_reset', 'dsq-form_nonce_reset'); ?>
        <p><?php echo dsq_i('Disqus has been reset successfully.') ?></p>
        <ul style="list-style: circle;padding-left:20px;">
            <li><?php echo dsq_i('Local settings for the plugin were removed.') ?></li>
            <li><?php echo dsq_i('Database changes by Disqus were reverted.') ?></li>
        </ul>
        <p><?php echo dsq_i('If you wish to <a href="?page=disqus&amp;step=1">reinstall</a>, you can do that now.') ?></p>
    </form>
</div>
<?php
die();
}

// Post fields that require verification.
$check_fields = array(
    'dsq_user_api_key' => array(
            'key_name' => 'dsq_user_api_key',
            'min' => 64,
            'max' => 64,
        ), 
    'disqus_api_key' => array(
            'key_name' => 'disqus_api_key',
            'min' => 64,
            'max' => 64,
        ),  
    'disqus_public_key' => array(
            'key_name' => 'disqus_public_key',
            'min' => 64,
            'max' => 64,
        ),  
    'disqus_secret_key' => array(
            'key_name' => 'disqus_secret_key',
            'min' => 64,
            'max' => 64,
        ),  
    'disqus_partner_key' => array(
            'key_name' => 'disqus_partner_key',
            'min' => 64,
            'max' => 64,
        ), 
    'dsq_forum' => array(
            'key_name' => 'dsq_forum',
            'min' => 1,
            'max' => 64,
        ), 
    'disqus_forum_url' => array(
            'key_name' => 'disqus_forum_url',
            'min' => 1,
            'max' => 64,
        ), 
    'disqus_replace' => array(
            'key_name' => 'disqus_replace',
            'min' => 3,
            'max' => 6,
        ),
    'dsq_username' => array(
            'key_name' => 'dsq_username',
            'min' => 3,
            'max' => 250,
        ),
    );

// Check keys keys and remove bad input.
foreach ( $check_fields as $key ) {

    if ( isset($_POST[$key['key_name']]) ) {

        // Strip tags before checking
        $_POST[$key['key_name']] = trim(strip_tags($_POST[$key['key_name']]));

        // Check usernames independently because they can have special characters 
        // or be email addresses
        if ( 'dsq_username' ===  $key['key_name'] ) {
            if ( !is_valid_dsq_username($_POST[$key['key_name']], $key['min'], $key['max']) ) {
                unset($_POST[$key['key_name']]);
            }
        }
        else {
            if ( !is_valid_dsq_key($_POST[$key['key_name']], $key['min'], $key['max']) ) {
                unset($_POST[$key['key_name']]);
            }
        }
    }
}

function is_valid_dsq_username($value, $min=3, $max=250) {
    if ( is_email($value) ) {
        return true;
    }
    else {
        return is_valid_dsq_key($value, $min, $max);
    }
}

function is_valid_dsq_key($value, $min=1, $max=64) {
    return preg_match('/^[\0-9\\:A-Za-z_-]{'.$min.','.$max.'}+$/', $value);
}

// Handle advanced options.
if  (isset($_POST['disqus_forum_url']) && isset($_POST['disqus_replace'])){
    update_option('disqus_partner_key', trim(stripslashes($_POST['disqus_partner_key'])));
    update_option('disqus_replace', $_POST['disqus_replace']);
    update_option('disqus_cc_fix', isset($_POST['disqus_cc_fix']));
    update_option('disqus_manual_sync', isset($_POST['disqus_manual_sync']));
    update_option('disqus_disable_ssr', isset($_POST['disqus_disable_ssr']));
    update_option('disqus_public_key', $_POST['disqus_public_key']);
    update_option('disqus_secret_key', $_POST['disqus_secret_key']);
    // Handle any SSO button and icon uploads
    if ( version_compare($wp_version, '3.5', '>=') ) {
        // Use WP 3.5's new, streamlined, much-improved built-in media uploader

        // Only update if a value is actually POSTed, otherwise any time the form is saved the button and icon will be un-set
        if ($_POST['disqus_sso_button']) { update_option('disqus_sso_button', $_POST['disqus_sso_button']); }
    } else {
        // WP is older than 3.5, use legacy, less-elegant media uploader
        if(isset($_FILES['disqus_sso_button'])) {
            dsq_image_upload_handler('disqus_sso_button');
        }
    }
    dsq_manage_dialog(dsq_i('Your settings have been changed.'));
}
if(isset($_POST['js_hidden'])){
dsq_manage_dialog(dsq_i('Your settings have been changed.'));
}

// handle disqus_active
if ( isset($_GET['active']) ) {
    update_option('disqus_active', ($_GET['active'] == '1' ? '1' : '0'));
}

$dsq_user_api_key = isset($_POST['dsq_user_api_key']) ? $_POST['dsq_user_api_key'] : null;

// Get installation step process (or 0 if we're already installed).
$step = @intval($_GET['step']);
if ($step > 1 && $step != 3 && $dsq_user_api_key) $step = 1;
elseif ($step == 2 && !isset($_POST['dsq_username'])) $step = 1;
$step = (dsq_is_installed()) ? 0 : ($step ? $step : 1);

// Handle installation process.
if ( 3 == $step && isset($_POST['dsq_forum']) && isset($_POST['dsq_user_api_key']) ) {
    list($dsq_forum_id, $dsq_forum_url) = explode(':', $_POST['dsq_forum']);
    update_option('disqus_forum_url', $dsq_forum_url);
    update_option('disqus_cc_fix', '1'); 
    $api_key = $dsq_api->get_forum_api_key($_POST['dsq_user_api_key'], $dsq_forum_id);
    if ( !$api_key || $api_key < 0 ) {
        update_option('disqus_replace', 'replace');
        dsq_manage_dialog(dsq_i('There was an error completing the installation of Disqus. If you are still having issues, refer to the <a href="https://help.disqus.com/customer/portal/articles/472005-wordpress-troubleshooting">WordPress help page</a>.'), true);
    } else {
        update_option('disqus_api_key', $api_key);
        update_option('disqus_user_api_key', $_POST['dsq_user_api_key']);
        update_option('disqus_replace', 'all');
        update_option('disqus_active', '1');
    }

    if (!empty($_POST['disqus_partner_key'])) {
        $partner_key = trim(stripslashes($_POST['disqus_partner_key']));
        if (!empty($partner_key)) {
            update_option('disqus_partner_key', $partner_key);
        }
    }
}

if ( 2 == $step && isset($_POST['dsq_username']) && isset($_POST['dsq_password']) ) {
    $dsq_user_api_key = $dsq_api->get_user_api_key($_POST['dsq_username'], $_POST['dsq_password']);
    if ( $dsq_user_api_key < 0 || !$dsq_user_api_key ) {
        $step = 1;
        dsq_manage_dialog($dsq_api->get_last_error(), true);
    }

    if ( $step == 2 ) {
        $dsq_sites = $dsq_api->get_forum_list($dsq_user_api_key);
        if ( $dsq_sites < 0 ) {
            $step = 1;
            dsq_manage_dialog($dsq_api->get_last_error(), true);
        } else if ( !$dsq_sites ) {
            $step = 1;
            dsq_manage_dialog(dsq_i('There aren\'t any sites associated with this account. Maybe you want to <a href="%s">create a site</a>?', 'https://disqus.com/admin/register/'), true);
        }
    }
}

$show_advanced = (isset($_GET['t']) && $_GET['t'] == 'adv');

?>
<div class="wrap" id="dsq-wrap">
    <h4 id="dsq-tabs" class="nav-tab-wrapper" style="clear:both; margin: 10px 0 0 0;">
	<ul>
        <li class="nav-tab nav-tab-active" id="dsq-tab-main" rel="dsq-main"><h3><?php echo (dsq_is_installed() ? dsq_i('Conditional Load') : dsq_i('Install')); ?></h3></li>
        <li class="nav-tab" id="dsq-tab-advanced" rel="dsq-advanced"><h3><?php echo dsq_i('Disqus Settings'); ?></h3></li>
		</ul>
    </h4>	
	
    <div id="dsq-main" class="dsq-content">
    <?php
switch ( $step ) {
case 3:
?>
		<div class="wrap" style="padding-top: 1.5cm;">
        <div id="dsq-step-3" class="dsq-main"<?php if ($show_advanced) echo ' style="display:none;"'; ?>>
            <h2><?php echo dsq_i('Install Disqus Conditional Load'); ?></h2>

            <p><?php echo dsq_i('Disqus has been installed on your blog.'); ?></p>
            <p><?php echo dsq_i('If you have existing comments, you may wish to <a href="?page=disqus&amp;t=adv#export">export them</a> now. Otherwise, you\'re all set, and the Disqus network is now powering comments on your blog.'); ?></p>
            <p><a href="edit-comments.php?page=disqus"><?php echo dsq_i('Continue to the moderation dashboard'); ?></a></p>
        </div>
		</div>
<?php
    break;
case 2:
?>
		<div class="wrap" style="padding-top: 1.5cm;">
        <div id="dsq-step-2" class="dsq-main"<?php if ($show_advanced) echo ' style="display:none;"'; ?>>
            <h2><?php echo dsq_i('Install Disqus Conditional Load'); ?></h2>

            <form method="POST" action="?page=disqus&amp;step=3">
            <?php wp_nonce_field('dsq-wpnonce_install', 'dsq-form_nonce_install'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row" valign="top"><?php echo dsq_i('Select a website'); ?></th>
                    <td>
<?php
foreach ( $dsq_sites as $counter => $dsq_site ):
?>
                        <input name="dsq_forum" type="radio" id="dsq-site-<?php echo $counter; ?>" value="<?php echo $dsq_site->id; ?>:<?php echo $dsq_site->shortname; ?>" />
                        <label for="dsq-site-<?php echo $counter; ?>"><strong><?php echo htmlspecialchars($dsq_site->name); ?></strong> (<u><?php echo $dsq_site->shortname; ?>.disqus.com</u>)</label>
                        <br />
<?php
endforeach;
?>
                        <hr />
                        <a href="<?php echo DISQUS_URL; ?>comments/register/"><?php echo dsq_i('Or register a new one on the Disqus website.'); ?></a>
                    </td>
                </tr>
            </table>

            <p class="submit" style="text-align: left">
                <input type="hidden" name="dsq_user_api_key" value="<?php echo htmlspecialchars($dsq_user_api_key); ?>"/>
                <input name="submit" type="submit" value="Next &raquo;" />
            </p>
            </form>
        </div>
		</div>
<?php
    break;
case 1:
?>
		<div class="wrap" style="padding-top: 1.5cm;">
        <div id="dsq-step-1" class="dsq-main"<?php if ($show_advanced) echo ' style="display:none;"'; ?>>
            <h2><?php echo dsq_i('Install Disqus Conditional Load'); ?></h2>

            <form method="POST" action="?page=disqus&amp;step=2">
            <?php wp_nonce_field('dsq-wpnonce_install', 'dsq-form_nonce_install'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row" valign="top"><?php echo dsq_i('Username or email'); ?></th>
                    <td>
                        <input id="dsq-username" name="dsq_username" tabindex="1" type="text" />
                        <a href="https://disqus.com/profile/signup/"><?php echo dsq_i('(don\'t have a Disqus Profile yet?)'); ?></a>
                    </td>
                </tr>
                <tr>
                    <th scope="row" valign="top"><?php echo dsq_i('Password'); ?></th>
                    <td>
                        <input type="password" id="dsq-password" name="dsq_password" tabindex="2">
                        <a href="https://disqus.com/forgot/"><?php echo dsq_i('(forgot your password?)'); ?></a>
                    </td>
                </tr>
            </table>

            <p class="submit" style="text-align: left">
                <input name="submit" type="submit" value="Next &raquo;" tabindex="3">
            </p>

            <script type="text/javascript"> document.getElementById('dsq-username').focus(); </script>
            </form>
        </div></div>
<?php
    break;
case 0:
    $base = is_ssl() ? 'https://' : 'http://';
    $url = get_option('disqus_forum_url');
    if ($url) { $mod_url = $base.$url.'.'.DISQUS_DOMAIN.'/admin/moderate/'; }
    else { $mod_url = DISQUS_URL.'admin/moderate/'; }
include_once('js-admin.php');
?>       
<?php } ?>

<?php
    $dsq_replace = get_option('disqus_replace');
    $dsq_forum_url = strtolower(get_option('disqus_forum_url'));
    $dsq_api_key = get_option('disqus_api_key');
    $dsq_user_api_key = get_option('disqus_user_api_key');
    $dsq_partner_key = get_option('disqus_partner_key');
    $dsq_cc_fix = get_option('disqus_cc_fix');
    $dsq_manual_sync = get_option('disqus_manual_sync');
    $dsq_disable_ssr = get_option('disqus_disable_ssr');
    $dsq_public_key = get_option('disqus_public_key');
    $dsq_secret_key = get_option('disqus_secret_key');
    $dsq_sso_button = get_option('disqus_sso_button');
?>
    <!-- Settings -->
<?php include_once('js-advanced.php'); ?>
</div>
<script type="text/javascript">
jQuery('#dsq-tab-main').click(function() {
jQuery("#dsq-tab-advanced").removeClass("nav-tab-active");
jQuery("#dsq-tab-main").removeClass().addClass( "nav-tab nav-tab-active" );
});

jQuery('#dsq-tab-advanced').click(function() {
jQuery("#dsq-tab-main").removeClass("nav-tab-active");
jQuery("#dsq-tab-advanced").addClass( "nav-tab nav-tab-active" );
});
</script>