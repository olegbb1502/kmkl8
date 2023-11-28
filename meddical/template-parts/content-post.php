<?php

$image = get_the_post_thumbnail_url();
if (!$image) {
	$image = get_attachment_url_by_slug('no-pictures');
}
$title = get_the_title();
$prev_post = get_adjacent_post(false, '', true);
$next_post = get_adjacent_post(false, '', false);
?>
<div class="banner">
    <div class="background"  style="background-image: url(<?php echo get_attachment_url_by_slug('news-bg'); ?>)"></div>
    <div class="content">
        <?php if ( function_exists( 'meddical_breadcrumbs' ) ) meddical_breadcrumbs(); ?>
        <h2 class="title-main display1"><?php echo $title; ?></h2>
        <ul class="detail-row">
            <li class="detail">
                    <svg class="icon" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.2222 2.77783H2.77778C1.79594 2.77783 1 3.57377 1 4.55561V17.0001C1 17.9819 1.79594 18.7778 2.77778 18.7778H15.2222C16.2041 18.7778 17 17.9819 17 17.0001V4.55561C17 3.57377 16.2041 2.77783 15.2222 2.77783Z" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.5557 1V4.55556" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.44434 1V4.55556" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1 8.11108H17" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo get_the_date('D d, M Y'); ?></span>
            </li>
            <li class="detail">
                <svg class="icon" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 19V17C17 15.9391 16.5786 14.9217 15.8284 14.1716C15.0783 13.4214 14.0609 13 13 13H5C3.93913 13 2.92172 13.4214 2.17157 14.1716C1.42143 14.9217 1 15.9391 1 17V19" stroke="#159EEC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 9C11.2091 9 13 7.20914 13 5C13 2.79086 11.2091 1 9 1C6.79086 1 5 2.79086 5 5C5 7.20914 6.79086 9 9 9Z" stroke="#159EEC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>  
                <span>By <?php echo get_the_author(); ?></span>                          
            </li>
        </ul>
    </div>
    <div class="bottom-border"></div>
</div>
<div class="news-single news-content">
    <div class="news-details">
        <div class="post-image">
            <img src="<?php echo $image; ?>" alt="<?php  echo $title; ?>" />
        </div>
        <div class="content">
            <?php the_content(); ?>
        </div>
        <div class="post-navigation">
            <?php if (!empty($prev_post)): ?>
            <a href="<?php echo get_permalink($prev_post->ID); ?> " class="button icon button-text prev">Попередня новина</a>
            <?php endif; if (!empty($next_post)): ?>
            <a href="<?php echo get_permalink($next_post->ID); ?>" class="button icon button-text next">Наступна новина</a>
            <?php endif;?>
        </div>
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