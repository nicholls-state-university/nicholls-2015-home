<?php
/**
* Home Template
*
* Template for front page or home page.
*
* @package Nicholls 2010 Home Theme
* @subpackage Template
*/

// Slider is Active
global $j_flex_active;
$j_flex_active = true;

/** 
* Nicholls Theme Home init action
*
* Initialize the home.php template display differently for this view
*
*/
function nicholls_theme_home_init_action() {
	// Remove Standard header
	remove_action( 'fnbx_header', 'fnbx_default_title' );
	remove_action( 'fnbx_header', 'fnbx_default_description' );
	
	// Google Webmaster Tools verification
	add_action( 'fnbx_wp_head_before', 'nicholls_theme_home_google_verify' );
	
	// Remove standard widgets for home
	if ( is_front_page() ) {
		remove_action( 'fnbx_container_end', 'fnbx_default_widget_sidebar' );
		add_action( 'fnbx_wp_head_after', 'nicholls_google_analytics' );
	}
}
add_action( 'fnbx_child_init', 'nicholls_theme_home_init_action' );

/** 
* Nicholls Theme Home init action
*
* Initialize the home.php template display differently for this view
*
*/
function nicholls_theme_home_google_verify() {
	echo '<meta name="google-site-verification" content="m8Cj8r6-iwttNBQu4C-KGyXG13dMjahXqtU-LG0NT6c" />';
}

/** 
* Nicholls Theme Home Home Widget Sidebar
*
* Display the Home Special sidebar widget on the home.php template.
*
*/
function nicholls_home_widget_sidebar() {
	fnbx_generate_widgets( 'Home Special' );
}

/** 
* Reset RSS Cache for emergency.nicholls.edu
*
* This needs to be automated somehow on emergeny.nicholls.edu to reset the cache on nicholls.edu. 
* URI to reset cache: http://www.nicholls.edu/?rss_reset=yes
* See $page_message for notification message.
*
*/
function nicholls_reset_feed_cache( $timer ) {
	return 1;
}

// Do the cache emergency reset.
$reset_nonce = $_REQUEST['_wpnonce'];
if ( wp_verify_nonce( $reset_nonce, 'emergency_reset') ) {
	if ( $_GET['emergency_reset'] == 'yes' ) {
		global $file_prefix;
		add_filter( 'wp_feed_cache_transient_lifetime', 'nicholls_reset_feed_cache' );
		if ( function_exists( 'wp_cache_clean_cache' ) )
			wp_cache_clean_cache($file_prefix);
		$page_message = '<p style="margin: .5em; padding: 2em; background: yellow; font-size: 140%; font-weight: bold;">Website Home Page Reset!</p>';
	}
}

?>

<?php get_header() ?>

		<!-- START: template_home -->
		<?php do_action( 'fnbx_template_home_start', 'template_home' ) ?> 
		
		<?php do_action( 'fnbx_template_home_end', 'template_home' ) ?>
		<!-- END: template_home -->
		
<?php 
// Display Cache Reset Message
echo $page_message; 
?>

<?php get_sidebar() ?>

	<?php do_action( 'nicholls_template_home_start', 'nicholls_template_home' ) ?><!-- START: funroe_template_home -->

		<?php fnbx_layout_element_open( 'home-column-a' ) ?>

			<?php do_action( 'nicholls_theme_home_column_a') ?>
			
		<?php fnbx_layout_element_close( 'home-column-a' ) ?>
		
		<?php fnbx_layout_element_open( 'home-column-b' ) ?>

			<?php do_action( 'nicholls_theme_home_column_b') ?>
			
		<?php fnbx_layout_element_close( 'home-column-b' ) ?>		

	<?php do_action( 'nicholls_template_home_end', 'nicholls_template_home' ) ?><!-- END: funroe_template_home -->
		
<?php get_footer() ?>
