<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package meddical
 */

$image = get_the_post_thumbnail_url();
if (!$image) {
	$image = get_attachment_url_by_slug('no-pictures');
}
$title = get_the_title();
$content = wp_trim_words(get_the_content(), 30, '...');
?>

<div id="post-<?php the_ID(); ?>" class="<?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>news-card">
	<div class="post-image">
		<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
	</div>
	<ul class="detail-row">
		<li class="detail">
				<svg class="icon" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.2222 2.77783H2.77778C1.79594 2.77783 1 3.57377 1 4.55561V17.0001C1 17.9819 1.79594 18.7778 2.77778 18.7778H15.2222C16.2041 18.7778 17 17.9819 17 17.0001V4.55561C17 3.57377 16.2041 2.77783 15.2222 2.77783Z" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M12.5557 1V4.55556" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M5.44434 1V4.55556" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M1 8.11108H17" stroke="#1F2B6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span><?php echo get_the_date('D d, M Y'); ?></span>
		</li>
		<li class="detail">
			<svg class="icon" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M17 19V17C17 15.9391 16.5786 14.9217 15.8284 14.1716C15.0783 13.4214 14.0609 13 13 13H5C3.93913 13 2.92172 13.4214 2.17157 14.1716C1.42143 14.9217 1 15.9391 1 17V19" stroke="#159EEC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M9 9C11.2091 9 13 7.20914 13 5C13 2.79086 11.2091 1 9 1C6.79086 1 5 2.79086 5 5C5 7.20914 6.79086 9 9 9Z" stroke="#159EEC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>  
			<span>By <?php echo get_the_author(); ?></span>                          
		</li>
	</ul>
	<h3 class="news-title display2"><?php echo $title; ?></h3>
	<p class="short-content"><?php echo $content; ?></p>
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="button icon button-text">Читати далі</a>
</div>