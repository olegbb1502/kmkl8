<?php
function disease_post_type() {
  
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Disease', 'Post Type General Name', MY_THEME_TEXTDOMAIN ),
        'singular_name'       => _x( 'Disease', 'Post Type Singular Name', MY_THEME_TEXTDOMAIN ),
        'menu_name'           => __( 'Diseases', MY_THEME_TEXTDOMAIN ),
        'parent_item_colon'   => __( 'Parent Disease', MY_THEME_TEXTDOMAIN ),
        'all_items'           => __( 'All Diseases', MY_THEME_TEXTDOMAIN ),
        'view_item'           => __( 'View Disease', MY_THEME_TEXTDOMAIN ),
        'add_new_item'        => __( 'Add New Disease', MY_THEME_TEXTDOMAIN ),
        'add_new'             => __( 'Add New', MY_THEME_TEXTDOMAIN ),
        'edit_item'           => __( 'Edit Disease', MY_THEME_TEXTDOMAIN ),
        'update_item'         => __( 'Update Disease', MY_THEME_TEXTDOMAIN ),
        'search_items'        => __( 'Search Disease', MY_THEME_TEXTDOMAIN ),
        'not_found'           => __( 'Not Found', MY_THEME_TEXTDOMAIN ),
        'not_found_in_trash'  => __( 'Not found in Trash', MY_THEME_TEXTDOMAIN ),
    );
          
    // Set other options for Custom Post Type
          
    $args = array(
        'label'               => __( 'disease', MY_THEME_TEXTDOMAIN ),
        'description'         => __( 'Disease description', MY_THEME_TEXTDOMAIN ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'thumbnail', 'editor' ),
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
    register_post_type( 'disease', $args );

    register_taxonomy_for_object_type('department', 'disease');
      
}
      
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
      
add_action( 'init', 'disease_post_type', 0 );

function department_meta_box() {
    add_meta_box(
        'disease_departments',
        'Departments',
        'display_department_meta_box',
        'disease', // Replace with your custom post type slug
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'department_meta_box');

function display_department_meta_box($post) {
    // Retrieve the selected departments for the current post
    $selected_departments = get_post_meta($post->ID, '_selected_departments', true);

    // Query to get the list of departments (adjust as needed)
    $departments = get_terms('department', array(
        'hide_empty' => false,
    ));

    echo '<label for="departments">Select Departments:</label><br>';
    
    foreach ($departments as $department) {
        if ($selected_departments) {
            $checked = in_array($department->term_id, $selected_departments) ? 'checked' : '';
        } else {
            $checked = '';
        }
        
        echo '<input type="checkbox" name="selected_departments[]" value="' . $department->term_id . '" ' . $checked . '> ' . $department->name . '<br>';
    }
}

function save_department_selection($post_id) {
    if (defined('DOING_AUTOSAVE')) return;

    if (isset($_POST['selected_departments'])) {
        $selected_departments = $_POST['selected_departments'];
        update_post_meta($post_id, '_selected_departments', $selected_departments);
    } else {
        delete_post_meta($post_id, '_selected_departments');
    }
}
add_action('save_post', 'save_department_selection');
