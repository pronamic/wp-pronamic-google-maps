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
			__( 'Post Types', 'pronamic_google_maps' ),
			array( $this, 'setting_google_maps_active' ),
			'pronamic_google_maps',
			'pronamic_google_maps_settings_section_general',
			array(
				'description' => __( 'Enable Google Maps for the selected post types.', 'pronamic_google_maps' ),
			)
		);

		add_settings_field(
			'pronamic_google_maps_visual_refresh',
			__( 'Visual Refresh', 'pronamic_google_maps' ),
			array( $this, 'setting_google_maps_visual_refresh' ),
			'pronamic_google_maps',
			'pronamic_google_maps_settings_section_general',
			array(
				'description' => sprintf(
					__( 'The <a href="%s" target="_blank">Google Maps visual refresh</a> brings a fresh new look to applications using the Google Maps JavaScript API.', 'pronamic_google_maps' ),
					'https://developers.google.com/maps/documentation/javascript/basics#VisualRefresh'
				),
				'label_for'   => 'pronamic_google_maps_visual_refresh',
			)
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

		return ( isset( $activated_post_types[ $post_type ] ) && filter_var( $activated_post_types[ $post_type ], FILTER_VALIDATE_BOOLEAN ) );
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
		$active = array();

		$legacy_options = get_option( 'Pronamic_Google_maps' );
		if ( isset( $legacy_options['active'] ) ) {
			$active = $legacy_options['active'];
		}

		return $active;
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
	public function setting_google_maps_active( $args ) {
		$post_types = get_post_types( array(
			'public' => true,
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

			<?php if ( isset( $args['description'] ) ) : ?>

				<p class="description"><?php echo $args['description']; ?></p>

			<?php endif;

		endif;
	}

	/**
	 * Shows the input for the fresh design setting
	 *
	 * @setting-name _pronamic_google_maps_fresh_design
	 */
	public function setting_google_maps_visual_refresh( $args ) {
		?>
		<label for="pronamic_google_maps_visual_refresh">
			<input id="pronamic_google_maps_visual_refresh" name="pronamic_google_maps_visual_refresh" value="true" type="checkbox" <?php checked( get_option( 'pronamic_google_maps_visual_refresh' ) ); ?> />
			<?php _e( 'Use Google Maps Visual Refresh', 'pronamic_google_maps' ); ?>
		</label>

		<?php if ( isset( $args['description'] ) ) : ?>

			<p class="description"><?php echo $args['description']; ?></p>

		<?php endif;
	}

	public function sanitize_boolean( $input ) {
		return filter_var( $input, FILTER_VALIDATE_BOOLEAN );
	}
}
