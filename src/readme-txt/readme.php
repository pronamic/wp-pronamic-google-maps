<?php

header( 'Content-Type: text/plain' );

$data    = file_get_contents( __DIR__ . '/../../package.json' );
$package = json_decode( $data );

?>
=== Pronamic Google Maps ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, google maps, widget, placemarker, geo, v3, api, custom types, latitude, longitude, location, geocoder, reverse geocode, gecode, bulk
Donate link: http://pronamic.eu/donate/?for=wp-plugin-pronamic-google-maps&source=wp-plugin-readme-txt
Requires at least: 3.0
Tested up to: 4.3.1
Stable tag: <?php echo $package->version, "\r\n"; ?>
License: GPLv2 or later

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

== Description ==



= Intro = 

With this plugin a user can easily add location (latitude, longitude) meta data to a page, post or a 
custom post type. This plugin adds a meta box with an Google Map to the post editor. Users can easily 
drag and drop a marker on the map to save location meta data for a post.

There are quite a few Google Maps plugins available in the WordPress Plugin Directory. Why should you 
use the Pronamic Google Maps plugin:

*	**Google Maps API version 3**
	Most of the available plugins still use the Google Maps version 2 API. To use the Google Maps v2 API you 
	have to require an API key and include this in the plugin configuration.  The Pronamic Google Maps plugin 
	uses the Google Maps version 3 API. Wich no longer requires an API key, so you don't have 
	to configure this plugin.

*	**Shortcode**
	Easily integrate a Google Maps in your post content:

		[googlemaps]
		[googlemaps static=true]
		[googlemaps static=true label=M]
		[googlemaps width=200 height=200]
		[googlemaps new_design=true]

	Also easily integrate an Google Maps mashup in your post content:

		[googlemapsmashup query="post_type=company&nopaging=true" map_type_id="satellite"]

