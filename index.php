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
/*
Plugin Name: 1silex4wp
Plugin URI: http://wordpress.org/extend/plugins/1silex4wp/
Description: 1silex4wp
Author: Lexa Yo
Version: 0.1
Author URI: http://silex-ria.org/lex
*/

include('includes/constants.php');
include(SILEX_INCLUDE_DIR."/rss_functions.php");

/**
 * determine the name of the theme to display
 * the user theme, the flash_theme or the framed_theme
 */
function silex_get_theme(){
	global $wp_query;
	if (isset( $_GET["is_framed"] )){
		return 'framed_theme';
	}
	else if (!isset( $_GET["no_flash"] )){
		return 'flash_theme';
	}
	return '';
}
/*
 * force the theme to the appropriate theme template
 */
function silex_get_template($template) {
	$theme = silex_get_theme();
	if (!empty($theme)) {
		$theme = get_theme($theme);
		return $theme['Template'];;
	}
	return $template;
}
add_filter('template', 'silex_get_template');

/*
 * force the theme to the appropriate theme css
 */
function silex_get_stylesheet($stylesheet) {
	$theme = silex_get_theme();
	if (!empty($theme)) {
		$theme = get_theme($theme);
		return $theme['Stylesheet'];
	}
	return $stylesheet;
}
add_filter('stylesheet', 'silex_get_stylesheet');

/**
 * make the feeds available with url rewrite
 */
function silex_rewrite_rules( $wp_rewrite ) {
  $new_rules = array(
    'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
  );
  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
/**
 * declare the feeds for listing of the categories, tags, ...
 */
function silex_add_feeds() {
  global $wp_rewrite;
  // add feeds
  add_feed('silex_categories_feed', 'silex_create_categories_feed');
  add_feed('silex_tags_feed', 'silex_create_tags_feed');

  // add rewrite rule action
  add_action('generate_rewrite_rules', 'silex_rewrite_rules');
  $wp_rewrite->flush_rules();
}
add_action('init', 'silex_add_feeds');

?>
