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
/**
 * compute the redirect url
 */
function get_redirect_url($homeDeeplink,$singleDeeplink,$pageDeeplink,$archiveDeeplink,$searchDeeplink,$error404Deeplink){
	global $query_string;
	
	if (isset($query_string) && $query_string != ''){
		global $websiteConfig;
		$redirect_url = get_option( 'siteurl' ).'/#'.get_option('silex_selected_template').'/'.$websiteConfig['CONFIG_START_SECTION'].'/';
		if(is_home()){
			$redirect_url = get_option( 'siteurl' );
		}
		else if(is_single()){
			$redirect_url .= $singleDeeplink;
			global $post;
			$redirect_url = str_replace('%',$post->ID,$redirect_url);
		}
		else if(is_page()){
			global $page;
			$redirect_url .= $pageDeeplink;
			$redirect_url = str_replace('%',$page->ID,$redirect_url);
		}
		else if(is_search()){
			$redirect_url .= $searchDeeplink;
			$redirect_url = str_replace('%',$query_string,$redirect_url);
		}
		else if(is_archive()){
			$redirect_url .= $archiveDeeplink;
			$redirect_url = str_replace('%',$query_string,$redirect_url);
			// is_tag() is_category() is_year() is_month() is_day() is_time() 
		}
		else if(is_404()){
			$redirect_url .= $error404Deeplink;
		}
		return $redirect_url;
	}
	return null;
}
?>