<?php
/*
	this file is part of SILEX
	SILEX : RIA developement tool - see http://silex-ria.org/

	SILEX is (c) 2004-2007 Alexandre Hoyau and is released under the GPL License:

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License (GPL)
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	To read the license please visit http://www.gnu.org/copyleft/gpl.html
*/
// php 5 needed
/*
if (version_compare(PHP_VERSION,'5','<')){
	echo "your php version is too old for SILEX. You need php 5 or older. Your php version is ".PHP_VERSION.". Check <a href='install'>SILEX install here</a> and <a href='http://silex-ria.org/help/documentation/installation/'>the install section of the documentation here</a>";
	exit(0);
}
*/
//check if installer ran. We should use the password_manager class with isAuthenticationFileAvailable, but since this is the main page keep it light
if(!file_exists("./conf/pass.php")){
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Silex</title>
<meta http-equiv="REFRESH" content="0;url=./install"></HEAD>
</HTML>
	
	<?php
	exit(0);
}

// **
// includes
set_include_path(get_include_path() . PATH_SEPARATOR . "./");
set_include_path(get_include_path() . PATH_SEPARATOR . "./cgi/library/");
require_once('rootdir.php');
include_once 'cgi/includes/server_config.php';
include_once 'cgi/includes/site_editor.php';
include_once 'cgi/includes/server_content.php';
require_once("cgi/includes/logger.php");
require_once("cgi/includes/file_system_tools.php");
require_once("cgi/includes/site_editor.php");

$serverConfig = new server_config(); 
//$serverContent = new server_content();
$siteEditor = new site_editor();
$fst = new file_system_tools();
$logger = new logger("main silex index");

// **
// inputs
// PASS POST AND GET DATA TO FLASH and JS
$js_str='';
$str='';
while( list($k, $v) = each($_GET) ){$str.="fo.addVariable('".$k."', '".$v."');"; $js_str.="$".$k." = '".$v."'; ";}
while( list($k, $v) = each($_POST) ){$str.="fo.addVariable('".$k."', '".$v."');"; $js_str.="$".$k." = '".$v."'; ";}
//echo "........................".$js_str;
//echo "<br>........................".$str;

// $isDefaultWebsite is true if there was no id_site in get or post data. UNUSED?
//$isDefaultWebsite = false;

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

// redirect to 404 website
if (!$websiteConfig)
{
	$id_site = $serverConfig->silex_server_ini["DEFAULT_ERROR_WEBSITE"];
	//$websiteConfig=$siteEditor->getWebsiteConfig($id_site);
	
/*	$scriptUrl=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$lastSlashPos=strrpos($scriptUrl,"widget.php");
	$newUrl = "http://".substr($scriptUrl,0,$lastSlashPos).$id_site;
*/	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location:#".$id_site); 
	header("Connection: close"); 
	exit;
	
	// $websiteConfig["ENABLE_DEEPLINKING"] = "false";
	// $str.="fo.addVariable('id_site', '".$id_site."');"; $js_str.="$"."id_site"." = '".$id_site."'; ";
}

// title
$websiteTitle=$websiteConfig["htmlTitle"];

// icon
//$favicon="media/silex.ico";
$favicon="";
if (isset($websiteConfig["htmlIcon"]) && $websiteConfig["htmlIcon"]!="")
	$favicon='<link rel="shortcut icon" href="'.$websiteConfig["htmlIcon"].'"><link rel="icon" href="'.$websiteConfig["htmlIcon"].'">';

// main rss feed
//$mainRssFeed="cgi/scripts/feed.php?id_site=".$id_site;
$mainRssFeed="";
if (isset($websiteConfig["mainRssFeed"]) && $websiteConfig["mainRssFeed"]!="")
	$mainRssFeed='<link rel="alternate" type="application/rss+xml" title="RSS" href="'.$websiteConfig["mainRssFeed"].'">';

// htmlKeywords
$websiteKeywords=$websiteConfig["htmlKeywords"];

