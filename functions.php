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


/**
 * Taken directly from wp_rss_display Display the RSS entries in a list.
 *
 * @since 2.5.0
 *
 * @param string|array|object $rss RSS url.
 * @param array $args Widget arguments.
 */
function emergency_rss_output( $rss, $args = array() ) {
	if ( is_string( $rss ) ) {
		$rss = fetch_feed($rss);
	} elseif ( is_array($rss) && isset($rss['url']) ) {
		$args = $rss;
		$rss = fetch_feed($rss['url']);
	} elseif ( !is_object($rss) ) {
		return;
	}
	
	$alert_class = 'nicholls-emergency-notice ' . $alert_class;

	if ( is_wp_error($rss) ) {
		if ( is_admin() || current_user_can('manage_options') )
			echo '<p>' . sprintf( __('<strong>RSS Error</strong>: %s'), $rss->get_error_message() ) . '</p>';

		return;
	}

	$default_args = array( 'show_author' => 0, 'show_date' => 0, 'show_summary' => 0 );
	$args = wp_parse_args( $args, $default_args );
	extract( $args, EXTR_SKIP );

	$items = (int) $items;
	if ( $items < 1 || 20 < $items )
		$items = 10;
	$show_summary  = (int) $show_summary;
	$show_author   = (int) $show_author;
	$show_date     = (int) $show_date;

	if ( !$rss->get_item_quantity() ) return;
	
	echo '<div class="nicholls-emergency-notice-wrapper"><div class="' . $alert_class . '">';
	
	echo '<h2>' . $alert_title . '</h2>';

	echo '<ul>';
	foreach ( $rss->get_items(0, $items) as $item ) {
		$link = $item->get_link();
		while ( stristr($link, 'http') != $link )
			$link = substr($link, 1);
		$link = esc_url(strip_tags($link));
		$title = esc_attr(strip_tags($item->get_title()));
		if ( empty($title) )
			$title = __('Untitled');

		$desc = str_replace(array("\n", "\r"), ' ', esc_attr(strip_tags(@html_entity_decode($item->get_description(), ENT_QUOTES, get_option('blog_charset')))));
		$desc = wp_html_excerpt( $desc, 360 ) . ' [&hellip;]';
		$desc = esc_html( $desc );

		if ( $show_summary ) {
			$summary = "<div class='rssSummary'>$desc</div>";
		} else {
			$summary = '';
		}

		$date = '';
		if ( $show_date ) {
			$date = $item->get_date();

			if ( $date ) {
				if ( $date_stamp = strtotime( $date ) )
					$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date_stamp ) . '</span>';
				else
					$date = '';
			}
		}

		$author = '';
		if ( $show_author ) {
			$author = $item->get_author();
			if ( is_object($author) ) {
				$author = $author->get_name();
				$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
			}
		}

		if ( $link == '' ) {
			echo "<li><strong>$title{$date}</strong>{$summary}{$author}</li>";
		} else {
			echo "<li><strong><a class='rsswidget' href='$link' title='$desc'>$title</a></strong>{$date}{$summary}{$author}</li>";
		}
	}
	echo '</ul>';
	if ( isset( $alert_notice ) ) echo '<p>' . $alert_notice . '</p>';
	echo '</div></div>';
	
}


function nicholls_emergency_notice_get() {

	$emergency_url_root = 'http://emergency.nicholls.edu';
	/* for Testing */
	// $emergency_url_root = 'http://work.funroe.net/wordpress/current-ms/nicholls-emergency'; 
	
	$emergency_site_notice = 'If the Nicholls website becomes unavailable, please visit <a href="http://emergency.nicholls.edu/">emergency.nicholls.edu</a> for important announcements.';
	
	emergency_rss_output( array(
		'url' => $emergency_url_root . '/category/notice/feed/',
		'alert_class' => 'web_notice',
		'alert_title' => 'Nicholls State University Notice:',
		'show_date' => false,
	) );
	
	emergency_rss_output( array(
		'url' => $emergency_url_root . '/category/alert/feed/',
		'alert_class' => 'alert',
		'alert_title' => 'Campus Alert:',
		'show_date' => true
	) );
	
	emergency_rss_output( array(
		'url' => $emergency_url_root . '/category/emergency/feed/',
		'alert_class' => 'emergency',
		'alert_title' => 'Campus Emergency Preparedness Notice:',
		'show_date' => true,
		'alert_notice' => $emergency_site_notice
	) );

}