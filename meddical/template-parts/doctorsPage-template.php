<?php
/**
 * Template Name: DoctorsPage
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

$image = '';
if (has_post_thumbnail( $post->ID ) ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0]; 
} else {
    $image = get_attachment_url_by_slug('profile');
}

$excluded_ids = get_term_by('slug', 'head-stuff', 'department')->term_id;
$taxonomies = get_categories([
    'taxonomy' => ['department'],
    'hide_empty' => false,
    'exclude' => $excluded_ids,
    'parent' => 0
]);

$taxonomyTerms = [];

// loop over your taxonomies
foreach ($taxonomies as $term)
{
  // retrieve all available terms, including those not yet used
  if ($term->term_id != $excluded_ids) {
    array_push($taxonomyTerms, array('id'=>$term->term_id, 'name'=>$term->name));
  }
}
?>

    <div class="content-container big">
        <div class="banner">
            <div class="background" style="background-image: url(<?php echo $image; ?>)"></div>
            <div class="content">
                <p class="top-caption caption">Вас вітають наші</p>
                <h1 class="title-main display1">Лікарі</h1>
            </div>
        </div>
        <div class="short-description">
            <?php echo get_post_field('post_content', $post->ID);
        ?>
        </div>
        <?php foreach($taxonomyTerms as $term)
                echo do_shortcode('[doctors type="list" title="'.$term['name'].'" department_id="'.$term['id'].'"]'); ?>
    </div>
</div>

<?php
get_footer();
?>