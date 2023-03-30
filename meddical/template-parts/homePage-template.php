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

$departments = get_categories([
    'taxonomy' => 'department',
    'hide_empty' => false,
    'exclude' => $headStufTaxonomy->term_id
]);

$headDoctors = get_posts(array(
    'post_type' => 'doctor',
    'numberposts' => 3,
    'tax_query' => array(
      array(
        'taxonomy' => 'department',
        'field' => 'term_id', 
        'terms' => $headStufTaxonomy->term_id,
        'include_children' => true
      )
    )
  ));

$customFields = get_fields(get_the_ID());
$heroBannerContent = $customFields['hero_banner_content'];
$welcomeContent = $customFields['welcome_block'];
$helsiContent = $customFields['helsi_block'];
?>

    <div class="contnet-container">
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
        <div class="about-picture helsi" style="background-image: url(<?php echo $helsiContent['background']; ?>)">
            <h2 class="title-main display1">Ми на плафтормі Helsi</h2>
            <a href="<?php echo $helsiContent['link']; ?>" class="button icon button-text">Детальніше</a>
            <div class="bottom-border"></div>
        </div>
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
        <div class="head-stuff">
            <h2 class="title-main display1">Наше керівництво</h2>
            <div class="big-cards-grid">
                <?php 
                    foreach($headDoctors as $doctor) {
                        $avatar = get_the_post_thumbnail_url($doctor->ID);
                        if ($avatar == '')  $avatar = 'http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536';
                        $name = $doctor->post_title;
                        if (in_array(MY_THEMESLUG.'doctor-position', get_post_custom($doctor->ID)))
                            $position = get_post_custom($doctor->ID)[MY_THEMESLUG.'doctor-position'][0];
                        else $position = '';
                        if (in_array(MY_THEMESLUG.'doctor-helsi', get_post_custom($doctor->ID)))
                            $helsi = get_post_custom($doctor->ID)[MY_THEMESLUG.'doctor-helsi'][0];
                        else $helsi = '#';
                        echo '
                        <div class="big-card doctor-card">
                            <img src="'.$avatar.'" alt="profile" class="photo" />
                            <div class="description">
                                <p class="name">'.$name.'</p>
                                <p class="position caption">'.$position.'</p>
                            </div>
                            <a href="'.$helsi.'" class="link" target="_blank">Переглянути профіль</a>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
        <!-- <div class="reviews text-cards-grid">
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
        </div> -->
        <?php echo do_shortcode('[contacts]'); ?>
    </div>

<?php
get_footer();

