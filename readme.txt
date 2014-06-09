=== Disqus Conditional Load ===
Contributors: joelcj91
Tags: disqus, disqus conditional load, comment hide, hide disqus, disqus comments, disqus on click, disqus auto load
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Disable Disqus comment auto load in posts and pages. This plug-in will create a button and Disqus will be loaded only when user clicks on button.

== Description ==

If you are using Disqus commenting system in your blog or website you might have noticed that your pages loading slowly. This is because Disqus will load it's scripts unnecessarily on all pages and posts. By using this plug-in you will be able to load Disqus comments only when needed.
That means only when users clicks on a button which says something like "Load Comments" Disqus comments will be loaded. If users do not want to see comments it will not be loaded. This plug-in will increase page speed.


== Installation ==

1. Upload `Disqus Conditional Load` plug-in zip file to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You will see a maenu "JS Settings" in admin menu. Click on it
4. Choose whether to load comments on Button Click or Scrolling
5. Give your disqus username for the website (Please ensure you are giving correct username, unless it may not load proper comments)
6. Save it by clicking on "Update Settingd".
3. Ensure that you have not enabled comments while creating posts and pages. If you enable Disqus may load automatically.

Note : Inorder to this plug-in work Disqus comments should be activated and comments should be disabled in posts and pages.

== Frequently Asked Questions ==

= What is the use of Disqus Conditional Load? =

To disable Disqus comments auto load on all pages and posts.

= Will this plug-in create any effects in page speed? =

Yes. It will stop auto loading of Disqus scripts. So your page will be loaded more quickly.

== Changelog ==

= 1.0.0 =
* Added first version without admin menu

= 2.0.0 =
* Added admin menu
* Added two methods (onclick and onscroll)
* User can change settings from admin page.

== Upgrade Notice ==

= 2.0.0 =
This version included admin menu so that users can change settings without affecting your theme.
This version added one method in that users can choose whether to load comments on button click or scrolling.
