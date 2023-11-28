<?php
function doctors_post_type() {
  
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Doctors', 'Post Type General Name', MY_THEME_TEXTDOMAIN ),
        'singular_name'       => _x( 'Doctor', 'Post Type Singular Name', MY_THEME_TEXTDOMAIN ),
        'menu_name'           => __( 'Doctors', MY_THEME_TEXTDOMAIN ),
        'parent_item_colon'   => __( 'Parent Doctor', MY_THEME_TEXTDOMAIN ),
        'all_items'           => __( 'All Doctors', MY_THEME_TEXTDOMAIN ),
        'view_item'           => __( 'View Doctor', MY_THEME_TEXTDOMAIN ),
        'add_new_item'        => __( 'Add New Doctor', MY_THEME_TEXTDOMAIN ),
        'add_new'             => __( 'Add New', MY_THEME_TEXTDOMAIN ),
        'edit_item'           => __( 'Edit Doctor', MY_THEME_TEXTDOMAIN ),
        'update_item'         => __( 'Update Doctor', MY_THEME_TEXTDOMAIN ),
        'search_items'        => __( 'Search Doctor', MY_THEME_TEXTDOMAIN ),
        'not_found'           => __( 'Not Found', MY_THEME_TEXTDOMAIN ),
        'not_found_in_trash'  => __( 'Not found in Trash', MY_THEME_TEXTDOMAIN ),
    );
          
    // Set other options for Custom Post Type
          
    $args = array(
        'label'               => __( 'doctors', MY_THEME_TEXTDOMAIN ),
        'description'         => __( 'Our doctors', MY_THEME_TEXTDOMAIN ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'thumbnail', 'revisions' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'position', 'department' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-businessman',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    
    );
        
    // Registering your Custom Post Type
    register_post_type( 'doctor', $args );
      
}
      
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
      
add_action( 'init', 'doctors_post_type', 0 );

