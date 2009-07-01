<?php
/**
 * @package WordPress
 * @subpackage Flash_Theme
 */
include (ABSPATH.'wp-content/plugins/1silex4wp/includes/constants.php');
//require_once (SILEX_INCLUDE_DIR.'/flash_theme.php');

set_include_path(get_include_path() . PATH_SEPARATOR . SILEX_SERVER_DIR);
set_include_path(get_include_path() . PATH_SEPARATOR . SILEX_SERVER_DIR."/cgi/library/");
require_once SILEX_SERVER_DIR.'/rootdir.php';
include_once SILEX_SERVER_DIR.'/cgi/includes/server_config.php';
include_once SILEX_SERVER_DIR.'/cgi/includes/site_editor.php';
include_once SILEX_SERVER_DIR.'/cgi/includes/server_content.php';

$serverConfig = new server_config(); 
$serverContent = new server_content();
$siteEditor = new site_editor();

// **
// inputs
// PASS POST AND GET DATA TO FLASH and JS
$js_str='';
$str='';
while( list($k, $v) = each($_GET) ){$str.="fo.addVariable('".$k."', '".$v."');"; $js_str.="$".$k." = '".$v."'; ";}
while( list($k, $v) = each($_POST) ){$str.="fo.addVariable('".$k."', '".$v."');"; $js_str.="$".$k." = '".$v."'; ";}

// retrieve id_site from POST or GET
if (isset($_POST["id_site"]))
	$id_site=$_POST["id_site"];
else
	if (isset($_GET["id_site"]))
		$id_site=$_GET["id_site"];
	else
	{
//		$isDefaultWebsite = true;
		$id_site=$serverConfig->silex_server_ini["DEFAULT_WEBSITE"];
	}

// **
// retrieve website config data
$websiteConfig = $siteEditor->getWebsiteConfig($id_site);
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
	<script type="text/javascript" src="<?php echo "wp-content/themes/flash_theme/silex_server/".$serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo "wp-content/themes/flash_theme/silex_server/".$serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>jsframe.min.js"></script>
	<script type="text/javascript" src="<?php echo "wp-content/themes/flash_theme/silex_server/".$serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>swfobject.min.js"></script>
	<script type="text/javascript" src="<?php echo "wp-content/themes/flash_theme/silex_server/".$serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>deeplink.min.js"></script>
	<script type="text/javascript" src="<?php echo "wp-content/themes/flash_theme/silex_server/".$serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>wmodepatch.min.js"></script>
</head>
<?php

/*
$type="page";
query_posts('post_type='.$type.'&posts_per_page=-1');
while (have_posts()){
	the_post(); 
	echo "[open:start/page/";
	echo $post->post_title;
	echo "]<br>";
}
*/
/*$list_pages = Array();
$list_authors = Array();
$list_categories = Array();
$list_bookmarks = Array();
$get_archives = Array();
$page_menu = Array();

/**
 * used to build the FlashVars
 */
function getPostListByType($type){

	$array = Array();
	$query = new WP_Query('post_type='.$type.'&posts_per_page=-1');
	echo "getPostListByType ($type)<br><br>";
	// the Loop
	while ($query->have_posts()){
		$query->the_post(); 
		$array[]=$post->post_title;
		echo "-".$post->post_title."<br>";
	}
	return $array;
}


//echo count(getPostListByType("page"))."<br>";
//$array = getPostListByType("post");
// echo $array[0]."--";
// foreach($array as $val)
// 	echo $val.".";

?>
<body style="padding:0px;height:100%; margin-top:0; margin-left:0; margin-bottom:0; margin-right:0;" onload="setTimeout(function(){initWModePatch('silex');}, 500 );">
	<div style="position: absolute; z-index: 1000;" id="frameContainer"></div>
	<div id="flashcontent" align="center" style="position: absolute; z-index: 0; width: 100%; height: 100%;">
	</div>
		<iframe style="display:none" id="downloadFrame" name="downloadFrame"></iframe>
		<?php if(isset($websiteConfig["googleAnaliticsAccountNumber"]) && $websiteConfig["googleAnaliticsAccountNumber"]!="") { ?>
		<div id="googleAnalFrame"></div>
		<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
		<?php } ?>
		<iframe style="display:none" id="downloadFrame" name="downloadFrame"></iframe>
		<?php if(isset($websiteConfig["googleAnaliticsAccountNumber"]) && $websiteConfig["googleAnaliticsAccountNumber"]!="") { ?>
		<div id="googleAnalFrame"></div>
		<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
		<?php } ?>
		<div id="stats"></div>
