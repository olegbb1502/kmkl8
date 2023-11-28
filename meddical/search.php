<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package meddical
 */

get_header();
?>

	<main id="primary" class="site-main content-container">

		<?php if ( have_posts() ) : ?>
			<div class="banner">
				<div class="background"  style="background-image: url(<?php echo get_attachment_url_by_slug('news-bg'); ?>)"></div>
				<div class="content">
					<h2 class="title-main display1"><?php  printf( esc_html__( 'Результат пошуку: %s', 'meddical' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				</div>
				<div class="bottom-border"></div>
			</div>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			// the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' ); ?>
			<?php 

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
