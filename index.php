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
function newThemeFolder(){
	global $wp_query;
	if (isset( $_GET["is_framed"] )){
		return 'framedTheme';
	}
	else if (!isset( $_GET["no_flash"] )){
		return 'flashTheme';
	}
	return '';
}
function do_template_redirect ($notused) {
	$newThemeFolderStr = newThemeFolder();
	if ($newThemeFolderStr!=""){
		include($newThemeFolderStr.'/index.php');
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
function filter_stylesheet_directory_uri($stylesheet_dir_uri, $theme_name){
	$newThemeFolderStr = newThemeFolder();
	if ($newThemeFolderStr!="")
		return SILEX_PLUGIN_DIR."/".$newThemeFolderStr;
	return $stylesheet_dir_uri;
}
add_filter('stylesheet_directory_uri','filter_stylesheet_directory_uri',10,2);

/**
 */
function filter_template_directory_uri($template_dir_uri){
	$newThemeFolderStr = newThemeFolder();
	if ($newThemeFolderStr!="")
		return SILEX_PLUGIN_DIR."/".$newThemeFolderStr;
	return $template_dir_uri;
}
add_filter('template_directory_uri','filter_template_directory_uri');
?>
