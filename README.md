# [Pronamic Google Maps](http://www.happywp.com/plugins/pronamic-google-maps/)

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

## Shortcode `googlemaps` `googlemapsmashup`

### Attributes

#### width

Type: `int|string`  
Default: *WordPress default embed width*

#### height

Type: `int|string`  
Default: *WordPress default embed height*

#### marker_options

Type: `array|json`  
Default: `array()`  

#### map_options

Type: `array|json`  
Default: `array()`  

#### new_design

Type: `boolean`  
Default: `false`  


## Shortcode `googlemaps`

### Example

```
[googlemaps width="250" height="250" static="true" label="M" color="orange"]
```

### Attributes

#### static

Type: `boolean`  
Default: `false`  

#### label

Type: `char`  
Default: `null`  

#### color

Type: `string`  
Default: `null`  
Examples: `0xFFFFCC`, `black`, `brown`  

See for information about styling markers the "Marker Styles" section on https://developers.google.com/maps/documentation/static-maps/intro#MarkerStyles.


## Shortcode `googlemapsmashup`

### Attributes

#### query

Type: `string`  
Default: `null`  

#### map_type_id

Type: `string`  
Default: `roadmap`  

Map style, can be: `roadmap`, `satellite`, `hybrid`, `terrain`.

#### latitude

Type: `float`  
Default: `0`  

Latitude value for the map center, only works if `fit_bounds` is set to `false`. 

#### longitude

Type: `float`  
Default: `0`  

Longitude value for the map center, only works if `fit_bounds` is set to `false`.

#### zoom

Type: `int`  
Default: `8`  

#### fit_bounds

Type: `boolean`  
Default: `true`  

#### marker_clusterer_options

Type: `string|array`  
Default: `array`  

For all cluster marker options see the [MarkerClustererOptions](http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html)
section on the [MarkerClustererPlus](http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html) documentation page.

Example: `maxZoom=15&gridSize=30`  

#### overlapping_marker_spiderfier_options

Type: `string|array`  
Default: `array`  

For all overlapping marker spiderfier options check the https://github.com/jawj/OverlappingMarkerSpiderfier page.

Example: `markersWontMove=true&markersWontHide=true`  


## Function `pronamic_google_maps`

### Example

```php
<?php

if ( function_exists( 'pronamic_google_maps' ) ) {
	pronamic_google_maps( array(
		'width'       => 800,
		'height'      => 800,
		'map_options' => array(
			'minZoom' => 5,
			'maxZoom' => 10,
		),
	) );
}
```


### Parameters

#### width

Type: `int|string`  
Default: *WordPress default embed width*

#### height

Type: `int|string`  
Default: *WordPress default embed height*

#### static

Type: `boolean`  
Default: `false`  

#### label

Type: `string`  
Default: `null`  

The `label` parameter is only available for Static Maps, for more information 
see the [Marker Styles](https://developers.google.com/maps/documentation/staticmaps/#MarkerStyles) section
of the [Static Maps](https://developers.google.com/maps/documentation/staticmaps/) documentation page.

#### color

Type: `string`  
Default: `null`  

#### echo

Type: `boolean`  
Default: `true`  

#### marker_options

Type: `array`  
Default: `array()`  

For all marker options see the [MarkerOptions](https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
section on the [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript/reference) documentation page.

#### map_options

Type: `array`  
Default: `array()`  

For all map options see the [MapOptions](https://developers.google.com/maps/documentation/javascript/reference#MapOptions)
section on the [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript/reference) documentation page.


## Function `pronamic_google_maps_mashup`

### Example

```php
<?php

if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 50,
		),
		array(
			'width'          => 800,
			'height'         => 800,
			'map_type_id'    => 'satellite',
			'latitude'       => 52,
			'longitude'      => 8,
			'zoom'           => 4,
			'fit_bounds'     => false,
		)
	);
}
```


### Parameters

#### width

Type: `int|string`  
Default: *WordPress default embed width*

#### height

Type: `int|string`  
Default: *WordPress default embed height*


## Overlapping Marker Spiderfier

The Pronamic Google Maps plugin has built-in support for the [Overlapping Marker Spiderfier](https://github.com/jawj/OverlappingMarkerSpiderfier) library.
This library will be enabled if you pass in the `overlapping_marker_spiderfier_options` argument in the mashup arguments, see example below.

### Example

```php
<?php

if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 50,
		),
		array(
			'width'  => 800,
			'height' => 800,
			'overlapping_marker_spiderfier_options' => array(
				'markersWontMove'        => false,
				'markersWontHide'        => false,
				'keepSpiderfied'         => false,
				'nearbyDistance'         => 20,
				'circleSpiralSwitchover' => 9,
				'legWeight'              => 1.5,
			),
		)
	);
}
```


## Meta Keys

### `_pronamic_google_maps_active`

### `_pronamic_google_maps_latitude`