<!-- ----------------------------------------------------------------------------------------------------- -->
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

<?php 
// build FlashVars
include_once SILEX_INCLUDE_DIR.'/build_flashvars.php';
?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</noscript>
<!-- ----------------------------------------------------------------------------------------------------- -->

<!-- ----------------------------------------------------------------------------------------------------- -->
	<script type="text/javascript" src="<?php echo "wp-content/themes/flash_theme/silex_server/".$serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>silex.min.js"></script>
	<script type="text/javascript">
		$rootUrl = "<?php echo SILEX_SERVER_URL.'/'; ?>";
		$flashVars = "<?php echo $flashVars; ?>";
	
		$enableDeeplinking = "<?php if(isset($websiteConfig["ENABLE_DEEPLINKING"])) echo $websiteConfig["ENABLE_DEEPLINKING"]; else echo "true"; ?>";
		$DEFAULT_WEBSITE="<?php echo $serverConfig->silex_server_ini["DEFAULT_WEBSITE"]; ?>";
		$php_id_site="<?php echo $id_site; ?>";
		$php_website_conf_file="<?php echo $serverConfig->silex_server_ini["CONTENT_FOLDER"].$id_site."/".$serverConfig->silex_server_ini["WEBSITE_CONF_FILE"]; ?>";

		$SILEX_CLIENT_CONF_FILES_LIST=$php_website_conf_file + "," + "<?php echo $serverConfig->silex_server_ini["SILEX_CLIENT_CONF_FILES_LIST"]; ?>";
		$flashPlayerVersion="<?php if(isset($websiteConfig["flashPlayerVersion"])) echo $websiteConfig["flashPlayerVersion"]; else echo "7"; ?>";
		$CONFIG_START_SECTION="<?php if(isset($websiteConfig["CONFIG_START_SECTION"])) echo $websiteConfig["CONFIG_START_SECTION"]; else echo "start"; ?>";
		$SILEX_ADMIN_AVAILABLE_LANGUAGES="<?php echo $serverContent->getLanguagesList(); ?>";
		$SILEX_ADMIN_DEFAULT_LANGUAGE="<?php echo $serverConfig->silex_server_ini["SILEX_ADMIN_DEFAULT_LANGUAGE"]; ?>";
		$htmlTitle="<?php echo $websiteTitle; ?>";
		//$preload_files_list="";
		$preload_files_list="<?php echo $websiteConfig["layoutFolderPath"].$websiteConfig["initialLayoutFile"].",fp".$websiteConfig["flashPlayerVersion"]."/".$websiteConfig["layerSkinUrl"]; 
		if (isset($websiteConfig["PRELOAD_FILES_LIST"]))
			echo ",".$websiteConfig["PRELOAD_FILES_LIST"];?>";
		$bgColor="#<?php echo $websiteConfig["bgColor"]; ?>";

		// pass post and get data to flash
		$php_str="<?php echo $str; ?>";

		// pass post and get data to js
		eval("<?php echo $js_str; ?>");

		// silexJsObj is used for deep link and tracking
		silexJsObj=SilexJsStart(
			$flashPlayerVersion,
			$DEFAULT_WEBSITE,
			$CONFIG_START_SECTION,
			$SILEX_CLIENT_CONF_FILES_LIST,
			$enableDeeplinking,
			$SILEX_ADMIN_DEFAULT_LANGUAGE,
			$SILEX_ADMIN_AVAILABLE_LANGUAGES,
			$htmlTitle,
			$preload_files_list,
			$bgColor,
			$php_str,
			$php_id_site,
			$flashVars,
			$rootUrl);
	</script> 
</body>
</html>