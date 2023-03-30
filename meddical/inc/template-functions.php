<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package meddical
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

function meddical_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'meddical_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function meddical_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'meddical_pingback_header' );

/**
 * Add header widgets
 */
function meddical_register_widgets() {
	register_widget( MY_THEMESLUG.'_header_widget' );
}
add_action( 'widgets_init', MY_THEMESLUG.'_register_widgets' );

class meddical_header_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			// widget ID
			'mdcl_header_widget',
			// widget name
			__('Meddical header widget', MY_THEME_TEXTDOMAIN),
			array(
                'description' => __( 'Meddical header widget shows blocks with contacts in header', MY_THEME_TEXTDOMAIN ),
                'panels_icon' => 'dashicons dashicons-heading'
            )
		);
	}
	function widget($args, $instance) {
        echo $args['before_widget'];
		?>
		<img src="<?php echo $instance['image_url'] ?>" alt="<?php echo apply_filters('widget_title', $instance['title'] ); ?>">
		<div class="text button-text">
			<p><?php echo apply_filters('widget_title', $instance['title'] ); ?></p>
			<span>
			<?php 
				if (esc_url($instance['link'] )){
					echo '<a href="'.esc_url($instance['link']).'">'.apply_filters('widget_title', $instance['details']).'</a>';
				}
				else {
					echo apply_filters('widget_title', $instance['details']); 
				}
			?>
			</span>
		</div>
		<?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['link'] = strip_tags( $new_instance['link'] );
        $instance['details'] = strip_tags( $new_instance['details'] );
        $instance['image_url'] = strip_tags( $new_instance['image_url'] );
        return $instance;
    }

    function form($instance) {
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br />
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title'] ?? ''; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>">Link</label><br />
			<input type="text" name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>" value="<?php echo $instance['link'] ?? ''; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('details'); ?>">Details</label><br />
			<input type="text" name="<?php echo $this->get_field_name('details'); ?>" id="<?php echo $this->get_field_id('details'); ?>" value="<?php echo $instance['details'] ?? ''; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?= $this->get_field_id( 'image_url' ); ?>">Image</label>
			<img class="<?= $this->id ?>_img" src="<?php echo ((!empty($instance['image_url'])) ? $instance['image_url'] : ''); ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
			<input type="text" class="widefat <?= $this->id ?>_url" name="<?= $this->get_field_name( 'image_url' ); ?>" value="<?=  $instance['image_url'] ?>" style="margin-top:5px;" />
			<input type="button" id="<?= $this->id ?>" class="button js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
		</p>

	<?php
    }
}

// Enqueue additional admin scripts
add_action('admin_enqueue_scripts', MY_THEMESLUG.'_wdscript');
function meddical_wdscript() {
    wp_enqueue_media();
    wp_enqueue_script(MY_THEMESLUG.'_script', get_template_directory_uri() . '/js/widget.js', false, '1.0.0', true);
}

// Remove error for Big Images
add_filter( 'big_image_size_threshold', '__return_false' );