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

// **
// includes
set_include_path(get_include_path() . PATH_SEPARATOR . "../../");
include_once 'cgi/includes/silex_search.php';
include_once 'cgi/includes/server_config.php';
require_once("cgi/includes/logger.php");
require_once("cgi/includes/file_system_tools.php");


// create search object
$silex_search_obj=new silex_search();

$server_config = new server_config(); 
$fst = new file_system_tools();
$logger = new logger("feed");
// **
// inputs
// id_site
if (isset($_GET["id_site"]))
	$id_site=$_GET["id_site"];
else
	$id_site=$server_config->silex_server_ini["DEFAULT_WEBSITE"];

// maximum number of results
if (isset($_GET["limit"]))
	$limit=(int)($_GET["limit"]);
else
	$limit=0;

// default operator (and / or)
if (isset($_GET["operator"])){
	switch(strtolower($_GET["operator"])){
		case "or":
			$operator=Zend_Search_Lucene_Search_QueryParser::B_OR;
			break;
		case "and":
			$operator=Zend_Search_Lucene_Search_QueryParser::B_AND;
			break;
		default:
			$operator=Zend_Search_Lucene_Search_QueryParser::B_OR;
	}
}
else
	$operator=Zend_Search_Lucene_Search_QueryParser::B_OR;

Zend_Search_Lucene_Search_QueryParser::setDefaultOperator($operator);

// build website contentent folder
$websiteContentFolder="../../".$server_config->silex_server_ini["CONTENT_FOLDER"].$id_site."/";
// check rights
if ($fst->checkRights($fst->sanitize($websiteContentFolder),constant("file_system_tools::USER_ROLE"),constant("file_system_tools::READ_ACTION"))){

	if (isset($_GET["allow_duplicate"]) && $_GET["allow_duplicate"]=="true")
		$allow_duplicate=true;
	else
		$allow_duplicate=false;

	// get query
	$query=stripslashes(strip_tags(urldecode($_GET['query'])));

	// compute url base
	$scriptUrl=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$lastSlashPos=strrpos($scriptUrl,$server_config->silex_server_ini["CGI_SCRIPTS_FOLDER"]."feed.php");
	$urlBase="http://".substr($scriptUrl,0,$lastSlashPos).$id_site."/";

	// **
	// search
	$res=$silex_search_obj->find($websiteContentFolder."/",$query,$limit);
}
else{
	$logger->emerg("feed.php no rights to read $websiteContentFolder");
	echo "feed.php no rights to read $websiteContentFolder";
	exit(0);
}

//**
// echo rss
header('Content-Type: text/xml; charset=UTF-8');
$indexFolder=$server_config->silex_server_ini["CONTENT_FOLDER"].$id_site."/search_index/";
if (is_dir($indexFolder))
	$pubDate=date ("r",filemtime($indexFolder));
else
	$pubDate=date ("r");
echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
		<title>'.count($res).' results for '.$query.' in '.$id_site.'</title>
		<link>'.$urlBase.'</link>
		<pubDate>'.$pubDate.'</pubDate>
		<generator>http://www.silex-ria.org</generator>
		<keywords>'.$query.'</keywords>';
echo $silex_search_obj->arrayToRssItems($res,$allow_duplicate,$urlBase,$pubDate);
echo '	</channel>
</rss>';
?>

