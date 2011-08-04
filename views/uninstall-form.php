<?php 

if(!empty($_POST) && check_admin_referer('pronamic_google_maps_uninstall', 'pronamic_google_maps_nonce')) {
	Pronamic_Google_Maps_Plugin::uninstall();
}

?>
<form method="post" action="">
	<?php wp_nonce_field('pronamic_google_maps_uninstall', 'pronamic_google_maps_nonce'); ?>

	<h3>
		<?php _e('Delete plugin', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
	</h3>

	<div class="delete-alert">
		<p>
			<?php _e('Warning! This will delete all Pronamic Google Maps data and options.', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
		</p>

		<?php 
		
		submit_button(
			__('Uninstall', Pronamic_Google_Maps::TEXT_DOMAIN) , 
			'delete'
		);
		
		?>
	</div>
</form> 