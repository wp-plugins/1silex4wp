<?php 
/**
 * returns the rss feed listing of categories
 * 
 * <title>Uncategorized</title>
 * <link>http://localhost/_opensource/1silex4wp/wordpress/?feed=rss2&amp;cat=1</link>
 * <!-- <pubDate></pubDate>
 * <dc:creator></dc:creator> -->

 * <term_id>1</term_id>
 * <name>Uncategorized</name>
 * <slug>uncategorized</slug>
 * <term_group>0</term_group>
 * <term_taxonomy_id>1</term_taxonomy_id>
 * <taxonomy>category</taxonomy>

 * <description></description>
 * <parent>0</parent>
 * <count>3</count>
 * <object_id>1</object_id>
 * <cat_ID>1</cat_ID>
 * <category_count>3</category_count>

 * <category_description></category_description>
 * <cat_name>Uncategorized</cat_name>
 * <category_nicename>uncategorized</category_nicename>
 * <category_parent>0</category_parent>
 */
function silex_create_categories_feed($not_used){
	$feed_name = "Categories list";
	include(SILEX_FEED_THEME_DIR."/header.php");
	$categories = get_categories("hide_empty=0");
	foreach ($categories as $cat) {	
		// retrieve category data
		$data_object = get_category($cat->cat_ID,OBJECT);
//		<!-- <pubDate></pubDate>
//		<dc:creator></dc:creator> -->
?>

	<item>
		<title><?php echo $data_object->name ?></title>
		<link><?php echo get_category_feed_link($data_object->cat_ID,"rss2"); ?></link>
<?php
		foreach($data_object as $key => $val){
			if(strpos($key,'password')===FALSE)
				echo "		<".$key.">".$val."</".$key.">\n";
		}
?>
	</item>
<?php
		
	}
	include(SILEX_FEED_THEME_DIR."/footer.php");
}

/**
 * returns the rss feed listing of tags
 *
 * <item>
 * 	<title>d</title>
 * 	<link>http://localhost/_opensource/1silex4wp/wordpress/?tag=d</link>
 * 
 * 	<term_id>8</term_id>
 * 	<name>d</name>
 * 	<slug>d</slug>
 * 	<term_group>0</term_group>
 * 	<term_taxonomy_id>8</term_taxonomy_id>
 * 	<taxonomy>post_tag</taxonomy>
 * 
 * 	<description></description>
 * 	<parent>0</parent>
 * 	<count>2</count>
 * </item>
 *
 */
function silex_create_tags_feed($not_used){
	$feed_name = "Tags list";
	include(SILEX_FEED_THEME_DIR."/header.php");
	$tags = get_tags("hide_empty=0");
	foreach ($tags as $tag) {	
		// retrieve category data
		$data_object = get_tag($tag,OBJECT);
//		<!-- <pubDate></pubDate>
//		<dc:creator></dc:creator> -->
?>

	<item>
		<title><?php echo $data_object->name ?></title>
		<link><?php echo get_tag_link($data_object->term_id); ?></link>
<?php
		foreach($data_object as $key => $val){
			if(strpos($key,'password')===FALSE)
				echo "		<".$key.">".$val."</".$key.">\n";
		}
?>
	</item>
<?php
		
	}
	include(SILEX_FEED_THEME_DIR."/footer.php");
}
/**
 * returns the rss feed listing of pages
 *
 * <item>
 * 	<title>about</title>
 * 	<link>http://localhost/_opensource/1silex4wp/wordpress/?page_id=2</link>
 * 	<ID>2</ID>
 * 
 * 	<post_author>1</post_author>
 * 	<post_date>2009-06-26 21:23:07</post_date>
 * 	<post_date_gmt>2009-06-26 19:23:07</post_date_gmt>
 * 	<post_content>This is an example of a WordPress page, you could edit this to put information about yourself or your site so readers know where you are coming from. You can create as many pages like this one or sub-pages as you like and manage all of your content inside of WordPress.</post_content>
 * 	<post_title>About</post_title>
 * 	<post_excerpt></post_excerpt>
 * 
 * 	<post_status>publish</post_status>
 * 	<comment_status>open</comment_status>
 * 	<ping_status>open</ping_status>
 * 	<post_password></post_password>
 * 	<post_name>about</post_name>
 * 	<to_ping></to_ping>
 * 	<pinged></pinged>
 * 
 * 	<post_modified>2009-06-26 21:23:07</post_modified>
 * 	<post_modified_gmt>2009-06-26 19:23:07</post_modified_gmt>
 * 	<post_content_filtered></post_content_filtered>
 * 	<post_parent>0</post_parent>
 * 	<guid>http://localhost/_opensource/1silex4wp/wordpress/?page_id=2</guid>
 * 	<menu_order>0</menu_order>
 * 
 * 	<post_type>page</post_type>
 * 	<post_mime_type></post_mime_type>
 * 	<comment_count>0</comment_count>
 * 	<ancestors>Array</ancestors>
 * 	<filter>raw</filter>
 * </item>
 */
