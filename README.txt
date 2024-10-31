=== Plugin Name ===
Contributors: steven_stern
Donate link: None
Tags: talkr, podcast
Requires at least: 2.0.2
Tested up to: 2.6.1
Stable tag: 2.1.4

This plugin adds a Talkr link to each post in your blog.  

== Description ==

Talkr converts the posts in your blog to MP3 files and syndicates them as a podcast. As a side effect of this,
you can add a link to each post that allows visitors of your site to listen to the post.

This plugin creates that link.  For a demo, vist http://sstern.ccim.com/ and
click on any of the "Listen to this post" links.

To use the Talkr plugin:

*   Register at http://www.talkr.com
*   Create a feed from your blog at http://www.talkr.com/app/partner_reg.app
*   Copy the feed ID 
*   On the OPTIONS page of the WordPress admin section, click on Talkr Plugin Options
*   Save the feed id.


== Installation ==


1. Upload `sds_talkr.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your feed ID through the 'Options' menu in Wordpresss

== Release Notes ==
2.1.4 fixed link to speaker icon
2.1.2 added speaker icon
2.1.1 remove link to talkr logo as they've removed it from thdir site.
2.0.0 added exclude from feed pages option
1.1.0 added attribute_escape function when accepting POST value on options page
1.0.1 corrected spelling error, shortened menu link on options page
1.0.0 added wpadmin interface, save feed ID in wp_options
0.0.3 added [] around permalink
0.0.2 fixed link so image is not underlined
0.0.1 initial release

== Arbitrary section ==

copyright (C) 2007-2008, Steven D. Stern
Some Rights Reserved.  This software is licensed under the CC-GNU LGPL
http://creativecommons.org/licenses/LGPL/2.1/
