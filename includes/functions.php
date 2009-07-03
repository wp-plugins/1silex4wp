<?php 
/**
 * display and throw an error 
 */
function silex_error($error_code,$error_message)
{
	echo '<div class="updated fade error" style="font-weight:bold;color:red;"><p>'.$error_message.'</p></div>';
	new WP_Error($error_code, __($error_message));
	//user_error(__($error_message),E_USER_WARNING);
}
// do the copy
function silex_duplicate($folder,$newFolder){
//	echo "silex_duplicate($folder,$newFolder)<br>";
	mkdir($newFolder);
	// list folder and copy
	$tmpFolder = opendir($folder);
	while ($tmpFile = readdir($tmpFolder)) {
		//if ($tmpFile != "." && $tmpFile != ".." ){
		if (is_file($folder.$tmpFile)){
			if (!copy($folder.$tmpFile,$newFolder.$tmpFile)){
				return FALSE;
			}
		}
		else if (is_dir($folder.$tmpFile)===TRUE){
			// do not copy if it begins with a dot
			if (strpos($tmpFile,'.')!==0){
				// recursively duplicate folders
				if(!silex_duplicate($folder.$tmpFile.'/',$newFolder.$tmpFile.'/')){
					return FALSE;
				}
			}
		}
	}
	return TRUE;
}

?>