<?php
/**
 * Template Name: HomepageTemplate
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package meddical
 */

get_header();

$image = [''];
if (has_post_thumbnail( $post->ID ) ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
}

$headStufTaxonomy = get_term_by('slug', 'head-stuff', 'department');
$departments_config = array(
		'taxonomy' => 'department',
		'hide_empty' => false,
		'parent' => 0
);
if ($headStufTaxonomy) {
	array_push($departments_config, array(
		'exclude' => $headStufTaxonomy->term_id
	));
}
$departments = get_categories($departments_config);

$doctors = get_posts(array(
    'post_type' => 'doctor'
  ));

$customFields = get_fields(get_the_ID());
$heroBannerContent = $customFields['hero_banner_content'];
$welcomeContent = $customFields['welcome_block'];
$videosShortcode = $customFields['videos_shortcode'];
?>

    <div class="content-container big">
        <div class="hero-banner" style="background-image: url(<?php echo $image[0]; ?>)">
            <div class="content">
                <p class="top-caption caption"><?php echo $heroBannerContent['sub_title']; ?></p>
                <h2 class="title-main display1"><?php echo $heroBannerContent['main_title']; ?></h2>
                <a href="<?php echo $heroBannerContent['button_group']['button_link']; ?>" class="button empty button-text body"><?php echo $heroBannerContent['button_group']['button_text']; ?></a>
            </div>
        </div>
        <div class="short-description">
            <p class="top-caption caption">Вас вітає</p>
            <h1 class="title-main display1"><?php echo get_bloginfo('name'); ?></h1>
            <p class="description body"><?php echo $welcomeContent['description']; ?></p>
            <a href="<?php echo $welcomeContent['link']; ?>" class="button link button-text">Детальніше</a>
        </div>
        <?php echo do_shortcode('[benefits]'); ?>
        <div class="specialists" id="sevices">
            <p class="top-caption caption">Завжди раді допомогти</p>
            <h2 class="title-main title">Наші спеціалісти</h2>
            <div class="specialists-grid cards-grid">
                <?php 
                    foreach($departments as $department){
                        echo '<a href="'.get_term_link($department->slug, 'department').'" class="card" data-icon="'.get_theme_mod('meddical_service_icon').'">
                            <div class="icon-place"></div>
                            <p class="card-title body">'.$department->name.'</p>
                        </a>';
                    }
                ?>
            </div>
        </div>
        <!-- <div class="head-stuff">
            <?php //echo do_shortcode('[doctors type="carousel" limit="1"]'); ?>
        </div> -->
        <div class="videos">
            <?php echo do_shortcode($videosShortcode); ?>
        </div>
        <!-- <div class="comments">
            <h2 class="title-main title">Відгуки</h2>
            <div class="reviews text-cards-grid swiffy-slider slider-item-show3 slider-nav-round slider-nav-page">
                <div class="slider-container">
                    <div class="text-card">
                        <p class="body text">Lorem ipsum dolor sit amet, consectetur</p>
                        <p class="small">Ірина П.</p>
                    </div>
                    <div class="text-card">
                        <p class="body text">Lorem ipsum dolor sit amet, consectetur</p>
                        <p class="small">Кирил А.</p>
                    </div>
                    <div class="text-card">
                        <p class="body text">Lorem ipsum dolor sit amet, consectetur</p>
                        <p class="small">Євгенія Б.</p>
                    </div>
                </div>
            </div>
        </div> -->
        <?php echo do_shortcode('[contacts]'); ?>
    </div>

<?php
get_footer();

