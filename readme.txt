=== Pronamic Google Maps ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, google maps, widget, placemarker, geo, v3, api, custom types, latitude, longitude, location, geocoder, reverse geocode, gecode, bulk
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 2.1.1

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

*	**Shortcode**
	Easily integrate a Google Maps in your post content:

		[google-maps]
		[google-maps static=true]
		[google-maps static=true label=M]
		[google-maps width=200 height=200]

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
		<abbr class="latitude" title="37.408183">N 37Â° 24.491</abbr> 
		<abbr class="longitude" title="-122.13855">W 122Â° 08.313</abbr>
	</div> 


= How to use? =

**Dynamic Google Maps**

	<?php

	if(function_exists('pronamic_google_maps')) {
		pronamic_google_maps(array(
			'width' => 290 ,
			'height' => 200 
		));
	}

	?>

**Static Google Maps**

	<?php

	if(function_exists('pronamic_google_maps')) {
		pronamic_google_maps(array(
			'width' => 290 ,
			'height' => 200 ,
			'static' => true ,
			'color' => '0xFFD800' ,
			'label' => 'M'
		));
	}

	?>

**Google Maps Mashup**

	<?php

	if(function_exists('pronamic_google_maps_mashup')) {
		pronamic_google_maps_mashup(
			array(
				'post_type' => 'post'
			) , 
			array(
				'width' => 300 ,
				'height' => 200 , 
				'map_type_id' => 'satellite' , 
				'marker_options' => array(
					'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png'
				)
			)
		);
	}

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

	if(function_exists('pronamic_google_maps')) {
		pronamic_google_maps(array(
			'width' => 290 ,
			'height' => 200 
		));
	}

	?>


**Static Google Maps**

	<?php

	if(function_exists('pronamic_google_maps')) {
		pronamic_google_maps(array(
			'width' => 290 ,
			'height' => 200 ,
			'static' => true ,
			'color' => '0xFFD800' ,
			'label' => 'M'
		));
	}

	?>


**Filter the_content()**

	<?php

	if(function_exists('pronamic_google_maps')) {
		function custom_pronamic_google_maps_the_content($content) {
			$content .= pronamic_google_maps(array(
				'width' => 500 , 
				'height' => 500 , 
				'echo' => false
			));
		
			return $content;
		}
		
		add_filter('the_content', 'custom_pronamic_google_maps_the_content', 9);
	}

	?>


