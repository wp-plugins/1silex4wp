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
function do_template_redirect ($notused) {
	$silex_get_themeStr = silex_get_theme();
	if ($silex_get_themeStr!=""){
		include($silex_get_themeStr.'/index.php');
		exit;
	}
}
add_action('template_redirect', 'do_template_redirect');

/**
 * wpi_stylesheet_dir_uri
 * overwrite theme stylesheet directory uri
 * filter stylesheet_directory_uri
 * @see get_stylesheet_directory_uri()
 */
/**
function filter_stylesheet_directory_uri($stylesheet_dir_uri, $theme_name){
	$silex_get_themeStr = silex_get_theme();
	if ($silex_get_themeStr!="")
		return SILEX_PLUGIN_DIR."/".$silex_get_themeStr;
	return $stylesheet_dir_uri;
}
add_filter('stylesheet_directory_uri','filter_stylesheet_directory_uri',10,2);

function filter_template_directory_uri($template_dir_uri){
	$silex_get_themeStr = silex_get_theme();
	if ($silex_get_themeStr!="")
		return SILEX_PLUGIN_DIR."/".$silex_get_themeStr;
	return $template_dir_uri;
}
add_filter('template_directory_uri','filter_template_directory_uri');
 */


function silex_get_template($template) {
	$theme = silex_get_theme();
	if (!empty($theme)) {
		$theme = get_theme($theme);
		return $theme['Template'];;
	}
	return $template;
}

function silex_get_stylesheet($stylesheet) {
	$theme = silex_get_theme();
	if (!empty($theme)) {
		$theme = get_theme($theme);
		return $theme['Stylesheet'];
	}
	return $stylesheet;
}

add_filter('template', 'silex_get_template');
add_filter('stylesheet', 'silex_get_stylesheet');

?>
