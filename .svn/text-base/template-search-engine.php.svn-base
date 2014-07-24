<?php
/*
Template Name: Search Engine - Google Hosted
*/

// Filter to clear out sidebar widgets to make full page
add_action( 'fnbx_child_init', 'nicholls_template_core_full_page');

// Move the titles around - from nicholls_move_title()
function nicholls_move_search_title() {
	// Website Title
	remove_action( 'fnbx_header', 'fnbx_default_title' );
	// Website Description
	remove_action( 'fnbx_header', 'fnbx_default_description' );
	// Entry title
	remove_action( 'fnbx_template_loop_entry_title', 'fnbx_entry_title' );
	// Move the entry-title
	add_action( 'fnbx_header', 'fnbx_entry_title' );
}
add_action( 'fnbx_child_init', 'nicholls_move_search_title');

function nicholls_google_search_engine_js() {
?>
<script>
  (function() {
    var cx = '000006858127128462850:olq8lufqhkm';
    var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
  })();
</script>
<?php
}
add_action( 'fnbx_wp_head_after', 'nicholls_google_search_engine_js');


?>

<?php get_header() ?>

		<?php do_action( 'fnbx_template_page_start', 'template_page' ) ?><!-- START: template_page -->

		<!-- START: Loop Template Part -->
		<?php do_action( "fnbx_template_loop_start", $fnbx->template_part_name  ) ?>
		<?php do_action( "fnbx_template_loop_{$fnbx->template_part_name}_start", $fnbx->template_part_name ) ?>
		
		<?php fnbx_post_navigation_box_auto( 'above' ); ?>
					
		<?php while ( have_posts() ) : the_post() ?>
		
			<!-- START: post -->
			<?php do_action( 'fnbx_template_loop_post_start', fnbx_get_the_id() ) ?>
			<?php do_action( "fnbx_template_loop_{$fnbx->template_part_name}_post_start", fnbx_get_the_id() ) ?>
		
				<?php do_action( 'fnbx_template_loop_entry_title', fnbx_get_the_id() ) ?>
					
				<!-- START: entry-content -->
				<?php do_action( 'fnbx_template_loop_content_start', 'entry-content' ) ?>
				<?php do_action( "fnbx_template_loop_content_{$fnbx->template_part_name}_start", 'entry-content'  ) ?>
					
					<?php the_content( __( 'Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'fnbx_lang' ) ); ?>
					
		<form method="get" id="searchform" action="<?php echo esc_url( get_permalink() ); ?>">
			<label for="s" class="assistive-text"><?php _e( 'Search', 'nicholls_theme_core' ); ?></label>
			<input type="text" class="field" name="q" id="q" placeholder="<?php esc_attr_e( 'Search', 'nicholls_theme_core' ); ?>" />
			<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'nicholls_theme_core' ); ?>" />
		</form>
		

		<!-- Place this tag where you want the search results to render -->
		<gcse:searchresults-only></gcse:searchresults-only> 
					
				<?php do_action( "fnbx_template_loop_content_{$fnbx->template_part_name}_end", 'entry-content'  ) ?>
				<?php do_action( 'fnbx_template_loop_content_end', 'entry-content' ) ?>
				<!-- END: entry-content -->
					
			
			<?php do_action( "fnbx_template_loop_{$fnbx->template_part_name}_post_end", fnbx_get_the_id() ) ?>		
			<?php do_action( 'fnbx_template_loop_post_end', fnbx_get_the_id() ) ?>
			<!-- END: post -->
		
		<?php endwhile; ?>
		
		<?php /* Show next & previous navigation when applicable */ ?>
		<?php fnbx_post_navigation_box_auto( 'below' ); ?>
		
		<?php do_action( "fnbx_template_loop_{$fnbx->template_part_name}_end", $fnbx->template_part_name ) ?>
		<?php do_action( "fnbx_template_loop_end", $fnbx->template_part_name  ) ?>
		<!-- END: Loop Template Part -->

		<?php do_action( 'fnbx_template_page_end', 'template_page' ) ?><!-- END: template_page -->

<?php get_sidebar() ?>

<?php get_footer() ?>