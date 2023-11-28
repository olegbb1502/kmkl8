<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package meddical
 */

$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
	<link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous">
	<script>
        window.addEventListener('load', () => {
            //loads all sliders in main and skip header and footer search for increased init performance.
            swiffyslider.init();
        });
    </script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header>
        <div class="header-top">
            <a href="<?php echo get_home_url(); ?>" class="logo desktop">
                <img src="<?php echo $logo_image; ?>" alt="kmkl">
            </a>
			<div class="contacts">
				<ul>
					<?php if ( is_active_sidebar( 'header-top' ) ) {
						dynamic_sidebar( 'header-top' ); 
					}
					?>
				</ul>
			</div>
        </div>
        <div class="header-bottom <?php if (is_admin_bar_showing()) echo 'is-admin'; ?>">
            <a href="<?php echo get_home_url(); ?>" class="logo mobile">
                <img src="<?php echo $logo_image; ?>" alt="kmkl">
            </a>
            <nav class="main-nav">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu',
						'menu_id'        => 'primary-menu',
					)
				);
			?>
            </nav>
            <div class="mobile-button mobile">
                <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg" id="mobile-open">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24 15.0001V17.4001H0V15.0001H24ZM24 7.8001V10.2001H0V7.8001H24ZM24 0.600098V3.0001H0V0.600098H24Z" fill="#FCFEFE"/>
                </svg>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" id="mobile-close">
                    <path d="M12.4948 10L19.478 3.01684C19.8094 2.68601 19.9958 2.23707 19.9962 1.76879C19.9966 1.3005 19.811 0.851233 19.4802 0.519814C19.1494 0.188395 18.7004 0.00197318 18.2321 0.00155962C17.7638 0.00114607 17.3146 0.186774 16.9832 0.517609L10 7.50077L3.01684 0.517609C2.68542 0.18619 2.23592 0 1.76723 0C1.29853 0 0.849028 0.18619 0.517609 0.517609C0.18619 0.849028 0 1.29853 0 1.76723C0 2.23592 0.18619 2.68542 0.517609 3.01684L7.50077 10L0.517609 16.9832C0.18619 17.3146 0 17.7641 0 18.2328C0 18.7015 0.18619 19.151 0.517609 19.4824C0.849028 19.8138 1.29853 20 1.76723 20C2.23592 20 2.68542 19.8138 3.01684 19.4824L10 12.4992L16.9832 19.4824C17.3146 19.8138 17.7641 20 18.2328 20C18.7015 20 19.151 19.8138 19.4824 19.4824C19.8138 19.151 20 18.7015 20 18.2328C20 17.7641 19.8138 17.3146 19.4824 16.9832L12.4948 10Z" fill="white"/>
                </svg>    
            </div>
        </div>
        <div class="move-to-top">
            <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.05351 8.69463C1.82721 8.91871 1.52161 9.0444 1.20315 9.0444C0.884678 9.0444 0.57908 8.91871 0.352777 8.69463C0.241047 8.5846 0.152317 8.45344 0.091753 8.3088C0.031189 8.16415 0 8.0089 0 7.85209C0 7.69528 0.031189 7.54003 0.091753 7.39538C0.152317 7.25074 0.241047 7.11958 0.352777 7.00955L7.14876 0.349204C7.37558 0.125442 7.68138 -1.33514e-05 8 -1.33514e-05C8.31862 -1.33514e-05 8.62442 0.125442 8.85124 0.349204L15.6472 7.00955C15.759 7.11958 15.8477 7.25074 15.9082 7.39538C15.9688 7.54003 16 7.69528 16 7.85209C16 8.0089 15.9688 8.16415 15.9082 8.3088C15.8477 8.45344 15.759 8.5846 15.6472 8.69463C15.4209 8.91871 15.1153 9.0444 14.7969 9.0444C14.4784 9.0444 14.1728 8.91871 13.9465 8.69463L7.99739 3.23246L2.05351 8.69463Z" fill="#BFD2F8"/>
            </svg>                
        </div>
    </header><!-- #masthead -->
