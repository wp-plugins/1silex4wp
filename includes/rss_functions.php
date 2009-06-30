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
			echo "		<".$key.">".$val."</".$key.">\n";
		}
?>
	</item>
<?php
		
	}
	include(SILEX_FEED_THEME_DIR."/footer.php");
}
?>