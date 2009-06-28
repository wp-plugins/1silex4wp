FLASH<br><br><br>
<?php
/**
 * @package WordPress
 * @subpackage Flash_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
</head>
<body>
<?php

function getPostListByType($type){

	$query = new WP_Query('post_type='.$type.'&posts_per_page=-1');
	echo "getPostListByType ($type)<br><br>";
	$array = Array();
	// the Loop
	while ($query->have_posts()){
		$query->the_post(); 
		$array[]=$post->post_title;
		echo "-".$post->post_title."<br>";
	}
	return $array;
}
/*
	$queryType = "post";
	$flashTheme = new FlashTheme($queryType);
	
	$list_pages = 
	$list_authors = 
	$list_categories
	$list_bookmarks = 
	$get_archives = 
	$page_menu = 
	
	$flashTheme->writeHtml($list_pages, $list_authors , $list_categories, $list_bookmarks , $get_archives , $page_menu);
*/
/*

query_posts('post_type=page&posts_per_page=-1');
      
// the Loop
while (have_posts()) : the_post(); 
  //the_content('Read the full post »'); 
  echo "[open:start/page/";
  //the_title();
  echo $post->post_title;
  echo "]<br>";
endwhile;
*/
getPostListByType("page");
getPostListByType("post");
?>

<noscript>
<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
<!-- end header -->
<?php 
echo "<!-- pages<br>";
wp_list_pages();
echo "<!-- authors --><br>";
wp_list_authors(); 
echo "<!-- categories --><br>";
wp_list_categories(); 
echo "<!-- bookmarks --><br>";
wp_list_bookmarks(); 
echo "<!-- archives --><br>";
wp_get_archives(); 
echo "<!-- menu --><br>";
wp_page_menu(); 
?> 
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_date('','<h2>','</h2>'); ?>
<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<?php the_category(',') ?>
<?php the_tags(__('Tags: '), ', ', ' &#8212; '); ?>
<?php the_author() ?> @ <?php the_time() ?>
<?php the_content(__('(more...)')); ?>
<?php wp_link_pages(); ?>

<?php comments_number(); 
comments_template("./comments.php") ; ?> 


<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</noscript>

</body>
</html>