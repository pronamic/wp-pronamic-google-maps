<?php 

if(!empty($_POST) && check_admin_referer('pronamic_google_maps_uninstall', 'pronamic_google_maps_nonce')) {
	Pronamic_Google_Maps_Plugin::uninstall();
}

?>
<form method="post" action="">
	<?php wp_nonce_field('pronamic_google_maps_uninstall', 'pronamic_google_maps_nonce'); ?>

	<h3>
		<?php _e('Delete plugin', 'pronamic_google_maps'); ?>
	</h3>

	<div class="delete-alert">
		<p>
			<?php _e('Warning! This will delete all Pronamic Google Maps data and options.', 'pronamic_google_maps'); ?>
		</p>

		<?php 
		
		submit_button(
			__('Uninstall', 'pronamic_google_maps') , 
			'delete'
		);
		
		?>
	</div>
</form> 