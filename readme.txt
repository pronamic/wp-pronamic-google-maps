=== Pronamic Google Maps ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, google maps, widget, placemarker, geo, v3, api, custom types, latitude, longitude, location
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.4.1

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

== Description ==

= Intro = 

With this plugin a user can easily add location (latitude, longitude) meta data to a page, post or a 
custom post type. This plugin adds a meta box with an Google Map to the post editor. Users can easily 
drag and drop a marker on the map to save location meta data for a post.

There are quite a few Google Maps plugins available in the WordPress Plugin Directory. Most of
the available plugins have a few drawbacks:

*	**Google Maps API version 3**
	Most of the available plugins still use the Google Maps version 2 API. To use the Google Maps v2 API you 
	have to require an API key and include this in the plugin configuration.  The Pronamic Google Maps plugin 
	uses the Google Maps version 3 API. Wich no longer requires an API key, so you don't have 
	to configure this plugin.

*	**No confusing shortcodes**
	This plugin does *not* work with the [WordPress shortcode API][1]. Although it's an very powerful 
	technique, it's not always very user friendly. Not all users understand the shortcodes like;

		[google-map-sc external_links="true" zoom="3"]


*   **No extra tables**
	Some plugin create additional tables in your WordPress database to store additional data. In many
	cases this is not necessary, it's only pollutes your database. WordPress offers enough [functions to 
	store additional data][2].

*	**Custom Post Types**
	A lot of the WordPress plugins are developed before WordPress 3 was launched. These plugins not
	always use the new features of WordPress 3. Many plugins only focus on posts and pages, but not 
	on other custom post types. This plugin does!

= Custom Post Types = 

The nice thing about this plugin that developers can configure on what post type the meta box should be visible. 
Developers can activate the meta box for every custom post type they registered with the [register\_post\_type function][3].

For example: if a developer registers a custom post type for *real estate* it is very easy to activate and 
manage location data for that post type. It comes in handy for all kind of custom post types!

*   Real estate
*   Ships
*   Ports
*   Restaurants
*   Accommodations
*   Hotels

= Microformats =

The plugin uses the latest [GEO microformat standards](http://microformats.org/wiki/geo).

	<div class="geo">
		<abbr class="latitude" title="37.408183">N 37° 24.491</abbr> 
		<abbr class="longitude" title="-122.13855">W 122° 08.313</abbr>
	</div> 


= How to use? =

**Dynamic Google Maps**

	<?php

	pronamic_google_maps(array(
		'width' => 290 ,
		'height' => 200 
	));

	?>

**Static Google Maps**

	<?php
	
	pronamic_google_maps(array(
		'width' => 290 ,
		'height' => 200 ,
		'static' => true ,
		'color' => '0xFFD800' ,
		'label' => 'M'
	));

	?>


 [1]: http://codex.wordpress.org/Shortcode_API
 [2]: http://codex.wordpress.org/Custom_Fields
 [3]: http://codex.wordpress.org/Function_Reference/register_post_type

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.

You should add some code to you templates to add the Google Map.

**Dynamic Google Maps**

	<?php

	pronamic_google_maps(array(
		'width' => 290 ,
		'height' => 200 
	));

	?>


**Static Google Maps**

	<?php
	
	pronamic_google_maps(array(
		'width' => 290 ,
		'height' => 200 ,
		'static' => true ,
		'color' => '0xFFD800' ,
		'label' => 'M'
	));

	?>


If you want to display the [GEO microformat](http://microformats.org/wiki/geo) with the 
latitude and longitude information you should call the following function in your template:

	<?php pronamic_google_maps_geo_microformat(); ?>


== Screenshots ==

1. The Google Maps widget

2. The configuration panel of the Pronamic Google Maps plugin. Within this panel you can easily activate the Google Maps functionality for the registered post types.

3. The metabox where you can easily manage the GEO meta data.


== Changelog ==

= 1.5 =
*	Replaced all hidden HTML fields with one hidden field with JSON data
*	Removed "Like this plugin?" from options page
*	Removed "Donate $10, $20 or $50!" from options page
*	Removed "Latest news from Pronamic" from options page
*	Removed "Found a bug?" from options page
*	Added a search field above the Google Map in the admin
*	Added the pronamic_google_maps_is_active() function
*	Added the pronamic_google_maps_title() function and the "pronamic_google_maps_item_title" filter
*	Added the pronamic_google_maps_description() function and the "pronamic_google_maps_item_description" filter
*	Added mashup function: pronamic_google_maps_mashup($query, $arguments)
*	Added the 'pronamic_google_maps_mashup_item' filter
*	Added 'nl_NL' translations

= 1.4.1 =
*	Fixed marker on frontend should not be draggable (thanks to [Pim Vellinga](http://twitter.com/brainscrewer))
*	Added function pronamic_google_maps_location() for custom directions forms, template example:
		<form action="http://maps.google.com/maps" method="get"> 
			<label for="saddr">From:</label> 
			<input id="saddr" name="saddr" type="text" /> 

			<input name="daddr" type="hidden" value="<?php pronamic_google_maps_location(); ?>" />

			<input name="hl" type="hidden" value="<?php echo substr(WPLANG, 0, 2); ?>" /> 

			<input type="submit" value="Get Directions" /> 
		</form>

= 1.4 =
*	Fixed bug dynamic map fixed width and height (thanks to [Joost Baaij](http://www.spacebabies.nl/))
*	Added Google Maps widget
*	Add JavaScripts with the [wp_enqueue_script function](http://codex.wordpress.org/Function_Reference/wp_enqueue_script)
*	[GEO microformat](http://microformats.org/wiki/geo) added. You should add the folowing CSS code to your stylesheet if you don't want to display the GEO microformat.
		.pgm .geo { display: none; }

= 1.3 =
*	Fixed a bug dynamic maps didn't show up (thanks to ThomasBuxo)
*	Made the latitude and longitude fields visibile again (request from ThomasBuxo)
*	Added change and keyup events to latitude and longitude fields
*	Mozilla Firefox 3.6.10 browser check
*	Google Chrome 6.0.472.63 browser check
*	Safari 5.0.2 browser check
*	Opera 10.62 browser check
*	Internet Explorer 8 browser check
*	Internet Explorer 7 browser check

= 1.2 =
*	Fixed bug with fixed zoom value of 12 on static Google Maps
*	Added translation options (Dutch language added)
*	Changed the latitude and longitude fields from text to hidden
 
= 1.1 =
*	Added static and dynamic Google Maps support 

= 1.0 =
*	Initial release

== Links ==

*	[Geocode with Google Maps API v3](http://tech.cibul.org/geocode-with-google-maps-api-v3/)
*	[WordPress event locations](http://icalevents.anmari.com/2343-event-locations-geo-tags-for-custom-post-types/)
*	[Pronamic](http://pronamic.eu/)
*	[Remco Tolsma](http://remcotolsma.nl/)
*	[Markdown's Syntax Documentation][markdown syntax]

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"