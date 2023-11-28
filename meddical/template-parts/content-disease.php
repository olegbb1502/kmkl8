<?php
    $post_id = get_the_ID();

    // Replace 'your_meta_key' with the actual meta key you want to retrieve
    $meta_key = '_selected_departments';
    
    // Get the meta value for the current post
    $department_id = get_post_meta($post_id, $meta_key, true);

    $image = '';
    if (has_post_thumbnail( $department_id ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $department_id ), 'single-post-thumbnail' )[0]; 
    } else {
        $image = get_attachment_url_by_slug('hero');
    }
    ?>
    <div class="banner">
        <div class="background"  style="background-image: url(<?php echo $image; ?>)"></div>
        <div class="content">
            <?php
                if ( function_exists( 'meddical_breadcrumbs' ) ) meddical_breadcrumbs($department_id[0]);
            ?>
            <h1 class="title-main display1"><?php  echo get_the_title($post_id); ?></h1>
        </div>
        <div class="bottom-border"></div>
    </div>

    <div class="content-big">
    <?php the_content(); ?>
    <?php 
        echo do_shortcode('[doctors department_id="'.$department_id[0].'" type="carousel"]');
        echo do_shortcode('[benefits]');
        echo do_shortcode('[contacts]'); 
    ?>
    </div>