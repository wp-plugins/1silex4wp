/*
	this file is part of SILEX
	SILEX : RIA developement tool - see http://silex.sourceforge.net/

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
/*
A FAIRE 
- pour flashvars dans autres browsers : MLAB_flash_setvariables.js

*/
// **
// fscommand
//
var isInternetExplorer = navigator.appName.indexOf("Microsoft") != -1;
// Handle all the FSCommand messages in a Flash movie.
function silex_DoFSCommand(command, args) {
	var silexObj = isInternetExplorer ? document.all.silex : document.silex;
	//alert("silex_DoFSCommand-"+command+"-"+args);
	if (command == "eval"){
		eval(unescape(args));
		//alert(unescape(args));
	}
}
// Hook for Internet Explorer.
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
	document.write('<script language=\"VBScript\"\>\n');
	document.write('On Error Resume Next\n');
	document.write('Sub silex_FSCommand(ByVal command, ByVal args)\n');
	document.write('	Call silex_DoFSCommand(command, args)\n');
	document.write('End Sub\n');
	document.write('</script\>\n');
}
function SilexJsStart($flash_version,$php_default_website_name,$start_section,$config_files_list,$ENABLE_DEEPLINKING,$SILEX_ADMIN_DEFAULT_LANGUAGE,$SILEX_ADMIN_AVAILABLE_LANGUAGES,$websiteTitle,$preload_files_list,$bgcolor,$php_str,$php_id_site,$flashVars,$rootUrl,$flashvarsObj, $parObj){
		
	if (!$bgcolor) $bgcolor="#FFFFFF";
	if (!$rootUrl) $rootUrl = "";
	if (!$flashvarsObj) $flashvarsObj = {};
	if (!$parObj) $parObj = {};

	// variables which may be overriden by $php_str
	$no_flash_page = "no-flash.html";

	// **
	// SWF Object
	//
//	var fo = new SWFObject("fp"+$flash_version+"/loader.swf", "silex", "100%", "100%", $flash_version.toString(), "#FFFFFF");
	var fo = new SWFObject($rootUrl+"loader.swf?flashId=silex", "silex", "100%", "100%", $flash_version.toString(), $bgcolor,"best",null,$no_flash_page);

	// retrieve commands passed from php
	eval($php_str);

	//$debug_str = "---\n";
	var $flashVars_array = $flashVars.split("&");
	for ($i = 0; $i < $flashVars_array.length; $i++)
	{
		var $flashVarPair_array = $flashVars_array[$i].split("=");
		$flashvarsObj[$flashVarPair_array[0]] = $flashVarPair_array[1];
		//$debug_str += $flashVarPair_array[0]+" , "+$flashVarPair_array[1]+"\n";
	}

	$parObj.id = "silex";
	$parObj.name = "silex";
	$parObj.flashId = "silex";
	
	// force these values
	$parObj.swLiveConnect = "true";
	$parObj.AllowScriptAccess,"always";
	$parObj.quality = "best";
	
/*	$parObj.forceScaleMode = "showAll";
	$parObj.scale = "noscale";

	// **
	// for frames
	$parObj.wmode = "transparent";
	// **

	$flashvarsObj.silex_result_str = "_no_value_";
	$flashvarsObj.silex_exec_str = "_no_value_";
	
	$flashvarsObj.flashPlayerVersion = $flash_version;
	
	$flashvarsObj.SILEX_ADMIN_DEFAULT_LANGUAGE = $SILEX_ADMIN_DEFAULT_LANGUAGE;
	$flashvarsObj.SILEX_ADMIN_AVAILABLE_LANGUAGES = $SILEX_ADMIN_AVAILABLE_LANGUAGES;

*/	
	if ($rootUrl != "")
	{
		$flashvarsObj.rootUrl = $rootUrl;
	}
	var $hash_value;
	if ($ENABLE_DEEPLINKING=="false")
	{
		$flashvarsObj.ENABLE_DEEPLINKING = "false";
//		$hash_value = $php_id_site;
	}
	else if ($ENABLE_DEEPLINKING=="true")
	{
		$flashvarsObj.ENABLE_DEEPLINKING = "true";
	}
	
	
	// **
	// silex js object
	//
	// silexJsObj is used for deep link and tracking
	silexJsObj=new cSilex;
	$currentHashValue = getUrlHash();	
	$id_site=silexJsObj.init($flashvarsObj,$php_default_website_name,$start_section,$websiteTitle,$hash_value);

	if ($id_site!=$php_id_site){
		//alert("case when you go directly to a website with # in the url - "+$id_site+"!=<?php echo $id_site; ?>");
		// case when you go directly to a website with # in the url
		//document.getElementById("theform").id_site=$id_site;
		//document.getElementById("theform").action="./#"+$id_site;
		//document.getElementById("theform").innerHtml='<FORM target="_self" action="./" method="post" id="theform"><INPUT type="hidden" name="id_site" value=$id_site></FORM>');
		document.write('<FORM target="_self" action="./#'+$id_site+'/'+$currentHashValue+'" method="post" id="theform" name="theform"><INPUT type="hidden" name="id_site" value="'+$id_site+'"></FORM>');
		document.getElementById("theform").submit();
	}
	else{
		$flashvarsObj.id_site = $id_site;
		//if ($config_files_list && $config_files_list!="")
			$flashvarsObj.config_files_list = $config_files_list;
		//alert($config_files_list);
		//fo.addVariable('preload_files_list', 	"./fonts/_sans.swf,./fonts/_serif.swf,./fonts/_typewriter.swf,./fonts/arial.swf,./fonts/arial_black.swf,./fonts/courier_new.swf,./fonts/impact.swf,./fonts/georgia.swf,./fonts/helvetica.swf,./fonts/tahoma.swf,./fonts/times_new_roman.swf,./fonts/verdana.swf");
		$flashvarsObj.preload_files_list = $preload_files_list;
		//fo.addVariable('preload_files_list', "./fonts/text.swf");
		document.bgColor = $bgcolor;
		//document.title = $websiteTitle;
		// Math.random() for IE bug
		//swfobject.embedSWF($rootUrl+"loader.swf?flashId=silex&rand="+Math.random(), "flashcontent", "100%", "100%", $flash_version.toString(), false, $flashvarsObj, $parObj, $parObj,function($e){if (!$e.success) window.location = "no-flash.html";});
		$flashvars_string = "";
		for ($i in $flashvarsObj)
		{
			// alert($i);
			if ($flashvars_string!="") $flashvars_string+="&";
			$flashvars_string += $i+"="+$flashvarsObj[$i];
		}
		fo.addVariable('flashVars', $flashvars_string);
		fo.addParam('flashVars', $flashvars_string);
		
		for ($i in $parObj)
		{
			// alert($i);
			//fo.addVariable($i, $parObj[$i]);
			fo.addParam($i, $parObj[$i]);
		}

		fo.write("flashcontent");
	}
	return silexJsObj;
}