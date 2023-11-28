<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

get_header();
?>
	<div class="content-container">
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
        <?php
            if ( have_posts() ) :

                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /*
                    * Include the Post-Type-specific template for the content.
                    * If you want to override this in a child theme, then include a file
                    * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                    */
                    get_template_part( 'template-parts/content', get_post_type() );

                endwhile;

                // the_posts_navigation();
                echo '<div class="posts-pagination">'.paginate_links().'</div>';

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
        ?>
    </div>

<?php
get_footer();