*   **No extra tables**
	Some plugin create additional tables in your WordPress database to store additional data. In many
	cases this is not necessary, it's only pollutes your database. WordPress offers enough [functions to 
	store additional data](http://codex.wordpress.org/Custom_Fields).

*	**Custom Post Types**
	A lot of the WordPress plugins are developed before WordPress 3 was launched. These plugins not
	always use the new features of WordPress 3. Many plugins only focus on posts and pages, but not 
	on other custom post types. This plugin does!

*	**Mashup**
	Easily create an Google Maps mashup to show all your posts on Google Maps. You can use an very powerfull 
	pronamic_google_maps_mashup() function or the shortcode. Both methods allow you to pass [custom 
	WordPress query parameters](http://codex.wordpress.org/Function_Reference/WP_Query#Parameters).

*	**No notices or warning**
	Pronamic is one of the few companies that develop all WordPress plugins in debug mode. This results
	in high quality plugins with no errors, warnings or notices. 



= Custom Post Types = 

The nice thing about this plugin that developers can configure on what post type the meta box should be visible. 
Developers can activate the meta box for every custom post type they registered with the 
[register\_post\_type function](http://codex.wordpress.org/Function_Reference/register_post_type).

For example: if a developer registers a custom post type for *real estate* it is very easy to activate and 
manage location data for that post type. It comes in handy for all kind of custom post types!

*	Projects
*   Real estate
*   Restaurants
*   Accommodations
*   Hotels
*   Ships
*   Ports



= Microformats =

The plugin uses the latest [GEO microformat standards](http://microformats.org/wiki/geo).

	<div class="geo">
		<abbr class="latitude" title="37.408183">N 37° 24.491</abbr> 
		<abbr class="longitude" title="-122.13855">W 122° 08.313</abbr>
	</div>



= Support Development =

If you like this plugin we hope that you will help support our continued development. 
The two best ways to offer your support is to send us a donation. Even $1 helps encourage 
us to do more. If you can't donate, please help us reach our 5-star rating by rating this 
plugin.



= Donate =

[Donate today!](http://pronamic.eu/donate/?for=wp-plugin-pronamic-google-maps&source=wp-plugin-readme-txt)



= Rate Us =

Please [rate us](http://wordpress.org/extend/plugins/pronamic-google-maps/)!
Give us a chance to <a href="http://pronamic.eu/contact/">address your concerns</a> 
if we didn't earn 5 stars.



= Special Requests =

We do accept feature requests for all of our plugins, free ones included. The most requested features 
will make it into the next version.
	
<strong>If you need a special feature NOW, <a href="http://pronamic.eu/contact/">contact us</a>!</strong> 
We offer expedited feature development. Most features can be implemented in less than a week for $200!



== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.

You should add some code to you templates to add the Google Map.

**Dynamic Google Maps**

<?php 
echo <<<'PHP'
	<?php

	if ( function_exists( 'pronamic_google_maps' ) ) {
		pronamic_google_maps( array(
			'width'  => 290,
			'height' => 200 
		) );
	}

	?>
PHP;
?>



**Static Google Maps**

<?php 
echo <<<'PHP'
	<?php

	if ( function_exists( 'pronamic_google_maps' ) ) {
		pronamic_google_maps( array(
			'width'  => 290,
			'height' => 200,
			'static' => true,
			'color'  => '0xFFD800',
			'label'  => 'M'
		) );
	}

	?>
PHP;
?>



**Filter the_content()**

<?php 
echo <<<'PHP'
	<?php

	if ( function_exists( 'pronamic_google_maps' ) ) {
		function custom_pronamic_google_maps_the_content( $content ) {
			$content .= pronamic_google_maps( array(
				'width'  => 500,
				'height' => 500,
				'echo'   => false
			) );
		
			return $content;
		}
		
		add_filter( 'the_content', 'custom_pronamic_google_maps_the_content', 9 );
	}

	?>
PHP;
?>



**Google Maps Mashup**

<?php 
echo <<<'PHP'
	<?php

	if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
		pronamic_google_maps_mashup(
			array(
				'post_type' => 'post'
			), 
			array(
				'width'          => 300,
				'height'         => 200, 
				'nopaging'       => true,
				'map_type_id'    => 'satellite', 
				'marker_options' => array(
					'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png'
				)
			)
		);
	}

	?>
PHP;
?>



**Microformat**

If you want to display the [GEO microformat](http://microformats.org/wiki/geo) with the 
latitude and longitude information you should call the following function in your template:

<?php 
echo <<<'PHP'
	<?php pronamic_google_maps_geo_microformat(); ?>
PHP;
?>

Or througt an filter

<?php
echo <<<'PHP'
	<?php
	
	function custom_pronamic_google_maps_the_content( $content ) {
		$content .= pronamic_google_maps( array(
			'width'  => 500 , 
			'height' => 500 , 
			'echo'   => false
		) );
	
		$content .= pronamic_google_maps_geo_microformat( array(
			'echo' => false
		) );
	
		return $content;
	}

	add_filter( 'the_content', 'custom_pronamic_google_maps_the_content', 9 );
PHP;
?>



== Frequently Asked Questions ==

1.	Have a question? Make a thread in the support forum and we will get back to you.



== Screenshots ==

1.	The Google Maps widget.

2.	Meta box where you can easily manage the Google Maps / GEO data.

3.	Configuration panel of the Pronamic Google Maps plugin. Within this panel you can easily activate the Google Maps functionality for the registered post types.

4.	The geocoder can be used to geocode multiple posts at once.



== Changelog ==

= todo =
*	Add options for different dimension types pixels, percentages, etc.
*	$("#pronamic-google-maps-meta-box-hide").change(function() { google.maps.event.trigger(map, "resize"); });
*	$("#pronamic-google-maps-meta-box .handlediv").change(function() { google.maps.event.trigger(map, "resize"); });
*	http://wordpress.org/support/topic/plugin-pronamic-google-maps-need-routes-too?replies=1#post-2741427
*	http://wordpress.org/support/topic/plugin-pronamic-google-maps-is-it-possible-to-set-the-default-location-etc-for-post-edit-map?replies=4#post-2811858

<?php require 'changelog.php'; ?>


== Upgrade Notice ==

= 2.2.4 =
Thanks for using the Pronamic Google Maps plugin! As always, this update is very strongly recommended.



== Translations ==

*	pl_PL by [Marcin Modestowicz](http://modestowicz.com/)



== Pronamic ==
*	[Pronamic](http://pronamic.eu/)
*	[Twitter](http://twitter.com/pronamic)
*	[Facebook](http://www.facebook.com/Pronamic)
*	[LinkedIN](http://www.linkedin.com/company/pronamic)



== Links ==

*	[google-maps-utility-library-v3](http://code.google.com/p/google-maps-utility-library-v3/)
*	[Geocode with Google Maps API v3](http://tech.cibul.org/geocode-with-google-maps-api-v3/)
*	[WordPress event locations](http://icalevents.anmari.com/2343-event-locations-geo-tags-for-custom-post-types/)
*	[JavaScript Regular Expression](http://lawrence.ecorp.net/inet/samples/regexp-format.php)
*	[Remco Tolsma](http://remcotolsma.nl/)
*	[Markdown's Syntax Documentation][markdown syntax]

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
			"Markdown is what the parser uses to process much of the readme file"



== Plugin in the wild ==

*	[Metz Ameland](http://metz-ameland.nl/)
*	[Earthcircuit](http://www.earthcircuit.org/blog/)
*	[Comando Lechuga](http://www.comandolechuga.com/)
*	[Professionele Fotografie](http://pf.nl/)
*	[Bouwwereld](http://bouwwereld.nl/)
*	[Architectuur](http://architectuur.nl/)
*	[Longboard.no](http://longboard.no/)
*	[Professionele Fotografie](http://pf.nl/)
*	[Emonta](http://emonta.nl/)



== Pronamic plugins ==

*	[Pronamic Google Maps](http://wordpress.org/extend/plugins/pronamic-google-maps/)
*	[Gravity Forms (nl)](http://wordpress.org/extend/plugins/gravityforms-nl/)
*	[Pronamic Page Widget](http://wordpress.org/extend/plugins/pronamic-page-widget/)
*	[Pronamic Page Teasers](http://wordpress.org/extend/plugins/pronamic-page-teasers/)
*	[Maildit](http://wordpress.org/extend/plugins/maildit/)
*	[Pronamic Framework](http://wordpress.org/extend/plugins/pronamic-framework/)
*	[Pronamic iDEAL](http://wordpress.org/extend/plugins/pronamic-ideal/)
