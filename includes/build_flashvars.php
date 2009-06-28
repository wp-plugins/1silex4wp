<?php 

// build FlashVars
$flashVars='';

// POST INFO - see http://codex.wordpress.org/WPMU_Functions/get_blog_post
$flashVars.='post_guid='.urlencode($post->guid).'&';
$flashVars.='post_title='.urlencode($post->post_title).'&';
$flashVars.='post_name='.urlencode($post->post_name).'&';
$flashVars.='post_content='.urlencode($post->post_content).'&';
$flashVars.='post_excerpt='.urlencode($post->post_excerpt).'&';
$flashVars.='post_content_filtered='.urlencode($post->post_content_filtered).'&';
$flashVars.='post_type='.urlencode($post->post_type).'&';
$flashVars.='tags_input='.urlencode($post->tags_input).'&';
$flashVars.='post_status='.urlencode($post->post_status).'&';
$flashVars.='post_author='.urlencode($post->post_author).'&';
$flashVars.='post_parent='.urlencode($post->post_parent).'&';
$flashVars.='post_date='.urlencode($post->post_date).'&';
$flashVars.='post_date_gmt='.urlencode($post->post_date_gmt).'&';
$flashVars.='post_modified='.urlencode($post->post_modified).'&';
$flashVars.='post_modified_gmt='.urlencode($post->post_modified_gmt).'&';
$flashVars.='post_ping_status='.urlencode($post->ping_status).'&';
$flashVars.='post_to_ping='.urlencode($post->to_ping).'&';
$flashVars.='post_pinged='.urlencode($post->pinged).'&';
$flashVars.='post_menu_order='.urlencode($post->menu_order).'&';
$flashVars.='post_mime_type='.urlencode($post->post_mime_type).'&';
$flashVars.='post_comment_count='.urlencode($post->comment_count).'&';
// ! post_category is an ARRAY !
$flashVars.='post_category='.urlencode($post->post_category).'&';

// BLOG INFO - see http://codex.wordpress.org/Bloginfo#Parameters
$flashVars.='blog_admin_email='.urlencode(get_bloginfo('admin_email')).'&';
$flashVars.='blog_atom_url='.urlencode(get_bloginfo('atom_url')).'&';
$flashVars.='blog_charset='.urlencode(get_bloginfo('charset')).'&';
$flashVars.='blog_comments_atom_url='.urlencode(get_bloginfo('comments_atom_url')).'&';
$flashVars.='blog_comments_rss2_url='.urlencode(get_bloginfo('comments_rss2_url')).'&';
$flashVars.='blog_description='.urlencode(get_bloginfo('description')).'&';
$flashVars.='blog_home='.urlencode(get_bloginfo('home')).'&';
$flashVars.='blog_html_type='.urlencode(get_bloginfo('html_type')).'&';
$flashVars.='blog_language='.urlencode(get_bloginfo('language')).'&';
$flashVars.='blog_name='.urlencode(get_bloginfo('name')).'&';
$flashVars.='blog_pingback_url='.urlencode(get_bloginfo('pingback_url')).'&';
$flashVars.='blog_rdf_url='.urlencode(get_bloginfo('rdf_url')).'&';
$flashVars.='blog_rss2_url='.urlencode(get_bloginfo('rss2_url')).'&';
$flashVars.='blog_rss_url='.urlencode(get_bloginfo('rss_url')).'&';
$flashVars.='blog_siteurl='.urlencode(get_bloginfo('siteurl')).'&';
$flashVars.='blog_stylesheet_directory='.urlencode(get_bloginfo('stylesheet_directory')).'&';
$flashVars.='blog_stylesheet_url='.urlencode(get_bloginfo('stylesheet_url')).'&';
$flashVars.='blog_template_directory='.urlencode(get_bloginfo('template_directory')).'&';
$flashVars.='blog_template_url='.urlencode(get_bloginfo('template_url')).'&';
$flashVars.='blog_text_direction='.urlencode(get_bloginfo('text_direction')).'&';
$flashVars.='blog_url='.urlencode(get_bloginfo('url')).'&';
$flashVars.='blog_version='.urlencode(get_bloginfo('version')).'&';
$flashVars.='blog_wpurl='.urlencode(get_bloginfo('wpurl')).'&';

// USER INFO - see http://codex.wordpress.org/Function_Reference/wp_get_current_user
get_currentuserinfo();
$flashVars.='user_login='.urlencode($userdata->user_login).'&';
$flashVars.='user_level='.urlencode($userdata->user_level).'&';
$flashVars.='user_ID='.urlencode($userdata->user_ID).'&';
$flashVars.='user_email='.urlencode($userdata->user_url).'&';
$flashVars.='user_pass_md5='.urlencode($userdata->user_pass_md5).'&';
$flashVars.='user_display_name='.urlencode($userdata->display_name).'&';

// AUTHOR INFO - see http://codex.wordpress.org/Function_Reference/get_the_author
$author = get_the_author();
$flashVars.='author_url='.urlencode($author->user_url).'&';
$flashVars.='author_registered='.urlencode($author->user_registered).'&';
$flashVars.='author_status='.urlencode($author->user_status).'&';
$flashVars.='author_description='.urlencode($author->description).'&';
$flashVars.='author_nickname='.urlencode($author->nickname).'&';
$flashVars.='author_level='.urlencode($author->user_level).'&';
$flashVars.='author_ID='.urlencode($author->ID).'&';

?>