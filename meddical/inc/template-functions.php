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

function meddical_hook_global_vars_css() {
    echo '
	<style>
		:root {
			--primary: '.get_theme_mod( MY_THEMESLUG . '_theme_color_primary' ).';
			--secondary: '.get_theme_mod( MY_THEMESLUG . '_theme_color_secondary' ).';
			--accent: '.get_theme_mod( MY_THEMESLUG . '_theme_color_accent' ).';
			--black: '.get_theme_mod( MY_THEMESLUG . '_theme_color_black' ).';
			--white: '.get_theme_mod( MY_THEMESLUG . '_theme_color_white' ).';
			}
	</style>';
}
add_action('wp_head', 'meddical_hook_global_vars_css');

function meddical_breadcrumbs() {
	$args = func_get_args();

	/* === ОПЦИИ === */
	$text['home']     = 'Головна'; // текст ссылки "Главная"
	$text['category'] = '%s'; // текст для страницы рубрики
	$text['search']   = 'Результати пошуку: "%s"'; // текст для страницы с результатами поиска
	$text['tag']      = 'Записи з тегом "%s"'; // текст для страницы тега
	$text['author']   = 'Статті автора %s'; // текст для страницы автора
	$text['404']      = 'Помилка 404'; // текст для страницы 404
	$text['page']     = 'Сторінка %s'; // текст 'Страница N'
	$text['cpage']    = 'Сторінка коментарів %s'; // текст 'Страница комментариев N'

	$wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
	$wrap_after     = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
	$sep            = '<span class="breadcrumbs__separator"> › </span>'; // разделитель между "крошками"
	$before         = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
	$after          = '</span>'; // тег после текущей "крошки"

	$show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
	$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
	$show_current   = 1; // 1 - показывать название текущей страницы, 0 - не показывать
	$show_last_sep  = 1; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
	/* === КОНЕЦ ОПЦИЙ === */

	global $post;
	$home_url       = home_url('/');
	$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link          .= '<meta itemprop="position" content="%3$s" />';
	$link          .= '</span>';
	$parent_id      = ( $post ) ? $post->post_parent : '';
	$home_link      = sprintf( $link, $home_url, $text['home'], 1 );


	$current_obj = get_queried_object();

	if ( is_home() || is_front_page()) {

		if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;
		else echo $wrap_before . $home_link . $sep . $before . $current_obj->post_title . $after . $wrap_after;

	} elseif ( is_404() ) {

		echo $wrap_before;

		if ( $show_home_link ) {
			echo $home_link;
		}
		if ( $show_home_link && $show_current ) echo $sep;
		if ( $show_current ) echo $before . $text['404'] . $after;
		elseif ( $show_last_sep ) echo $sep;

		echo $wrap_after;
	}  else {
		if (!empty($current_obj)) {
			$current_id = $current_obj->ID;
			$current_type = $current_obj->post_type;
		}

		$position = 0;

		echo $wrap_before;

		if ( $show_home_link ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() || is_tax() ) {
			$current_cats = get_queried_object()->slug;
			$query_vars = $current_id;
			$parents = get_ancestors( $query_vars, $current_cats );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_term( $cat )->name, $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat = get_query_var('cat');
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					if (get_queried_object()->taxonomy == 'category') echo sprintf( $link, get_permalink( get_option('page_for_posts', true) ), get_the_title( get_option('page_for_posts', true) ), $position ) . $sep;
					if (get_queried_object()->taxonomy == 'department') echo $before . 'Відділення' . $after . $sep;
					echo $before . single_cat_title( '', false ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) echo $sep;
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_time('Y') . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_month() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_day() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_single($current_id) && !is_attachment($current_id) ) {
			if ( get_post_type() != 'post') {
				$position += 1;
				$post_type = get_post_type_object( get_post_type() );
				$department_id = $args[0];
				if ( $position > 1 ) echo $sep;
				if ($department_id) {
					$term_name = get_term( $department_id )->name;
					// echo get_term_link( $department_id ).' '.$term_name;
					echo sprintf( $link, get_category_link( $department_id ), $term_name, $position );
				} else {
					echo sprintf( $link, get_permalink( get_option('page_for_posts', true) ), get_the_title( get_option('page_for_posts', true) ), $position ) . $sep;
				}
					
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} else {
				$cat = get_the_category(); $catID = $cat[0]->cat_ID;
				$parents = get_ancestors( $catID, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current ) echo $sep . $before . get_the_title() . $after;
					elseif ( $show_last_sep ) echo $sep;
				}
			}

		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . $post_type->label . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_attachment() ) {
			$parent = get_post( $parent_id );
			$cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
			$parents = get_ancestors( $catID, 'category' );
			$parents = array_reverse( $parents );
			$parents[] = $catID;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( (is_page($current_id) || $current_type == 'page') && !$parent_id ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_title() . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( (is_page($current_id) || $current_type == 'page') && $parent_id ) {
			$parents = get_post_ancestors( $current_id );
			foreach ( array_reverse( $parents ) as $pageID ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
			}
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tagID = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			echo get_post_format_string( get_post_format() );
		} else {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_title($current_id) . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;
		}

		echo $wrap_after;

	}
} // end of meddical_breadcrumbs()

function meddical_benefits_section() {
	return '<div class="benefits-section" id="benefits">
		<h2 class="title-main display1">Наші переваги</h2>
		<div class="detail-cards-grid">
			<div class="detail-card center">
				<p class="caption card-title">+30</p>
				<p class="details body">років досвіду</p>                    
			</div>
			<div class="detail-card center">
				<p class="caption card-title">+50 000</p>
				<p class="details body">Операцій</p>                    
			</div>
			<div class="detail-card center">
				<p class="caption card-title">+600 000</p>
				<p class="details body">Пацієнтів</p>                    
			</div>
		</div>
	</div>';
}

add_shortcode('benefits', 'meddical_benefits_section');