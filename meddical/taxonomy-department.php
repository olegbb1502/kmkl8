<?php
/**
 * The template for displaying all pages
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
$tax_obj = get_queried_object();
$tax_id = $tax_obj->term_id;
$heroImage = get_field('department_image', $tax_obj);
$tax_terms = get_term_children($tax_id, 'department');
$accordion = get_field('accordion_shortcode', $tax_obj);
?>

	<div class="content-container">
        <div class="banner">
            <div class="background" style="background-image: url(<?php echo $heroImage; ?>)"></div>
            <div class="content">
                <?php
                    if ( function_exists( 'meddical_breadcrumbs' ) ) meddical_breadcrumbs('department');
                ?>
                <h1 class="title-main display1"><?php echo $tax_obj->name; ?></h1>
            </div>
        </div>
        <div class="content">
            <p class="description body">
                <?php echo $tax_obj->description; ?>
            </p>
            <?php
            if ($tax_terms): ?>
                <h2 class="title-main display2">Відділення</h2>
                <div class="specialists-grid cards-grid">
                    <?php 
                        foreach($tax_terms as $id){
                            $department = get_term_by('term_id', $id, 'department');
                            echo '<a href="'.get_term_link($department->slug, 'department').'" class="card" data-icon="'.get_theme_mod('meddical_service_icon').'">
                                <div class="icon-place"></div>
                                <p class="card-title body">'.$department->name.'</p>
                            </a>';
                        }
                    ?>
                </div>
            <?php endif; 
            if ($accordion): ?>
            <h2 class="title-main display2">Опис</h2>
            <?php 
                echo do_shortcode($accordion);
            endif;
            echo do_shortcode('[doctors department_id="'.$tax_id.'" type="carousel"]');
            ?>
            <?php
                $tax_terms[] = $tax_id;
                // $term_ids_to_find = array($tax_id);
                $post_args = array(
                    'post_type' => 'disease', // Replace with your custom post type slug
                    'posts_per_page' => -1, // Retrieve all posts
                    // 'tax_query' => array(
                    //     array(
                    //         'taxonomy' => 'department', // Replace with your taxonomy slug
                    //         'field' => 'term_id',
                    //         'terms' => $tax_id,
                    //     ),
                    // ),
                    'meta_query'     => array(
                        // array(
                        //     'key' => '_selected_departments',
                        //     'value' => $tax_id,
                        //     'compare' => 'LIKE',
                        // ),
                        array(
                            'key'     => '_selected_departments', // Replace with your metabox field name
                            'value'   => '"' . implode('|', array_map('preg_quote', $tax_terms)) . '"',
                            'compare' => 'REGEXP',
                        ),
                    ),
                );
            
                $query = new WP_Query($post_args);
            
                if ($query->have_posts()) {
                    echo '<h2>Послуги ' . $tax_obj->name . '</h2>';
                    echo '<div class="disease-grid cards-grid">';
            
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<a href="'.get_permalink().'" class="card" data-icon="'.get_theme_mod('meddical_disease_icon').'">
                            <div class="icon-place"></div>
                            <p class="card-title body">'.get_the_title().'</p>
                        </a>';
                    }
            
                    echo '</ul>';
                } else {
                    echo '<h2>Немає записів</h2>';
                }
            
                // wp_reset_postdata();
            ?>
        </div>
        <?php echo do_shortcode('[benefits]'); ?>

	</div><!-- #main -->

<?php
get_sidebar();
get_footer();
