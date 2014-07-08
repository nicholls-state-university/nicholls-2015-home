<?php

// Include Nicholls Core
require_once( WP_CONTENT_DIR . '/themes/nicholls-2012-core/functions.php' );

/*
* FNBX Theme Support Filter
*
* Since this may be delpolyed on WordPress sites lacking some theme support features.
*
* @since 1.0
*/
function nicholls_home_theme_support_filter( $features ) {
	// Set and filter WordPress theme support features
	$features['post-formats'] = false;
	$features['custom-background'] = false;
	$features['custom-header'] = true;

	return $features;
}
add_filter( 'fnbx_theme_support', 'nicholls_home_theme_support_filter', 20 );

// Use filter to add widget groups
function nicholls_home_theme_widgets( $widget_groups ) {

	$widget_groups['Home Special'] = 'Home page widget area';

	return $widget_groups;
}
add_filter( 'fnbx_widgets', 'nicholls_home_theme_widgets' );

// Function to help action generate widget group
function nicholls_theme_widgets_home_special() {
	fnbx_generate_widgets( 'home-special' );
}

function nicholls_home_j_flex_slider_img_config( $flex_image_config ) {
	$flex_image_config['height'] = 600;
	$flex_image_config['width'] = 1144;
	$flex_image_config['crop'] = true;
	return $flex_image_config;
}
add_filter( 'j_flex_image_config', 'nicholls_home_j_flex_slider_img_config' );

function nicholls_home_j_flex_slider_img_thumb_config( $flex_image_config ) {
	$flex_image_config['height'] = 60;
	$flex_image_config['width'] = 60;
	$flex_image_config['crop'] = true;
	return $flex_image_config;
}
add_filter( 'j_flex_image_thumb_config', 'nicholls_home_j_flex_slider_img_thumb_config' );

function nicholls_home_j_flex_show_num( $show_num = 5 ) {
	return 10;
}
add_filter( 'j_flex_show_num', 'nicholls_home_j_flex_show_num' );


