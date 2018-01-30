<?php

add_action( 'admin_menu', 'register_admin_menu' );

function register_admin_menu(){
  register_setting( 'cookbook_settings', 'cookbook_settings' );
  add_options_page( 'Cookbook Settings', 'Cookbook Settings', 'manage_options', 'cookbook', 'cookbook_settings_page' );

  $defaults = array(
    'one' => '',
    'two' => '',
    'three' => 0,
    'stupid' => 0
  );

  $current = get_option( 'cookbook_settings' );

  foreach( $defaults as $key => $val ){
    if( ! isset( $current[$key] ) ){
      $current[$key] = $val;
    }
  }

  update_option( 'cookbook_settings', $current );
}

function cookbook_settings_page(){
  ?>
  <div class="wrap">
    <form method="post" action="options.php">
      <h1>Cookbook</h1>
      <hr>
      <?php cookbook_default_settings(); submit_button(); ?>
    <form>
  </div>
  <?php
}

function cookbook_default_settings(){
  settings_fields( 'cookbook_settings' );

  $settings = get_option( 'cookbook_settings' );
	?>
	<h2>Default Settings</h2>
	Set default form values for plugin.
	<table class="form-table">
		<tbody>
			<tr>
				<th>Setting One</th>
				<td><input name="cookbook_settings[one]" value="<?php esc_attr_e( $settings['one'] )?>"></td>
			</tr>
			<tr>
				<th>Setting Two</th>
				<td><input name="cookbook_settings[two]" value="<?php esc_attr_e( $settings['two'] )?>"></td>
			</tr>
			<tr>
				<th>Setting Three</th>
				<td><input type="number" name="cookbook_settings[three]" value="<?php esc_attr_e( $settings['three'] )?>"></td>
			</tr>
      <tr>
        <th>Checkboxes Are Stupid</th>
        <td><input type="checkbox" name="cookbook_settings[stupid]" value="1" <?php checked( 1 == $settings['stupid'] ); ?>></td>
		</tbody>
	</table>
	<?php
}
