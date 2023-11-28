<?php
function social_media_news_post_type() {
  
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Ми в ЗМІ', 'Post Type General Name', MY_THEME_TEXTDOMAIN ),
        'singular_name'       => _x( 'Запис', 'Post Type Singular Name', MY_THEME_TEXTDOMAIN ),
        'menu_name'           => __( 'Ми в ЗМІ', MY_THEME_TEXTDOMAIN ),
        'parent_item_colon'   => __( 'Батьківський запис', MY_THEME_TEXTDOMAIN ),
        'all_items'           => __( 'Всі записи', MY_THEME_TEXTDOMAIN ),
        'view_item'           => __( 'Переглянути запис', MY_THEME_TEXTDOMAIN ),
        'add_new_item'        => __( 'Новий запис', MY_THEME_TEXTDOMAIN ),
        'add_new'             => __( 'Додати новий', MY_THEME_TEXTDOMAIN ),
        'edit_item'           => __( 'Редагувати запис', MY_THEME_TEXTDOMAIN ),
        'update_item'         => __( 'Оновити', MY_THEME_TEXTDOMAIN ),
        'search_items'        => __( 'Пошук', MY_THEME_TEXTDOMAIN ),
        'not_found'           => __( 'Not Found', MY_THEME_TEXTDOMAIN ),
        'not_found_in_trash'  => __( 'Not found in Trash', MY_THEME_TEXTDOMAIN ),
    );
          
    // Set other options for Custom Post Type
          
    $args = array(
        'label'               => __( 'social_media_news', MY_THEME_TEXTDOMAIN ),
        'description'         => __( 'Ми в ЗМІ', MY_THEME_TEXTDOMAIN ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'social' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-playlist-video',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    
    );
        
    // Registering your Custom Post Type
    register_post_type( 'social_media_news', $args );
      
}
      
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
      
add_action( 'init', 'social_media_news_post_type', 0 );

function social_media_news_taxonomy() {
    register_taxonomy(
        'social',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'social_media_news',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Ми в ЗМІ: Категорія', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'social-media',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'social_media_news_taxonomy');