<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package meddical
 */
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
?>
	<footer>
        <div class="footer-top">
            <div class="col">
			<a href="<?php echo get_home_url(); ?>" class="logo">
                <img src="<?php echo $logo_image; ?>" alt="kmkl">
            </a>
                <p class="footer-strong">
					<?php 
					echo get_theme_mod( "meddical_footer_tagline" );
					?>
				</p>
            </div>
            <div class="col">
				<?php 
					if ( is_active_sidebar( 'footer-col-2' ) ) {
						dynamic_sidebar( 'footer-col-2' ); 
					}
				?>
			</div>
            <div class="col">
                <p class="footer-strong caption">Конаткти</p>
                <ul class="list">
                    <li>Телефон: <a href="tel:<?php echo get_theme_mod( "meddical_contacts_phone" );?>"><?php echo get_theme_mod( "meddical_contacts_phone" );?></a></li>
                    <li>Електрона пошта: <a href="mailto:<?php echo get_theme_mod( "meddical_contacts_email" );?>"><?php echo get_theme_mod( "meddical_contacts_email" );?></a></li>
                    <li>Адреса: <?php echo get_theme_mod( "meddical_contacts_location" );?></li>
                    <li>Україна</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="reserved">©<?php echo date("Y").' '.get_theme_mod('meddical_footer_copyright'); ?></p>
            <!-- <div class="social-networks">
                <a href="#"><img src="/assets/fb.svg" alt="FB"></a>
                <a href="#"><img src="/assets/inst.svg" alt="Instagram"></a>
            </div> -->

			<?php if ( is_active_sidebar( 'footer-social' ) ) {
						dynamic_sidebar( 'footer-social' ); 
				}
			?>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