function doctors_taxonomy() {
    register_taxonomy(
        'department',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'doctor',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Department', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'departments',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'doctors_taxonomy');

if ( !class_exists('myCustomFields') ) {
 
    class myCustomFields {
        /**
        * @var  string  $prefix  The prefix for storing custom fields in the postmeta table
        */
        var $prefix = MY_THEMESLUG;
        /**
        * @var  array  $postTypes  An array of public custom post types, plus the standard "post" and "page" - add the custom types you want to include here
        */
        var $postTypes = array( "page", "post", "doctor" );
        /**
        * @var  array  $customFields  Defines the custom fields available
        */
        var $customFields = array(
            array(
                "name"          => "doctor-position",
                "title"         => "Position",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "doctor" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "doctor-helsi",
                "title"         => "Helsi link",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "doctor" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "department-imgae",
                "title"         => "Department bg",
                "description"   => "",
                "type"          =>   "image",
                "scope"         =>   array( "doctor" ),
                "capability"    => "edit_posts"
            ),
        );
        /**
        * PHP 4 Compatible Constructor
        */
        function myCustomFields() { $this->__construct(); }
        /**
        * PHP 5 Constructor
        */
        function __construct() {
            add_action( 'admin_menu', array( $this, 'createCustomFields' ) );
            add_action( 'save_post', array( $this, 'saveCustomFields' ), 1, 2 );
            // Comment this line out if you want to keep default custom fields meta box
            add_action( 'do_meta_boxes', array( $this, 'removeDefaultCustomFields' ), 10, 3 );
        }
        /**
        * Remove the default Custom Fields meta box
        */
        function removeDefaultCustomFields( $type, $context, $post ) {
            foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
                foreach ( $this->postTypes as $postType ) {
                    remove_meta_box( 'postcustom', $postType, $context );
                }
            }
        }
        /**
        * Create the new Custom Fields meta box
        */
        function createCustomFields() {
            if ( function_exists( 'add_meta_box' ) ) {
                foreach ( $this->postTypes as $postType ) {
                    add_meta_box( 'my-custom-fields', 'Custom Fields', array( $this, 'displayCustomFields' ), $postType, 'normal', 'high' );
                }
            }
        }
        /**
        * Display the new Custom Fields meta box
        */
        function displayCustomFields() {
            global $post;
            ?>
            <div class="form-wrap">
                <?php
                wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
                foreach ( $this->customFields as $customField ) {
                    // Check scope
                    $scope = $customField[ 'scope' ];
                    $output = false;
                    foreach ( $scope as $scopeItem ) {
                        switch ( $scopeItem ) {
                            default: {
                                if ( $post->post_type == $scopeItem )
                                    $output = true;
                                break;
                            }
                        }
                        if ( $output ) break;
                    }
                    // Check capability
                    if ( !current_user_can( $customField['capability'], $post->ID ) )
                        $output = false;
                    // Output if allowed
                    if ( $output ) { ?>
                        <div class="form-field form-required">
                            <?php
                            switch ( $customField[ 'type' ] ) {
                                case "checkbox": {
                                    // Checkbox
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>&amp;nbsp;&amp;nbsp;';
                                    echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
                                    if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
                                        echo ' checked="checked"';
                                    echo '" style="width: auto;" />';
                                    break;
                                }
                                case "textarea":
                                case "wysiwyg": {
                                    // Text area
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
                                    echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
                                    // WYSIWYG
                                    if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
                                        <script type="text/javascript">
                                            jQuery( document ).ready( function() {
                                                jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
                                                if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
                                                    tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
                                                }
                                            });
                                        </script>
                                    <?php }
                                    break;
                                }
                                default: {
                                    // Plain text field
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
                                    echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
                                    break;
                                }
                            }
                            ?>
                            <?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
                        </div>
                    <?php
                    }
                } ?>
            </div>
            <?php
        }
        /**
        * Save the new Custom Fields values
        */
        function saveCustomFields( $post_id, $post ) {
            if ( !isset( $_POST[ 'my-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
                return;
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
            if ( ! in_array( $post->post_type, $this->postTypes ) )
                return;
            foreach ( $this->customFields as $customField ) {
                if ( current_user_can( $customField['capability'], $post_id ) ) {
                    if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
                        $value = $_POST[ $this->prefix . $customField['name'] ];
                        // Auto-paragraphs for any WYSIWYG
                        if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
                        update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
                    } else {
                        delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
                    }
                }
            }
        }
 
    } // End Class
 
} // End if class exists statement
 
// Instantiate the class
if ( class_exists('myCustomFields') ) {
    $myCustomFields_var = new myCustomFields();
}

// Doctor shortcode
function doctor_card_shortcode($atts) {
    $default = array(
        'avatar' => get_attachment_url_by_slug('profile'),
        'name' => '',
        'position' => '',
        'helsi' => '#',
    );
    $args = shortcode_atts($default, $atts);
    $avatar = $args['avatar'];
    $name = $args['name'];
    $position = $args['position'];
    $helsi = $args['helsi'];
    return '
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
add_shortcode('doctor-card', 'doctor_card_shortcode');

function doctors_carousel_shortcode($atts) {
    $default = array(
        'department_id' => '',
        'department_slug' => '',
        'limit' => -1,
        'type' => 'list',
        'orderby' => 'date',
        'order' => 'DESC',
        'title' => 'Лікарі'
    );
    $args = shortcode_atts($default, $atts);
    $taxonomy_filter = array();
    if (isset($atts['department_id'])) {
        $taxonomy_filter = array(
            'taxonomy' => 'department',
            'field' => 'term_id', 
            'terms' => $args['department_id'],
            'include_children' => false
        );
    } else if (isset($atts['department_slug'])) {
        $taxonomy_filter = array(
            'taxonomy' => 'department',
            'field' => 'slug', 
            'terms' => $args['department_slug'],
            'include_children' => false
        );
    }
    $doctors_query = array(
        'post_type' => 'doctor',
        'numberposts' => $args['limit'],
        'orderby' => $args['orderby'],
		'order' => $args['order'],
        'tax_query' => array()
    );
    if (count($taxonomy_filter) > 0) {
        array_push($doctors_query['tax_query'],
            array(
                $taxonomy_filter
            )
        );
    }
    $doctors = get_posts($doctors_query);
    if (count($doctors) > 0) {
        $container_class = "big-cards-grid";
        if ($args['type'] == 'carousel' && count($doctors) > 3) {
            $container_class = "swiffy-slider slider-item-show3 slider-nav-round slider-nav-page";
        }
        $result = '<div class="doctors-section">
        <h2 class="title-main display2">'.$args['title'].'</h2>
        <div class="'.$container_class.'">';
        if ($args['type'] == 'carousel' && count($doctors) > 3)
            $result .= '<div class="slider-container">';
        foreach($doctors as $doctor) {
            $name = $doctor->post_title;
            $post_custom = get_post_custom($doctor->ID);
            $short_code = '[doctor-card name="'.$name.'" ';
            if (get_the_post_thumbnail_url($doctor->ID)) {
                $short_code .= 'avatar="'.get_the_post_thumbnail_url($doctor->ID).'" ';
            }
            if (isset($post_custom[MY_THEMESLUG.'doctor-position']))
                $short_code .= 'position="'.$post_custom[MY_THEMESLUG.'doctor-position'][0].'" ';
            if(isset($post_custom[MY_THEMESLUG.'doctor-helsi']))
                $short_code .= 'helsi="'.$post_custom[MY_THEMESLUG.'doctor-helsi'][0].'" ';
            $short_code .= ']';
            $result .= do_shortcode($short_code);
        }
        if ($args['type'] == 'carousel') {
            $result .= '</div>';
            if (count($doctors) > 3) $result .= '
            <button type="button" class="slider-nav" aria-label="Go left"></button>
            <button type="button" class="slider-nav slider-nav-next" aria-label="Go left"></button>';
        }

        if ($args['type'] == 'carousel' && count($doctors) > 3) {
            $result .= '</div>';
        }
            
        $result .= '</div>';
        return $result;
    }
    return '';
}
add_shortcode('doctors', 'doctors_carousel_shortcode');
// End Doctor shortcode

// Connect disease with Department edit page
function display_connected_diseases_on_department_edit($term, $taxonomy) {
    // Check if the current taxonomy is 'department'
    if ($taxonomy !== 'department') {
        return;
    }

    // Get the term ID
    $term_id = $term->term_id;

    // Get all disease posts that have the current Department term in their selected_departments meta
    $disease_args = array(
        'post_type' => 'disease', // Replace with your custom post type slug
        'post_status' => 'publish',
        'posts_per_page' => -1, // Retrieve all disease posts
        'meta_query' => array(
            array(
                'key' => '_selected_departments',
                'value' => $term_id,
                'compare' => 'LIKE',
            ),
        ),
    );

    $disease_query = new WP_Query($disease_args);

    // Output the list of connected diseases
    echo '<tr class="form-field">';
    echo '<th scope="row" valign="top">Поєднанні хвороби</th>';
    echo '<td>';

    if ($disease_query->have_posts()) {
        echo '<ul style="marging: 0">';
        while ($disease_query->have_posts()) {
            $disease_query->the_post();
            $disease_title = get_the_title();
            $disease_edit_link = get_edit_post_link();
            echo '<li><a href="' . esc_url($disease_edit_link) . '" target="_blank">' . esc_html($disease_title) . '</a></li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo 'Жодної приєднаної хвороби.';
    }

    echo '</td>';
    echo '</tr>';
}

add_action('department_edit_form_fields', 'display_connected_diseases_on_department_edit', 10, 2);

// End Connect disease with Department edit page