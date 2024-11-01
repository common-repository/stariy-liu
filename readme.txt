=== WP share SNS ===

Contributors: Stariy Liu
Author info: major of computer science and technolgy, ZheJiang University, China
Author link: http://stariy.info/
Tags: share, SNS, wp-share-SNS, blog, wordpress, stariy
Requires at least: 3.0.1
Tested up to: 3.0.1
Latest version: 1.0.0
Stable tag: trunk: 1.0.0
Beta tag: 1.0.0 

== Description ==

This plugin use javascript mainly to open the SNS share page to share the current page to the SNS.
The most sns in China is default chosen, twitter and facebook is for your interest.

You can modify the following options:

--(wp-share-SNS.php)
 * Specify function defaultOptions(), the child array can be modified.
 	* c : default choose if 1
 	* site : the sns website name
 	* width : the share page is coming with this width
 	* height : the share page is coming with this height
 * Specify all CSS, what you like is ok

--(wp-share-SNS.js)	
 * Specify function shareToSNS(), you can modify the url sns for some; Note %20 is for the blank for browser
 	* twitter : just keep the format[ http://twitter.com/home?status=? ], then you can write anything to replace the ?
 	

== Installation ==

1. Download.
2. Using the uploading function in admin plugin panel or upload to your `/wp-contents/plugins/` directory by manual.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Enter the plugin main page from 'Share to SNS' item from the setting.
5. Choose your favourite SNS to share your blog.

== Frequently Asked Questions ==

== Screenshots ==

1. Screenshot of admin plugin page.
2. Screenshot of single page.

== Changelog ==
