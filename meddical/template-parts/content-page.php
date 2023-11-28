<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package meddical
 */

global $wp_query; 
$post_id = $wp_query->get_queried_object_id();

$image = '';
if (has_post_thumbnail( $post_id ) ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' )[0]; 
} else {
    $image = get_attachment_url_by_slug('hero');
}
?>
<div class="banner">
	<div class="background"  style="background-image: url(<?php echo $image; ?>)"></div>
	<div class="content">
		<?php
			if ( function_exists( 'meddical_breadcrumbs' ) ) meddical_breadcrumbs();
		?>
		<h2 class="title-main display1"><?php  echo get_the_title($post_id); ?></h2>
	</div>
	<div class="bottom-border"></div>
</div>
<div class="entry-content">
	<?php
	the_content();

	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'meddical' ),
			'after'  => '</div>',
		)
	);
	?>
</div><!-- .entry-content -->
