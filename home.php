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
		// add_action( 'fnbx_wp_head_after', 'nicholls_google_analytics' );
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
	
	<div id="nicholls-home-list-container" class="nicholls-home-list-container-">
		<ul id="nicholls-home-list" class="nicholls-home-list-">
			<li id="nicholls-home-list-apply" class="nicholls-home-list-item nicholls-home-list-apply-"><a class="nicholls-home-list-item-link nicholls-home-apply-link-" href="">Apply Now</a></li>
			<li id="nicholls-home-list-calendar" class="nicholls-home-list-item nicholls-home-list-calendar-"><a class="nicholls-home-list-item-link nicholls-home-calendar-link-" href="">Calendar</a></li>
			<li id="nicholls-home-list-majors" class="nicholls-home-list-item nicholls-home-list-majors-"><a class="nicholls-home-list-item-link nicholls-home-majors-link-" href="">Majors &amp; Academics</a></li>
			<li id="nicholls-home-list-tour" class="nicholls-home-list-item nicholls-home-list-tour-"><a class="nicholls-home-list-item-link nicholls-home-tour-link-" href="">Schedule A Tour</a></li>
			<li id="nicholls-home-list-finaid" class="nicholls-home-list-item nicholls-home-list-finaid-"><a class="nicholls-home-list-item-link nicholls-home-finaid-link-" href="">Financial Aid</a></li>
			<li id="nicholls-home-list-explore" class="nicholls-home-list-item nicholls-home-list-explore-"><a class="nicholls-home-list-item-link nicholls-home-expore-link-" href="">Expore Nicholls</a></li>
			<li id="nicholls-home-list-social" class="nicholls-home-list-item nicholls-home-list-social-"><a class="nicholls-home-list-item-link nicholls-home-social-link-" href="">Social Media</a></li>
		</ul>
	</div>

		<?php fnbx_layout_element_open( 'home-column-a' ) ?>

			<?php do_action( 'nicholls_theme_home_column_a') ?>
			
		<?php fnbx_layout_element_close( 'home-column-a' ) ?>
		
		<?php fnbx_layout_element_open( 'home-column-b' ) ?>

			<?php do_action( 'nicholls_theme_home_column_b') ?>
			
		<?php fnbx_layout_element_close( 'home-column-b' ) ?>		

	<?php do_action( 'nicholls_template_home_end', 'nicholls_template_home' ) ?><!-- END: funroe_template_home -->
		
<?php get_footer() ?>
