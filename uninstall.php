<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Delete tables
global $wpdb;

// Delete meta
$meta_keys = "'" . implode( "', '", array(
	'_pronamic_google_maps_active',
	'_pronamic_google_maps_address',
	'_pronamic_google_maps_description',
	'_pronamic_google_maps_geocode_status',
	'_pronamic_google_maps_latitude',
	'_pronamic_google_maps_longitude',
	'_pronamic_google_maps_map_type',
	'_pronamic_google_maps_title',
	'_pronamic_google_maps_zoom',
) ) . "'";

$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key IN ( $meta_keys);" );

// Delete options
delete_option( 'Pronamic_Google_maps' );

delete_option( '_pronamic_google_maps_fresh_design' );
