<?php
/*  Copyright 2009  Alexandre Hoyau  (email : lex [at] silex-ria . org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * @package 1silex4wp
 * @author Lexa Yo
 * @version 0.1
 */
function silex_options() {
	if (isset($_POST["silex_selected_template"])){
		update_silex_options();
		silex_success('Configuration Updated!');
	}
?>
<div class="wrap">
	<h2>Settings of Silex plugin</h2>
	<h3>Useful links</h3>
	<ul>
		<li type="circle">create your own templates</li>
		<li type="circle">ddd</li>
	</ul>
	<br />
	<h3>Settings</h3>
	<form method="post" action="">
		<?php wp_nonce_field('update-options'); ?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">Selected Silex Template</th>
				<td><input type="text" name="silex_selected_template" value="<?php echo get_option('silex_selected_template'); ?>" /></td>
			</tr>
			<th scope="row">Override WordPress URL rewrite rule</th>
				<td><input type="checkbox" name="override_wp_url_rewrite_rules" <?php echo get_option('override_wp_url_rewrite_rules')==1?'checked="checked"':''; ?> /></td>
			</tr>
			<th scope="row">Use Flash template by default</th>
				<td><input type="checkbox" name="use_flash_by_default" <?php echo get_option('use_flash_by_default')==1?'checked="checked"':''; ?>" /></td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="silex_selected_template ,override_wp_url_rewrite_rules,use_flash_by_default" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
<?php
}


function silex_menu() {
  add_options_page('Silex Plugin Options', 'Silex Plugin', 8, 'silex-admin-page', 'silex_options');
}

function register_silex_settings() { // whitelist options
	register_silex_options();
}

if ( is_admin() ){ // admin actions
	add_action('admin_menu', 'silex_menu');
	add_action( 'admin_init', 'register_silex_settings' );
} else {
  // non-admin enqueues, actions, and filters
}
?>
