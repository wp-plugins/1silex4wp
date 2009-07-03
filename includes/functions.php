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

?>