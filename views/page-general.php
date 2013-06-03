<?php
$options = Pronamic_Google_Maps_Maps::getOptions();

$types = get_post_types( array(
	'public' => true
	), 'objects' );

$activeTypes = $options['active'];
?>
<div id="pgm" class="wrap">
	<?php screen_icon( Pronamic_Google_Maps_Maps::SLUG ); ?>

	<h2><?php echo esc_html( __( 'Configuration - Pronamic Google Maps', 'pronamic_google_maps' ) ); ?></h2>

	<form action="options.php" method="post">
		<?php settings_fields( 'pronamic_google_maps_settings' ); ?>
		<?php do_settings_sections( 'pronamic-google-maps' ); ?>
		<?php submit_button( __( 'Save Changes', 'pronamic_google_maps' ) ); ?>
	</form>
</div>