<?php
	// pass all $_GET variables to Flash
	$str=''; while( list($k, $v) = each($_GET) ){$str.="fo.addVariable('".$k."', '".$v."');";}
?>
<html>
	<head>
		  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		  <META HTTP-EQUIV="Expires" CONTENT="-1">
		<meta http-equiv="cache-control" content="must-revalidate, pre-check=0, post-check=0, max-age=0" />
		<meta http-equiv="Last-Modified" content="<?php echo gmdate('D, d M Y H:i:s').' GMT'; ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>SILEX LIBRARY IMPORT</title>
		<script type="text/javascript" src="swfobject.js"></script>
	</head>
	<body>
	<div id="flashcontent" align="center">
	<br>
	<hr width="100%">
	<br>
	<H2>
		Votre version de Flash Player est trop ancienne pour afficher ce site.
	</H2>
		<br><br>
	<H4>
		Veuillez cliquer sur l&#39;image ci-dessous, cette opération est gratuite et rapide.
	</H4>
	<br><br>
	<a href="http://www.macromedia.com/go/getflashplayer">
		<img src="alternate.gif">
	</a>
	<br><br>
		Your version of Flash Player is too old to display the website you requested.
		<br><br>
		To install the required version, please click on image above.
	<br><br>
	<hr width="100%">
	<br><br>
	<div align="right">
		<a href="http://www.silex.tv">
			<img src="logosilex.jpg" width="32" height="32">
			powered by SILEX
		</a>
	</div>
		<script type="text/javascript">
			var fo = new SWFObject("FtpClient.swf", "FtpClient", "100%", "100%", "8", "#FFFFFF");//"#FF6600");

			// pass all $_GET variables to Flash
			eval("<?php echo $str; ?>");

			fo.addParam("scale", "noscale");
			fo.addParam("swLiveConnect", "true");
			fo.addParam("quality", "best");
			fo.write("flashcontent");
		</script>
	</body>
</html>
