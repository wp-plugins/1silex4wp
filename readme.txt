=== 1silex4wp ===
Contributors: lexa
Tags: Flash, ActionScript, theme, template, front office, front end
Requires at least: 2.8.1
Tested up to: 2.8.1
Stable tag: 1.0alpha3

Convert your WordPress blog into a Flash application

== Description ==

**Substitute your worpress theme by a Flash template**

* visible only by Flash enabled browsers - *search engines or portable phones will see your blog theme*
* keeps the *posts and comments* of your WP blog unchanged. The database is not modified at all. Keeps comments related functionnalities.
* keeps *the structure of your WP blog*: posts, categories, tags, pages, archives, start page...
* use WP URL rewrite and adds a *deep linking system*
* choose one of the *included Flash templates*
* create your own dynamic Flash templates with *Silex WYSIWYG*

**Notes**

* Currently in alpha version - Work is in progress, v1.0beta1 is comming in July *
* For now, look at [the screenshots of the prototypes](http://wordpress.org/extend/plugins/1silex4wp/screenshots/ "screenshots")
* [Work in progress can be seen here](http://hoyau.info/demo/1silex4wp/ "Work in progress can be seen here")

**Description**

1silex4wp is SEO friendly and makes use of [Silex the #1 opensource Flash CMS](http://silex-ria.org/ "Silex project website"), to build dynamic Flash templates without the Flash IDE. These templates can display your blog data, the posts, pages and comments. And you will be able to modify the appearance in [Silex WYSIWYG](http://www.youtube.com/watch?v=rzFqfuiLQ4k&hl=fr "Silex WYSIWYG video demo").

[Sha](http://silex-ria.org/sha "Sha cv") has allready done [a website with Silex driven by WordPress](http://flashcms.fr/ "flashcms, a Silex-WP site (in French)"). And [here is a video of an other test I did](http://www.screentoaster.com/watch/stUkxdQ0VLR15cR19dU1le "Silex Wordpress video")). These prototypes are not SEO friendly and a classical WordPress blog could not be converted easily. 

Now I want 1silex4wp to let Silex themes be Flash equivalents of WordPress themes.
 
== Installation ==

Upload the 1silex4wp plugin to your blog, Activate it, choose your Flash template. You are done, Your blog is in Flash

Requirements

* php5
* WP 2.x

== Screenshots ==

1. silex WYSIWYG used to make Flash templates without the Flash IDE
2. One of the Silex templates for WordPress

== Changelog ==

= 1.0 =
* Plugin core: 
	* installation
	* settings
	* substitution of the themes
	* auto-configured Silex server
	* FlashVars
	* url rewrite
	* javascript communication between Silex and wordpress

= 0.0 =
* Still in a conception phase - Nothing to download yet
* Specifications
* Description and communication elements



== Help wanted ==

I am looking for people who could do video tutorials and templates. Feel free to mail me (lex [at] silex-ria [dot] org)

== To Do - v1.0 alpha ==
* list of templates instead of text field
* archive list feed
* produce a prototype template 
=> Release  v1 in alpha

== To do - Tests ==
* different url rewrite schemes
* on portable devices
* on a browser without flash or / nor javascript
* security tests
	* user data exposed through rss feeds

== bugs ==
*     cat and s tags
*     refresh after comment submited
*     $no_flash_page / no-flash.html
*		feed catégories
*		content:encoded s'affiche mal avec le customfeed
*	_root.display_name is set even when not logged in

== To Do - v1.0 beta ==
* make the "post comment" work (refresh the comments list?)
* ? remove silex files needed only for editing 
* ? add an option to link to an online silex installation? <-> http://wordpress.org/extend/plugins/piwik-analytics/
* paged comments feed and paged comments in "single" and "page" pages
* implement all the parameters of the query: http://codex.wordpress.org/Template_Tags/query_posts 
* all language constants passed in FlashVars (404 text, link names, ...)
* produce 1 silex template
=> Release  v1 in beta

== To do - Tests ==
* compatibility with other plugins
	* MobilePress
	* private blog
* compatibility with the themes
== To Do - v1.0 ==
* x	use the content:encoded in a frame and the comments rss feed for the comments
* x	a frame to add a comment?
* silex installer / or let silex go with php4 + pass.php file
* comments in wrong order
* add no-flash page param to silex.js
* detect when flash_theme or framed_theme is missing
* add a version control and update
* add tests "if_exist" for all hooks (wp versions)
* produce several silex templates
=> Release  v1

== To do - Tests ==
* compatibility with WordPress versions
	* did not work on 2.6.3

== To Do - v1.1 ==
* add more info in Flashvars : http://codex.wordpress.org/Function_Reference
* better deeplinks - override cSilex::changeSection
	store the displayed section
	GetVariable => data about the post, page or section which is displayed
	wp getOption => URL rewrite rule of WP
	setUrlHash in fucntion of these data
	
* better deeplinks - override cSilex::urlHashChanged
	take data from php websiteConfig: URL rewrite rule of the Silex website
	SetVariable of the section data (id and or title of the page/post)
	call silex open command to the right section

