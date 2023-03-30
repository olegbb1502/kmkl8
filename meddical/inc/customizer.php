<?php
/**
 * meddical Theme Customizer
 *
 * @package meddical
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function meddical_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'meddical_customize_partial_blogname',
			)
		);
	}

	// Second logo
	$wp_customize->add_setting('mobile_logo');
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mobile_logo', array(
		'label'    => __('Mobile Logo', 'store-front'),
		'section'  => 'title_tagline',
		'settings' => 'mobile_logo',
		'priority'       => 5,
	)));

    //add panel
    $wp_customize->add_panel( MY_THEMESLUG . '_theme_options', array(
        'priority' => 2,
        'title' => __( 'Theme Options' , MY_THEME_TEXTDOMAIN ),
        'description' => '',
    ));

    //add footer section
    $wp_customize->add_section( MY_THEMESLUG . '_footer',  array(
        'title'    => __( 'Footer', MY_THEME_TEXTDOMAIN ),
        'priority' => 10,
        'panel' => MY_THEMESLUG . '_theme_options'
    ));

	//add contacts section
    $wp_customize->add_section( MY_THEMESLUG . '_contact',  array(
        'title'    => __( 'Contacts', MY_THEME_TEXTDOMAIN ),
        'priority' => 10,
        'panel' => MY_THEMESLUG . '_theme_options'
    ));

	//add contacts section
    $wp_customize->add_section( MY_THEMESLUG . '_global',  array(
        'title'    => __( 'Global', MY_THEME_TEXTDOMAIN ),
        'priority' => 10,
        'panel' => MY_THEMESLUG . '_theme_options'
    ));

	
	//add tagline settings
    $wp_customize->add_setting( MY_THEMESLUG . '_footer_tagline' );
    $wp_customize->add_control( MY_THEMESLUG . '_footer_tagline',  array(
        'type'     => 'text',
        'label'    => __( 'Tagline', MY_THEME_TEXTDOMAIN ),
        'section'  => MY_THEMESLUG . '_footer',
        'settings' => MY_THEMESLUG . '_footer_tagline'
    )); 

    //add copyright setting
    $wp_customize->add_setting( MY_THEMESLUG . '_footer_copyright' );
    $wp_customize->add_control( MY_THEMESLUG . '_footer_copyright',  array(
        'type'     => 'text',
        'label'    => __( 'Copyright', MY_THEME_TEXTDOMAIN ),
        'section'  => MY_THEMESLUG . '_footer',
        'settings' => MY_THEMESLUG . '_footer_copyright'
    ));   
	
    //add phone setting
    $wp_customize->add_setting( MY_THEMESLUG . '_contacts_phone' );
    $wp_customize->add_control( MY_THEMESLUG . '_contacts_phone',  array(
        'type'     => 'text',
        'label'    => __( 'Phone number', MY_THEME_TEXTDOMAIN ),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_phone'
    )); 

	// Phone icon
	$wp_customize->add_setting( MY_THEMESLUG . '_contacts_phone_icon' );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, MY_THEMESLUG.'_contacts_phone_icon', array(
		'label'    => __('Contact phone Icon', MY_THEME_TEXTDOMAIN),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_phone_icon'
	)));

    //add email setting
    $wp_customize->add_setting( MY_THEMESLUG . '_contacts_email' );
    $wp_customize->add_control( MY_THEMESLUG . '_contacts_email',  array(
        'type'     => 'text',
        'label'    => __( 'Email', MY_THEME_TEXTDOMAIN ),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_email'
    )); 

	// Phone icon
	$wp_customize->add_setting( MY_THEMESLUG . '_contacts_email_icon' );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, MY_THEMESLUG.'_contacts_email_icon', array(
		'label'    => __('Contact email Icon', MY_THEME_TEXTDOMAIN),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_email_icon'
	)));

    //add phone setting
    $wp_customize->add_setting( MY_THEMESLUG . '_contacts_location' );
    $wp_customize->add_control( MY_THEMESLUG . '_contacts_location',  array(
        'type'     => 'text',
        'label'    => __( 'Location address', MY_THEME_TEXTDOMAIN ),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_location'
    )); 

	// Phone icon
	$wp_customize->add_setting( MY_THEMESLUG . '_contacts_location_icon' );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, MY_THEMESLUG.'_contacts_location_icon', array(
		'label'    => __('Contact location Icon', MY_THEME_TEXTDOMAIN),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_location_icon'
	)));

    //add phone setting
    $wp_customize->add_setting( MY_THEMESLUG . '_contacts_works' );
    $wp_customize->add_control( MY_THEMESLUG . '_contacts_works',  array(
        'type'     => 'text',
        'label'    => __( 'Working Hours', MY_THEME_TEXTDOMAIN ),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_works'
    )); 

	// Phone icon
	$wp_customize->add_setting( MY_THEMESLUG . '_contacts_works_icon' );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, MY_THEMESLUG.'_contacts_works_icon', array(
		'label'    => __('Contact works Icon', MY_THEME_TEXTDOMAIN),
        'section'  => MY_THEMESLUG . '_contact',
        'settings' => MY_THEMESLUG . '_contacts_works_icon'
	)));

	// Global service icon
	$wp_customize->add_setting( MY_THEMESLUG . '_service_icon' );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, MY_THEMESLUG.'_service_icon', array(
		'label'    => __('Contact phone Icon', MY_THEME_TEXTDOMAIN),
        'section'  => MY_THEMESLUG . '_global',
        'settings' => MY_THEMESLUG . '_service_icon'
	)));
}
add_action( 'customize_register', 'meddical_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function meddical_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function meddical_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function meddical_customize_preview_js() {
	wp_enqueue_script( 'meddical-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'meddical_customize_preview_js' );
