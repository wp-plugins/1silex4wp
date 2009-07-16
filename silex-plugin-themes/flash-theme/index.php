<?php
/*  Copyright 2009  Alexandre Hoyau  (email : lex [at] silex-ria . org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * @package 1silex4wp
 * @author Lexa Yo
 * @version 0.1
 */
require_once(ABSPATH."wp-content/plugins/".get_option('silex_plugin_name').'/includes/constants.php');
set_include_path(get_include_path() . PATH_SEPARATOR . "./SILEX_SERVER_DIR");

//define( 'ROOT_URL' , SILEX_SERVER_URL . '/');

?>
<?php
/**
 * Silex hook for head tag
 */
function head_hook(){
?>
<script type="text/javascript">
		$rootUrl = "<?php echo SILEX_SERVER_URL.'/'; ?>";
		// build FlashVars
		<?php include_once SILEX_INCLUDE_DIR.'/build_flashvars.php'; 
			$flashVars['rootUrl']=SILEX_SERVER_URL.'/';
		?>
		$flashVars = "<?php echo $flashVars; ?>";
		$DEFAULT_WEBSITE="<?php echo get_option('selected_template')?>";
// to do :
//		$htmlTitle
</script>

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
	wp_get_archives('type=monthly&format=link');
	wp_head();
	return true;
}
?>

<?php
/**
 * Silex hook for noscript tag
 */
function noembed_hook(){
?>
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

if (have_posts()) : while (have_posts()) : the_post(); 
	the_date('','<h2>','</h2>'); ?>
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
<?php 
	return true;
}
?>



<?php
/**
 * Silex hook for the script tag
 */
function script_hook(){
?>
<script type="text/javascript">
		//trace("script_hook "+openSilexPage);
		$postDeeplink = "single/p=%/";
		$pageDeeplink = "page/p=%/"; // "page/page_id=";
		function openPost($postID){
			document.getElementById('silex').SetVariable('silex_exec_str','DataContainer.post.ID='+$postID);
			openSilexPage("<?php global $websiteConfig; echo $websiteConfig["CONFIG_START_SECTION"]; ?>/"+$postDeeplink+$postID);
		}
		/**
		 * retrieve the id from a deep link pattern
		 */
		function getParamFromDeeplinkPattern($hashValue,$deeplinkPattern){
			// return value
			$id = -1;
			
			$_array = $deeplinkPattern.split("%");
			
			// check that the before part is there
			$patternWithIdSite = "<?php global $websiteConfig; echo $websiteConfig["CONFIG_START_SECTION"]; ?>/"+$_array[0];
			trace("-> pattern = "+$patternWithIdSite+" , hashValue = "+$hashValue+" , index = " + $hashValue.indexOf($patternWithIdSite));
			//trace($patternWithIdSite,$hashValue.indexOf($patternWithIdSite));
			if ($hashValue.indexOf($patternWithIdSite) === 0){
				// 1st part of the pattrern matches the deeplink
				// check the 2nd part of the patern if there is one
				$afterIdPatternIndex = $hashValue.indexOf($_array[1],$patternWithIdSite.length);
				trace("-> index1 = "+$patternWithIdSite.length+" , index2 = "+$afterIdPatternIndex+", hashValue = "+$hashValue);
				if ($_array.length<2 || $afterIdPatternIndex >= 0){
					// extract the id
					if ($afterIdPatternIndex < 0) //$afterIdPatternIndex = 0;
						$id = $hashValue.substring($patternWithIdSite.length);
					else
						$id = $hashValue.substring($patternWithIdSite.length,$afterIdPatternIndex);
					trace("YESSSSSSSSSSSSSSS "+$patternWithIdSite.length+","+$afterIdPatternIndex+" => "+$id);
				}
			}
			return $id;
		}
		/**
		 * override silex hash change callback to set the post or page id / the search or archive params
		 */
		function openSilexPage($hashValue)
		{
			// update the section data in silex
			setFlashVarsForSilexPage($hashValue);
			// open the page in Silex
			document.getElementById('silex').SetVariable('silex_exec_str','open:'+$hashValue);
			return true;
		}
		/**
		 * set the post or page id / the search or archive params
		 */
		function setFlashVarsForSilexPage($hashValue)
		{
			trace("setFlashVarsForSilexPage - open "+$hashValue);
			// set the id of the single post or page in DataContainer.post.ID
			// post
			$id = getParamFromDeeplinkPattern($hashValue,$postDeeplink);
			if ($id==-1){
				// page
				$id = getParamFromDeeplinkPattern($hashValue,$pageDeeplink);
			}
			if ($id>-1){
				trace("setFlashVarsForSilexPage - SetVariable('silex_exec_str','DataContainer.post.ID='"+$id+")");
				// set the id of the single post or page in DataContainer.post.ID
				$silex_object_tmp = document.getElementById('silex');
				if ($silex_object_tmp) $silex_object_tmp.SetVariable('silex_exec_str','DataContainer.post.ID='+$id);
			}
			return $id;
		}
		$id = setFlashVarsForSilexPage(getUrlHash());
		$additional_flashvars += "&post_ID="+$id+"&";
		trace("script hool over - "+$id+" flashvars = "+$additional_flashvars);
</script>
<?php
	return true;
}
?>

<?php
global $silex_hooks_array;
if (!isset($silex_hooks_array)) $silex_hooks_array = Array();
$silex_hooks_array[] = Array('hook_name' => 'index-head', 'hook_function' => head_hook, 'params' => Array());
$silex_hooks_array[] = Array('hook_name' => 'noembed', 'hook_function' => noembed_hook, 'params' => Array());
$silex_hooks_array[] = Array('hook_name' => 'script', 'hook_function' => script_hook, 'params' => Array());

include (SILEX_SERVER_DIR.'/index.php');
?>
