<?php 
/**
 * display and throw an error 
 */
function silex_error($error_code,$error_message){
	echo '<div class="updated fade error" style="font-weight:bold;color:red;"><p>'.$error_message.'</p></div>';
	new WP_Error($error_code, __($error_message));
	//user_error(__($error_message),E_USER_WARNING);
}
/**
 * display a success message 
 */
function silex_success($message){
	echo '<div class="updated fade success" style="font-weight:bold;color:green;"><p>'.$message.'</p></div>';
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
function add_silex_options(){
	// add options
	add_option("selected_template", 'wp-default', '', 'yes');
	add_option("override_wp_url_rewrite_rules", '0', '', 'yes');
	add_option("use_flash_by_default", '1', '', 'yes');
}
function update_silex_options(){
	update_option('selected_template', (string)$_POST["selected_template"]);
	update_option('override_wp_url_rewrite_rules', (boolean)$_POST["override_wp_url_rewrite_rules"]);
	update_option('use_flash_by_default', (boolean)$_POST["use_flash_by_default"]);
}
function register_silex_options(){
  register_setting( 'silex-option-group', 'selected_template' );
  register_setting( 'silex-option-group', 'override_wp_url_rewrite_rules' );
  register_setting( 'silex-option-group', 'use_flash_by_default' );
}
?>