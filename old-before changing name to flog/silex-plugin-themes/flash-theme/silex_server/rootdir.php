<?php
	define( 'ROOTPATH', dirname(__FILE__) . "/");

	if (!isset($ROOTURL))
	{
		// compute url base
		$scriptUrl=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		// supress the get arguments of the querry
		$qmPos=strpos($scriptUrl,'?');
		if ($qmPos > 0) $scriptUrl = substr($scriptUrl,0,$qmPos);
		
		$lastSlashPos=strrpos($scriptUrl,'/');
		$ROOTURL = 'http://'.substr($scriptUrl,0,$lastSlashPos+1);
	}
?>