function silex_create_pages_feed($not_used){
	$feed_name = "pages list";
	include(SILEX_FEED_THEME_DIR."/header.php");
	$pages = get_pages("hierarchical =0");
	foreach ($pages as $page) {	
		// retrieve category data
		$data_object = get_page($page,OBJECT);
//		<!-- <pubDate></pubDate>
//		<dc:creator></dc:creator> -->
?>

	<item>
		<title><?php echo $data_object->post_title ?></title>
		<link><?php echo get_page_link($data_object->ID); ?></link>
		<description><?php echo $data_object->post_content; ?></description>
<?php
		foreach($data_object as $key => $val){
			if(strpos($key,'password')===FALSE)
				echo "		<".$key.">".$val."</".$key.">\n";
		}
?>
	</item>
<?php
		
	}
	include(SILEX_FEED_THEME_DIR."/footer.php");
}
/**
 * returns the rss feed listing of bookmark
 *
 */
function silex_create_bookmarks_feed($not_used){
	$feed_name = "bookmarks list";
	include(SILEX_FEED_THEME_DIR."/header.php");
	$bookmarks = get_bookmarks();
	foreach ($bookmarks as $bookmark) {	
		// retrieve category data
		$data_object = get_bookmark($bookmark,OBJECT);
//		<!-- <pubDate></pubDate>
//		<dc:creator></dc:creator> -->
?>

	<item>
		<title><?php echo $data_object->link_name ?></title>
		<link><?php echo $data_object->link_url; ?></link>
		<description><?php echo $data_object->link_description; ?></description>
<?php
		foreach($data_object as $key => $val){
			if(strpos($key,'password')===FALSE)
				echo "		<".$key.">".$val."</".$key.">\n";
		}
?>
	</item>
<?php
		
	}
	include(SILEX_FEED_THEME_DIR."/footer.php");
}
/**
 * returns the rss feed listing of posts
 *
 */
function silex_create_posts_feed($not_used){
	$feed_name = "posts list";
	include(SILEX_FEED_THEME_DIR."/header.php");
	$posts = get_posts();
//	foreach ($posts as $post) {	
	while( have_posts()) : the_post();
		// retrieve category data
		$data_object = get_post($post,OBJECT);
//		<!-- <pubDate></pubDate>
//		<dc:creator></dc:creator> -->
?>
	<item>
		<title><?php echo $data_object->post_title ?></title>
		<description><?php echo $data_object->post_excerpt; ?></description>
<?php
		foreach($data_object as $key => $val){
			if(strpos($key,'password')===FALSE)
				echo "		<".$key.">".$val."</".$key.">\n";
		}
?>
		<link><?php the_permalink_rss() ?></link>
		<comments><?php comments_link(); ?></comments>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<dc:creator><?php the_author() ?></dc:creator>
		<?php the_category_rss() ?>

		<guid isPermaLink="false"><?php the_guid(); ?></guid>
	<?php if ( strlen( $post->post_content ) > 0 ) : ?>
		<content:encoded><![CDATA[<?php the_content() ?>]]></content:encoded>
	<?php else : ?>
		<content:encoded><![CDATA[<?php the_excerpt_rss() ?>]]></content:encoded>
	<?php endif; ?>
		<wfw:commentRss><?php echo get_post_comments_feed_link(); ?></wfw:commentRss>
		<slash:comments><?php echo get_comments_number(); ?></slash:comments>
<?php rss_enclosure(); ?>
	<?php do_action('rss2_item'); ?>
	</item>
	<?php endwhile; ?>
<?php
		
	include(SILEX_FEED_THEME_DIR."/footer.php");
}
?>