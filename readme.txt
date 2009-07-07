=== 1silex4wp ===
Contributors: lexa
Tags: Flash, ActionScript, theme, template, front office, front end
Requires at least: 2.0.2
Tested up to: 0.0
Stable tag: 0.0

Convert your WordPress blog into a Flash application

== Description ==

*Still in a conception phase - Work in progress, v0.1 is comming in July - For now, look at [the screenshots of the prototypes](http://wordpress.org/extend/plugins/1silex4wp/screenshots/ "screenshots")*

**Substitute your worpress theme by a Flash template**

* visible only by Flash enabled browsers - *search engines or phones will see your blog normally*
* keeps the *posts and comments* of your WP blog unchanged. The database is not modified at all. Keeps comments related functionnalities.
* keeps *the structure of your WP blog*: posts, categories, tags, pages, archives, start page...
* use WP URL rewrite and adds a *deep linking system*
* choose one of the *included Flash templates*
* create your own dynamic Flash templates with *Silex WYSIWYG*

This plug-in is SEO friendly and makes use of [Silex the #1 opensource Flash CMS](http://silex-ria.org/ "Silex project website"), to build dynamic Flash templates without the Flash IDE. These templates can display your blog data, the posts, pages and comments. And you will be able to modify the appearance in [Silex WYSIWYG](http://www.youtube.com/watch?v=rzFqfuiLQ4k&hl=fr "Silex WYSIWYG video demo").

[Sha](http://silex-ria.org/sha "Sha cv") has allready done [a website with Silex driven by WordPress](http://flashcms.fr/ "flashcms, a Silex-WP site (in French)"). And [here is a video of an other test I did](http://www.screentoaster.com/watch/stUkxdQ0VLR15cR19dU1le "Silex Wordpress video")). These prototypes are not SEO friendly and a classical WordPress blog could not be converted easily. 

Now I want this plugin to make Silex a Flash equivalent of a WordPress blog.
 
== Installation ==

Upload the 1silex4wp plugin to your blog, Activate it, choose your Flash template. You are done, Your blog is in Flash

Requirements

* php5
* WP 2.x

== Screenshots ==

1. silex WYSIWYG used to make Flash templates without the Flash IDE
2. One of the Silex templates for WordPress

== Changelog ==

= 0.1 =
* Plugin core: 
	installation
	settings
	substitution of the themes
	auto-configured Silex server
	FlashVars
	url rewrite
	javascript communication between Silex and wordpress

= 0.0 =
* Still in a conception phase - Nothing to download yet
* Specifications
* Description and communication elements



== Help wanted ==

I am looking for people who could do video tutorials and templates. Feel free to mail me (lex [at] silex-ria [dot] org)

== To Do ==
x* add in FlashVars: get_bookmarks, get_tags, get_pages, get_categories - see http://codex.wordpress.org/Function_Reference
x* rss feeds
x* Install
x    Copie
x* admin pannel
x    Url rewrite silex
x    Override url rewrite wp?
x* Fonctions js 
    convertDeepLink : wp <-> silex
x    openSilexPage : commande
* override cSilex::changeSection
	store the displayed section
	GetVariable => data about the post, page or section which is displayed
	wp getOption => URL rewrite rule of WP
	setUrlHash in fucntion of these data
	
* override cSilex::urlHashChanged
	take data from php websiteConfig: URL rewrite rule of the Silex website
	SetVariable of the section data (id and or title of the page/post)
	call silex open command to the right section
	
* override 	cSilex::getIdFromHash and cSilex::setUrlHash
	wp getOption gives the template
	id_site is allways the chosen template
-* Liens reecrits avec appel js
* Reecriture url initiale (juste url base) et deeplink initial
* make the plugin link to an online silex installation? <-> http://wordpress.org/extend/plugins/piwik-analytics/
* templates silex
	use the content:encoded in a frame and the comments rss feed for the comments
	a frame to add a comment?

* add no-flash page param to silex.js
* detect when flash_theme or framed_theme is missing
* add a version control and update
no* remove silex files needed only for editing 
* add tests "if_exist" for all hooks (wp versions)
* add more info in Flashvars : http://codex.wordpress.org/Function_Reference

* security tests
	* blog_public option