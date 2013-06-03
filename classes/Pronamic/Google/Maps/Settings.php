<?php

/**
 * Settings Class for Pronamic Google Maps
 * 
 * Uses the WordPress Settings API. This class also contains the
 * conditional statements used for template functions.
 * 
 * The active post type settings are being stored in their old
 * name format as not to break previous versions of the plugin.
 * 
 * All new plugin settings will be stored with a naming scheme similar
 * to the new setting 'pronamic_google_maps_visual_refresh'
 * 
 * @package Pronamic Google Maps
 * @subpackage Settings
 * @author Leon Rowland <leon@rowland.nl>
 * @version 1.0.0
 */
class Pronamic_Google_Maps_Settings {
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}
	
	/**
	 * =========
	 * 
	 * Settings API required functions
	 * 
	 * =========
	 */
	
	/**
	 * Adds and registers the new settings with the 
	 * Settings API.
	 * 
	 * The setting for which post types are active are stored
	 * with the old naming scheme as to keep backwards
	 * compatability.
	 * 
	 * @see http://codex.wordpress.org/Settings_API
	 * 
	 * @access public
	 * @return void
	 */
	public function register_settings() {
		// General settings section
		add_settings_section(
			'pronamic_google_maps_settings_section_general',
			__( 'General', 'pronamic_google_maps' ),
			'__return_false',
			'pronamic_google_maps'
		);
		
		// Settings fields for the general settings section
		add_settings_field(
			'Pronamic_Google_maps',
			__( 'Activate Google Maps', 'pronamic_google_maps' ),
			array( $this, 'setting_google_maps_active' ),
			'pronamic_google_maps',
			'pronamic_google_maps_settings_section_general'
		);
		
		add_settings_field(
			'pronamic_google_maps_visual_refresh',
			__( 'Visual Refresh', 'pronamic_google_maps' ),
			array( $this, 'setting_google_maps_visual_refresh' ),
			'pronamic_google_maps',
			'pronamic_google_maps_settings_section_general',
			array( 'label_for' => 'pronamic-google-maps-visual-refresh' )
		);
		
		// Register those settings
		register_setting( 'pronamic_google_maps_settings', 'Pronamic_Google_maps' );
		register_setting( 'pronamic_google_maps_settings', 'pronamic_google_maps_visual_refresh', array( $this, 'sanitize_boolean' ) );
	}
	
	/**
	 * Sets the default options for the plugin. This function
	 * uses a setting from the old naming scheme ( prior to the usage
	 * of the Settings API )
	 * 
	 * All previous calls inside the Pronamic_Google_Maps_Map methods
	 * now reference methods inside this class
	 * 
	 * @access public
	 * @return void
	 */
	public static function set_default_options() {
		update_option( 'Pronamic_Google_maps', array( 'active' => array( 'post' => true, 'page' => true ) ) );
	}
	
	/**
	 * ======
	 * 
	 * Static methods to get values of settings. To
	 * be used throughout the system
	 * 
	 * ======
	 */
	
	/**
	 * Conditional check to determine if the settings
	 * exist or not.
	 * 
	 * @access public
	 * @return bool
	 */
	public static function has_settings() {
		return ( false !== self::get_active_post_types() );
	}
	
	/**
	 * Conditional check to see if the passed post type
	 * has been selected to be a google maps post type
	 * 
	 * @access public
	 * @param string $post_type
	 * @return bool
	 */
	public static function is_active_post_type( $post_type ) {
		$activated_post_types = self::get_active_post_types();
		return ( isset( $activated_post_types[$post_type] ) && filter_var( $activated_post_types[$post_type], FILTER_VALIDATE_BOOLEAN ) );
	}
	
	/**
	 * Returns all the settings. ( Uses the old name. New settings
	 * are not saved under this name or retrieved with this function. )
	 * 
	 * Please look for the valid functions for other settings.
	 * 
	 * @access public
	 * @return array|false
	 */
	public static function get_settings() {
		return get_option( 'Pronamic_Google_maps' );
	}
	
	/**
	 * Returns the active post types selected for Google Maps
	 * 
	 * @access public
	 * @return array
	 */
	public static function get_active_post_types() {
		$legacy_saved_settings = get_option( 'Pronamic_Google_maps' );
		return $legacy_saved_settings['active'];
	}
	
	/**
	 * ======
	 * 
	 * Callback for settings field generations
	 * 
	 * ======
	 */
	
	
	/**
	 * Shows the input for the active post type settings
	 * 
	 * @setting-name Pronamic_Google_maps
	 */
	public function setting_google_maps_active() {
		$post_types = get_post_types( array(
			'public' => true
		), 'objects' );
		
		if ( $post_types ) : ?>

			<ul style="margin: 0;">
			
				<?php foreach ( $post_types as $name => $type ) : ?>
	
					<li>
						<label for="pronamic-google-maps-type-<?php echo $name; ?>">
							<input id="pronamic-google-maps-type-<?php echo $name; ?>" name="Pronamic_Google_maps[active][<?php echo $name; ?>]" value="true" type="checkbox" <?php checked( self::is_active_post_type( $name ) ); ?> />
							<?php echo $type->labels->singular_name; ?>
						</label>
					</li>

				<?php endforeach; ?>
			
			</ul>
		
		<?php endif;
	}
	
	/**
	 * Shows the input for the fresh design setting
	 * 
	 * @setting-name _pronamic_google_maps_fresh_design
	 */
	public function setting_google_maps_visual_refresh() {
		?>
		<label for="pronamic-google-maps-visual-refresh">
			<input id="pronamic-google-maps-visual-refresh" name="pronamic_google_maps_visual_refresh" value="true" type="checkbox" <?php checked( get_option( 'pronamic_google_maps_visual_refresh' ) ); ?> />
			<?php _e( 'Use Visual Refresh', 'pronamic_google_maps' ); ?> 
			
			<p class="description">
				<?php 
				
				printf( 
					__( 'A new flat design from Google to incorperate the new design from Google Maps. You can find an example <a href="%s" title="External Link Example">here</a>', 'pronamic_google_maps' ),
					'https://developers.google.com/maps/documentation/javascript/examples/map-simple-refresh' 
 				);
 				
 				?>
 			</p>
		</label>
		<?php
	}

	public function sanitize_boolean( $input ) {
		return filter_var( $input, FILTER_VALIDATE_BOOLEAN );
	}
}
