<?php
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

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
 * @version 0.0
 */
/*
Plugin Name: 1silex4wp
Plugin URI: http://wordpress.org/extend/plugins/1silex4wp/
Description: 1silex4wp
Author: Lexa Yo
Version: 0.0
Author URI: http://silex-ria.org/lex
*/
function headerLex($result='',$show='')
{
/*
	YES :
	global $wp_query;
	$postId = $wp_query->post->ID;
	echo "header Lex ".$postId;
	*/
/*	
	YES
	global $post;
	echo "header Lex ".$post->ID." - ".is_single();
	*/
	if(is_single())
	{
		echo "<noscript>";
	}
}
function footerLex()
{
/*	
	YES
	global $wp_query;
	$postId = $wp_query->post->ID;
	echo "footer Lex ".$postId;
	*/
	if(is_single())
	{
		echo "</noscript>";
	}
}
//add_action('get_posts', 'headerLex',2,1);
//add_action('wp_footer', 'footerLex',20,0);
add_action('loop_start', 'headerLex',2,1);
add_action('loop_end', 'footerLex',20,0);
?>
