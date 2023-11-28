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
?>
<div class="content-container social-media-page">
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
    <div class="grid">
        <?php
            $not_social_categories = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'term_id',
                        'terms'    => array(
                            get_term_by( 'slug', 'videos', 'category' )->term_id,
                            get_term_by( 'slug', 'publications', 'category' )->term_id,
                            get_term_by( 'slug', 'social-media-news', 'category' )->term_id
                        ),
                    ),
                ),
            );
            $all_posts = new WP_Query( $not_social_categories );                   
            if ( $all_posts->have_posts() ) {
                /* Start the Loop */
                while ( $all_posts->posts ) {
                    $all_posts->the_post();
                    $allClasses = get_post_class(); 
                    $classes = '';
                    foreach ($allClasses as $class) { $classes .= $class . " "; }
                    echo '<div id="post-'.get_the_ID().'" class="'.$classes.'news-card">
                        <div class="news-details">
                            <h2 class="title-main display1">'.get_the_title().'</h2>
                            <ul class="detail-row">
                                <li class="detail">
                                        <svg class="icon" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.2222 2.77783H2.77778C1.79594 2.77783 1 3.57377 1 4.55561V17.0001C1 17.9819 1.79594 18.7778 2.77778 18.7778H15.2222C16.2041 18.7778 17 17.9819 17 17.0001V4.55561C17 3.57377 16.2041 2.77783 15.2222 2.77783Z" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12.5557 1V4.55556" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.44434 1V4.55556" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M1 8.11108H17" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>'.get_the_date("D d, M Y").'</span>
                                </li>
                                <li class="detail">
                                    <svg class="icon" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 19V17C17 15.9391 16.5786 14.9217 15.8284 14.1716C15.0783 13.4214 14.0609 13 13 13H5C3.93913 13 2.92172 13.4214 2.17157 14.1716C1.42143 14.9217 1 15.9391 1 17V19" stroke="#159EEC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 9C11.2091 9 13 7.20914 13 5C13 2.79086 11.2091 1 9 1C6.79086 1 5 2.79086 5 5C5 7.20914 6.79086 9 9 9Z" stroke="#159EEC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>  
                                    <span>By '.get_the_author().'</span>                          
                                </li>
                            </ul>
                            <div class="content">
                                '.the_content().'
                            </div>
                        </div>
                    </div>';
                } 
            } else {
                get_template_part( 'content', 'none' );
            }
        ?>
    </div>
    <section class="posts-pagination"><?php echo paginate_links(); ?></section>
</div>