If you want to display the [GEO microformat](http://microformats.org/wiki/geo) with the 
latitude and longitude information you should call the following function in your template:

	<?php pronamic_google_maps_geo_microformat(); ?>

Or througt an filter
	
	<?php
	
	function custom_pronamic_google_maps_the_content($content) {
		$content .= pronamic_google_maps(array(
			'width' => 500 , 
			'height' => 500 , 
			'echo' => false
		));
	
		$content .= pronamic_google_maps_geo_microformat(array(
			'echo' => false
		));
	
		return $content;
	}
	
	add_filter('the_content', 'custom_pronamic_google_maps_the_content', 9);


== Screenshots ==

1. The Google Maps widget.

2. Meta box where you can easily manage the Google Maps / GEO data.

3. Configuration panel of the Pronamic Google Maps plugin. Within this panel you can easily activate the Google Maps functionality for the registered post types.

4. The geocoder can be used to geocode multiple posts at once.


== Changelog ==

= 2.1.1 =
*	Added a short description to the meta box, thanks to [andrewhouse](http://wordpress.org/support/profile/andrewhouse)
*	Removed some PHP 5.3+ namespace slashes that were causing warnings on lower versions of PHP (unexpected character in input: '\' (ASCII=92))

= 2.1 =
*	Mashup map is now also rendered if there are no posts found
*	First parameter of the pronamic_google_maps_mashup() function now also be an WP_Query object
*	Fixed issue with the Google Maps shortcode, in most cases it was not returning the output from the shortcode function
*	Added an uninstall form so you can easily delete options and meta data

= 2.0 =
*	Fixed Notice: Undefined index: fit_founds
*	Removed wp_register_script('google-maps', ...), we now only use the Google JavaScript load API
*	Fix issue with the JavaScript variabel google.loader.ClientLocation wich can be null
*	Added default zoom and map type values in the constants: Pronamic_Google_Maps::MAP_ZOOM_DEFAULT and Pronamic_Google_Maps::MAP_TYPE_DEFAULT
*	If there is no meta information about the zoom level and the map type the default values will be set 
*	Replaced all the require once statements for the classes with an SPL autoload function
*	Changed the default width and height values, now based on the output of the wp_embed_defaults() function
*	Added shortcode [google-maps] functionality
*	Added JavaScript event trigger "pronamic-google-maps-ready"
*	Fixed the rendering of the mashup, if there are no posts found the empty ul element will not be added
*	Added 'marker_options' as argument for the pronamic_google_maps() function
*	Added the new Google Maps favicon to the WordPress admin menu

= 1.9 =
*	Replaced the normal Google Maps v3 JavaScripts with the Google JavaScript API loader scripts
*	Thanks to the Google JavaScript API loader we can now use the "google.loader.ClientLocation" JavaScript variable
*	Replaced some "jQuery" JavaScript variables to the shorter notation "$"
*	Added all required map options (center, mapTypeId and zoom) to the creation of mashup maps
*	Added 'fit_bounds' option for the pronamic_google_maps_mashup($query, $arguments) function
*	Combined the JavaScript file widget.js into admin.js and did some improvements
*	Browser check after changing some core JavaScripts:
	*	Mozilla Firefox 3.6.17
	*	Google Chrome 12.0.742.100
	*	Opera 11.11
	*	Safari 5.0.5
	*	Internet Explorer 9.0.8112.16421
	*	Internet Explorer 8.0.6001.19088
	*	Intenret Explorer 7.0.5730.11

= 1.8 =
*	Changed jQuery selectors [property=value] to [property="value"], jQuery 1.5.0 no longer allows these selectors
*	Added extra meta data field for address information
*	Added address field
*	Added geocode and reverse geocode buttons
*	Removed search field and button 
*	Combined the latitude and longitude fields into one form table row
*	Replaced the add_options_page() with an add_menu_page() call
*	Combined the class Pronamic_Google_Maps_OptionPage into the Pronamic_Google_Maps_Admin class 
*	Replaced the HTML buttons in the options pages with the function submit_button()
*	Added geocoder page to bulk geocode posts
*	Changed the way the JavaScript are loaded, we use a solution from Scribu: "[How to load JavaScript like a WordPress Master](http://scribu.net/wordpress/optimal-script-loading.html)"

= 1.7.1 =
*	Added an wp_reset_postdata() call after the custom query in the mashup class in request
	of [ezlxq73](http://wordpress.org/support/topic/bug-in-pronamic_google_maps_mashup?replies=1#post-2128808)

= 1.7 =
*	Changed 'WP_query' to the 'WP_Query' class name 
*	Improved the way the frontend JavaScripts are enqueued, on singular pages only when Google Maps is active.
	If your Google Maps mashup is not working anymore you probably have to call 
	wp_enqueue_script('pronamic-google-maps-site') in your mashup template. We adjusted this in request 
	of [MrVictor](http://wordpress.org/support/topic/plugin-pronamic-google-maps-load-script-only-on-pages-post-types-with-maps?replies=2#post-2096660)

= 1.6.3 =
*	Made it possible to use HTML in the title and description field (uses [function wp_kses_post()](http://codex.wordpress.org/Data_Validation)),
	request of [Paul Craig](http://fusio.net/) and [bigchiefrandomchaos](http://wordpress.org/support/profile/bigchiefrandomchaos).

= 1.6.2 = 
*	Changed the scope of some JavaScript functions in site.js and admin.js
*	Changed some JavaScripts so the Google Maps object is binded to some DOM elements (http://api.jquery.com/data/)

= 1.6.1.2 =
*	Removed some unnecessary JavaScript, in response to problems in IE6 and 7.

= 1.6.1.1 =
*	Fixed the static map the image source attribute was empty since version 1.6.1.
*	Fixed a bug in Internet Explorer 8, we now use the window [load event](http://api.jquery.com/load-event/) 
	instead of the [ready event](http://api.jquery.com/ready//). If we use the read event the markers will not 
	show up on the map (thanks to SweetManiac).

= 1.6.1 =
*	Added 'echo' argument in the pronamic_google_maps() and pronamic_google_maps_mashup() functions
*	Fixed the 'pronamic_google_maps_geo_microformat()' function, if Google Maps is not active for the current post or post type don't render the microformat

= 1.6 = 
*	Share a single info window on the mashup map (Demo: [Single Info Windows](http://gmaps-samples-v3.googlecode.com/svn/trunk/single-infowindow/single-infowindow.html))
*	The marker options of the mashup map can now be configured.

= 1.5.1.1 =
*	Fixed a typo in the GEO micrformat render function.

= 1.5.1 =
*	Fixed bug in version 1.5, function get_the_ID() was not working in all cases, now back to global $post; and $post->ID;
*	Updated the screenschots

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
*	[JavaScript Regular Expression](http://lawrence.ecorp.net/inet/samples/regexp-format.php)
*	[Pronamic](http://pronamic.eu/)
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