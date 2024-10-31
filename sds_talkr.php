<?php
// This software is licensed under the CC-GNU LGPL.
// http://creativecommons.org/licenses/LGPL/2.1/
// Copyright 2007-2008, Steven D. Stern
// Some Rights Reserved

/*
Plugin Name: sds_Talkr_Plugin 
Plugin URI: http://sstern.ccim.com/category/talkr/
Description: Adds a talkr link to a post.  Be sure to add your feed ID through the admin menu.  Go to http://www.talkr.com to sign up.
Version: 2.1.4
Author: Steven Stern
Author URI: http://sstern.ccim.com
*/

// Version 0.0.1 initial release
// Version 0.0.2 fixed link so image is not underlined
// Version 0.0.3 added [] around permalink
// Version 1.0.0 added wpadmin interface, save feed ID in wp_options
// Version 1.0.1 corrected spelling error, shortened menu link on options page
// Version 1.1.0 added attribute_escape function when accepting POST value on options page
// Version 2.0.0 added exclude from feed pages option
// Version 2.1.0 added exclude from pages, post
// Version 2.1.1 removed talkr logo -- no longer on their site
// Version 2.1.2 added speaker icon
// Version 2.1.3 documentation change - no code changes
// Version 2.1.4 fixed link to speaker icon
define('the_key','sds_Talkr_Feed_ID');
define('Option_Feed_Exclusion','sds_Talkr_Feed_Exclusion');
define('Option_Page_Exclusion','sds_Talkr_Page__Exclusion');
define('Option_Post_Exclusion','sds_Talkr_Post_Exclusion');

add_option(the_key, "0", 'Your TALKR feed ID.');
add_option(Option_Feed_Exclusion,"0","Exclude Talkr from feed pages if true");
add_option(Option_Page_Exclusion,"0","Exclude Talkr from pages if true");
add_option(Option_Post_Exclusion,"0","Exclude Talkr from posts if true");


// if option has a value, fetch it. Otherwise, use 0.
$talkr_feed_id=get_option(the_key);

// Create a option page for settings
add_action('admin_menu','add_sds_Talkr_admin_page');

// hook the talkr plugin into each page and post
add_filter('the_content','sds_Talkr');

function sds_Talkr($parm) {
  global $post;
  global $talkr_feed_id;
  
  if ($talkr_feed_id==0) {
  	return $parm;
  }
  
// if this page is a feed and the feed exclusion is in effect, bail out

  if (is_feed() && get_option(Option_Feed_Exclusion) <> 0)
     return $parm;

// if this page is a page and the page exclusion is in effect, bail out
  if (is_page() && get_option(Option_Page_Exclusion) <> 0)
     return $parm;

// if this page is a post and the post exclusion is in effect, bail out
// if we get this far, it must be a post
  if ( (!is_feed() && !is_page()) && get_option(Option_Post_Exclusion) <> 0)
     return $parm;

  $this_post= get_permalink($post->ID);
  
$img="<img style=\"border:none;\" src='/wp-content/plugins/sds-talkr/speaker-icon.gif' alt='Listen to this post' border='0' />";

  $link="<a href='http://www.talkr.com/app/fetch.app?feed_id=".$talkr_feed_id."&perma_link=[".$this_post."]'>";
  $my_content.=$link.$img."</a> ".$link."Listen to this post</a>";
  return $parm.$my_content;
}


// Hook in the options page function
function add_sds_Talkr_admin_page() {
	global $wpdb;
	add_options_page('Talkr Plugin Options', 'Talkr', 8, basename(__FILE__), 'sds_Talkr_options_page');
}

function sds_Talkr_options_page() {
	 global $talkr_feed_id;
	 $saved=false;
	 
	// If we are a postback, store the options
 	if (isset($_POST[the_key])) {
		check_admin_referer();
		
		// Update the status
		$talkr_feed_id = attribute_escape($_POST[the_key]);
		update_option(the_key, $talkr_feed_id);
		if (isset($_POST[Option_Feed_Exclusion])) 
		   update_option(Option_Feed_Exclusion,"-1");
		  else
		   update_option(Option_Feed_Exclusion,"0");
                if (isset($_POST[Option_Post_Exclusion]))
                   update_option(Option_Post_Exclusion,"-1");
                  else
                   update_option(Option_Post_Exclusion,"0");
                 if (isset($_POST[Option_Page_Exclusion]))
                   update_option(Option_Page_Exclusion,"-1");
                  else
                   update_option(Option_Page_Exclusion,"0");
	$saved=true;
	}
	  // create the page
?>	  
   
    <?
    if ($saved)   // Give an updated message
		echo "<div class='updated'><p><strong>Talkr options updated</strong></p></div>";
		?>
		
	  <form method="post" action="options-general.php?page=sds_talkr.php">
		<div class="wrap">
			<h2>Talkr Options</h2>
				Feed ID:&nbsp;
<?

							echo "<input type='text' size='10' ";
							echo "name=".the_key." ";
							echo "id=".the_key." ";
							echo "value='".$talkr_feed_id."' />\n";
						
?>
     If this is zero, the Talkr plugin is disabled.
     <p>Get a Talkr Feed ID at <a href="http://www.talkr.com/app/my_feeds.app",target=_blank>http://www.talkr.com/app/my_feeds.app</a>.
     <p>
     	Exclude Talkr link from feeds:&nbsp;
   <?
              $talkr_Feed_Exclusion=get_option(Option_Feed_Exclusion);
							echo "<input type='checkbox' ";
							echo "name=".Option_Feed_Exclusion." ";
							echo "id=".Option_Feed_Exclusion." ";
							if ($talkr_Feed_Exclusion==0) 
							  echo "";
							 else
							  echo " checked ";
							echo " />\n";
						
?>  	
    <br />
 Exclude Talkr link from pages:&nbsp;
   <?
              $talkr_Page_Exclusion=get_option(Option_Page_Exclusion);
                                                        echo "<input type='checkbox' ";
                                                        echo "name=".Option_Page_Exclusion." ";
                                                        echo "id=".Option_Page_Exclusion." ";
                                                        if ($talkr_Page_Exclusion==0)
                                                          echo "";
                                                         else
                                                          echo " checked ";
                                                        echo " />\n";

?>
    <br />
 Exclude Talkr link from posts:&nbsp;
   <?
              $talkr_Post_Exclusion=get_option(Option_Post_Exclusion);
                                                        echo "<input type='checkbox' ";
                                                        echo "name=".Option_Post_Exclusion." ";
                                                        echo "id=".Option_Post_Exclusion." ";
                                                        if ($talkr_Post_Exclusion==0)
                                                          echo "";
                                                         else
                                                          echo " checked ";
                                                        echo " />\n";

?>
    </p>
     	<p class="submit">
			<input type='submit' name='save' value='Save' /></p>
	   </form>
 </div>
<?

	}


?>
