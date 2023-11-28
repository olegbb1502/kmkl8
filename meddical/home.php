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
	<div class="content-container home blog">
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
        <div class="news-content">
            <div class="news-list">
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
                            if (! is_home()){
							    get_template_part( 'template-parts/content', get_post_type() );
                            } else {
                                get_template_part( 'template-parts/content-blog', get_post_type() );
                            }

						endwhile;

						// the_posts_navigation();
                        echo '<div class="posts-pagination">'.paginate_links().'</div>';

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
            </div>
            <div class="news-sidebar">
                <?php get_search_form(); ?>
                <div class="categories-block">
                    <div class="block-title">
                        <h3 class="category-title display2"><?php echo __( 'Категорії', 'meddical' ); ?></h3>
                        <div class="mobile-switcher mobile">
                            <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.9465 0.34977C14.1728 0.125697 14.4784 0 14.7969 0C15.1153 0 15.4209 0.125697 15.6472 0.34977C15.759 0.459802 15.8477 0.590958 15.9082 0.735605C15.9688 0.880251 16 1.0355 16 1.19231C16 1.34913 15.9688 1.50437 15.9082 1.64902C15.8477 1.79367 15.759 1.92482 15.6472 2.03485L8.85124 8.6952C8.62442 8.91896 8.31862 9.04442 8 9.04442C7.68138 9.04442 7.37558 8.91896 7.14876 8.6952L0.352777 2.03485C0.241047 1.92482 0.152318 1.79367 0.0917536 1.64902C0.0311894 1.50437 0 1.34913 0 1.19231C0 1.0355 0.0311894 0.880251 0.0917536 0.735605C0.152318 0.590958 0.241047 0.459802 0.352777 0.34977C0.57908 0.125697 0.884678 0 1.20315 0C1.52161 0 1.82721 0.125697 2.05351 0.34977L8.00261 5.81195L13.9465 0.34977Z" style="fill: var(--accent);" />
                            </svg>
                        </div>
                    </div>
                    <?php
                        get_template_part( 'template-parts/content', 'post-sidebar' );
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
