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