## Function `pronamic_google_maps`

### Example

```php
<?php echo <<<'PHP'
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
PHP;
?>


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