// get the HTML KEYWORDS, TITLE, ...
//echo "getSectionSeoData($id_site,".$websiteConfig["CONFIG_START_SECTION"].")";
$seoDataHomePage = $siteEditor->getSectionSeoData($id_site, $websiteConfig["CONFIG_START_SECTION"]);

// html and SEO init
$htmlTitle=($seoDataHomePage["title"]);
$htmlKeywords="<h4>Website keywords</h4><p><br>".($seoDataHomePage["description"])."</p>";

// add a link to the home page
$htmlLinks="<h1>navigation</h1><h4><a href='".$id_site."/".$websiteConfig["CONFIG_START_SECTION"]."'>Home page: ".($seoDataHomePage["title"])."</a></h4>";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html style="height:100%;margin:0px;padding:0px;">
	<head>
		<meta http-equiv="cache-control" content="must-revalidate, pre-check=0, post-check=0, max-age=0">
		<meta http-equiv="Last-Modified" content="<?php echo gmdate('D, d M Y H:i:s').' GMT'; ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<?php echo $mainRssFeed; ?>
		<?php echo $favicon; ?>
		<title><?php echo $websiteTitle; ?></title>

		<script type="text/javascript" src="<?php echo $serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>jsframe.min.js"></script>
		<script type="text/javascript" src="<?php echo $serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>swfobject.min.js"></script>
		<script type="text/javascript" src="<?php echo $serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>deeplink.min.js"></script>
		<script type="text/javascript" src="<?php echo $serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>wmodepatch.min.js"></script>
	</head>
	<body style="padding:0px;height:100%; margin-top:0; margin-left:0; margin-bottom:0; margin-right:0;" onload="setTimeout(function(){initWModePatch('silex');}, 500 );">
		<div style="position: absolute; z-index: 1000;" id="frameContainer"></div>
		<div id="flashcontent" align="center" style="position: absolute; z-index: 0; width: 100%; height: 100%;">
		      <noscript>

		      <?php

		            $param = Array(
                        "movie" => "./loader.swf?flashId=silex",
                        "src" => "./loader.swf?flashId=silex",
                        "type"=>"application/x-shockwave-flash",
                        "bgColor" => $websiteConfig["bgColor"],
                        "pluginspage"=>"http://www.adobe.com/products/flashplayer/",
                        "codebase" => "http://www.adobe.com/products/flashplayer/",
                        "FlashVars" => ""
                    );

                    $flashVars = Array(
                        "ENABLE_DEEPLINKING" => "false",
                        "DEFAULT_WEBSITE" => $serverConfig->silex_server_ini["DEFAULT_WEBSITE"],
                        "id_site" => "$id_site",
                        "php_website_config_file" => $serverConfig->silex_server_ini["CONTENT_FOLDER"].$id_site."/".$serverConfig->silex_server_ini["WEBSITE_CONF_FILE"],
                        "config_files_list" => $serverConfig->silex_server_ini["CONTENT_FOLDER"].$id_site."/".$serverConfig->silex_server_ini["WEBSITE_CONF_FILE"] . "," . $serverConfig->silex_server_ini["SILEX_CLIENT_CONF_FILES_LIST"],
                        "flashPlayerVersion" => isset($websiteConfig["flashPlayerVersion"]) ? $websiteConfig["flashPlayerVersion"] : "7",
                        "CONFIG_START_SECTION" => isset($websiteConfig["CONFIG_START_SECTION"]) ? $websiteConfig["CONFIG_START_SECTION"] : "start",
                        "SILEX_ADMIN_AVAILABLE_LANGUAGES" => ""/*$serverContent->getLanguagesList()*/,
                        "SILEX_ADMIN_DEFAULT_LANGUAGE" => $serverConfig->silex_server_ini["SILEX_ADMIN_DEFAULT_LANGUAGE"],
                        "htmlTitle" => "$websiteTitle",
                        "preload_files_list" => $websiteConfig["layoutFolderPath"].$websiteConfig["initialLayoutFile"].",fp".$websiteConfig["flashPlayerVersion"]."/".$websiteConfig["layerSkinUrl"],
                        "forceScaleMode" => "showAll",
                        "scale" => "noscale",
                        "swLiveConnect" => "true",
                        "AllowScriptAccess" => "always",
                        "quality" => "best",
                        "wmode" => "transparent",
                        "silex_result_str" => "_no_value_",
                        "silex_exec_str" => "_no_value_"
                    );
					if (isset($websiteConfig["PRELOAD_FILES_LIST"]))
						$flashVars["preload_files_list"] .= ",".$websiteConfig["PRELOAD_FILES_LIST"];

                    $fV_String="";
                    foreach( $flashVars as $key => $var ){
                        $param['FlashVars'] .= $key . "=" . $var;
                        $param['FlashVars'] .= sizeof( $fV_String ) > 0 ? "&" : "";
                    }

                echo '<object id="silex"  classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%"  height="100%" standby="Loading... Please wait.">';

                    foreach( $param as $key => $var ){
                        if($key != "src" && $key != "pluginspage")
                            echo "\n                <param name=\"$key\" value=\"$var\">";
                        if($key != "movie" && $key != "codebase")
                            $Param_String .= " " . $key . "=\"$var\"";
                    }


                ?>
                <embed height="100%" width="100%"<?php echo $Param_String;?>>
                </embed>
                <noembed>
                <iframe frameborder="0" height="100%" width="100%" src="./no-flash.html">Your browser doesnt support Frames. Update your browser to watch this page.</iframe>
				<a href="http://silex-ria.org">powered by silex</a>
				<br><a href="http://silexlabs.com">released by the Silex team</a>
                <?php echo "".$htmlLinks."<p><br>website keywords <br></p>".$websiteKeywords."<p><br>page keywords <br></p>".$htmlKeywords."<p><br></p>"; ?>
                </noembed>

          </object>
		</noscript>
		</div>
		<iframe style="display:none" id="downloadFrame" name="downloadFrame"></iframe>
		<?php if(isset($websiteConfig["googleAnaliticsAccountNumber"]) && $websiteConfig["googleAnaliticsAccountNumber"]!="") { ?>
		<div id="googleAnalFrame"></div>
		<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
		<?php } ?>
		<div id="stats"></div>
		<script type="text/javascript" src="<?php echo $serverConfig->silex_server_ini["JAVASCRIPT_FOLDER"]; ?>silex.min.js"></script>
		<script type="text/javascript">
			$enableDeeplinking = "<?php if(isset($websiteConfig["ENABLE_DEEPLINKING"])) echo $websiteConfig["ENABLE_DEEPLINKING"]; else echo "true"; ?>";
			$DEFAULT_WEBSITE="<?php echo $serverConfig->silex_server_ini["DEFAULT_WEBSITE"]; ?>";
			$php_id_site="<?php echo $id_site; ?>";
			$php_website_conf_file="<?php echo $serverConfig->silex_server_ini["CONTENT_FOLDER"].$id_site."/".$serverConfig->silex_server_ini["WEBSITE_CONF_FILE"]; ?>";

			$SILEX_CLIENT_CONF_FILES_LIST=$php_website_conf_file + "," + "<?php echo $serverConfig->silex_server_ini["SILEX_CLIENT_CONF_FILES_LIST"]; ?>";
			$flashPlayerVersion="<?php if(isset($websiteConfig["flashPlayerVersion"])) echo $websiteConfig["flashPlayerVersion"]; else echo "7"; ?>";
			$CONFIG_START_SECTION="<?php if(isset($websiteConfig["CONFIG_START_SECTION"])) echo $websiteConfig["CONFIG_START_SECTION"]; else echo "start"; ?>";
			$SILEX_ADMIN_AVAILABLE_LANGUAGES="<?php echo "";//$serverContent->getLanguagesList(); ?>";
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
                "");
		</script>
	</body>
</html>