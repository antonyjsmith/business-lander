<?php
/**
 * Business-lander Theme Customizer
 *
 * @package business-lander
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function business_lander_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Remove header image section.
	$wp_customize->remove_section( 'header_image' );

	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Add theme options panel.
	$wp_customize->add_panel( 'business-lander', array(
		'title' => esc_html__( 'Theme Options', 'business-lander' ),
	) );

	/**
	 * Contact Info.
	 */
	$wp_customize->add_section( 'header_contact', array(
		'title'       => esc_html__( 'Contact Info', 'business-lander' ),
		'panel'       => 'business-lander',
		'description' => esc_html__( 'Display your location, phone and email.', 'business-lander' ),
	) );

	$wp_customize->add_setting( 'header_address', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'header_address', array(
		'label'   => esc_html__( 'Address', 'business-lander' ),
		'section' => 'header_contact',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'header_phone', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'header_phone', array(
		'label'   => esc_html__( 'Phone', 'business-lander' ),
		'section' => 'header_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'header_email', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'header_email', array(
		'label'   => esc_html__( 'Email', 'business-lander' ),
		'section' => 'header_contact',
		'type'    => 'text',
	) );

	/**
	 * Contact section.
	 */
	$wp_customize->add_section( 'homepage', array(
		'title'       => esc_html__( 'Home Page', 'business-lander' ),
		'panel'       => 'business-lander',
	) );

	$wp_customize->add_setting( 'contact_form', array(
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'contact_form', array(
		'label'   => esc_html__( 'Contact Form ', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'dropdown-pages',
	) );

	/**
	 * Services section.
	 */

	$wp_customize->add_setting( 'services_section_title', array(
		'default'           => esc_html__( 'Services', 'business-lander' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'services_section_title', array(
		'label'   => esc_html__( 'Services Title', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'text',
	) );

	for ( $i = 1; $i <= 3; $i ++ ) {
		$wp_customize->add_setting( 'front_page_services_' . $i, array(
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'front_page_services_' . $i, array(
			'label'   => esc_html__( 'Service Page ', 'business-lander' ) . $i,
			'section' => 'homepage',
			'type'    => 'dropdown-pages',
		) );
		$wp_customize->selective_refresh->add_partial( 'front_page_services_' . $i, array(
			'selector'            => '.section--services',
			'container_inclusive' => true,
			'render_callback'     => 'business-lander_refresh_services_section',
		) );
	}

	/**
	 * Featured page 1 section.
	 */

	$wp_customize->add_setting( 'featured_page_1', array(
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'featured_page_1', array(
		'label'   => esc_html__( 'Featured Page', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'dropdown-pages',
	) );
	$wp_customize->selective_refresh->add_partial( 'featured_page_1', array(
		'selector'            => '.featured-page-1',
		'container_inclusive' => true,
		'render_callback'     => 'business-lander_refresh_services_section',
	) );

	/**
	 * Feature page 2 section.
	 */

	$wp_customize->add_setting( 'featured_page_2', array(
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'featured_page_2', array(
		'label'   => esc_html__( 'Featured Page', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'dropdown-pages',
	) );
	$wp_customize->selective_refresh->add_partial( 'featured_page_2', array(
		'selector'            => '.featured-page-2',
		'container_inclusive' => true,
		'render_callback'     => 'business-lander_refresh_services_section',
	) );

	/**
	 * Testimonial section.
	 */
	$testimonial_bg_default = get_template_directory_uri() . '/images/bg-tess.png';

	$wp_customize->add_setting( 'testimonial_section_img', array(
		'sanitize_callback' => 'business_lander_sanitize_image',
		'default'           => $testimonial_bg_default,
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'testimonial_section',
			array(
				'label'       => esc_html__( 'Background Image', 'business-lander' ),
				'section'     => 'homepage',
				'description' => esc_html__( 'Choose the testimonial section background', 'business-lander' ),
				'settings'    => 'testimonial_section_img',
			)
		)
	);

	/**
	 * Featured page 3 section.
	 */

	$wp_customize->add_setting( 'featured_page_3', array(
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'featured_page_3', array(
		'label'   => esc_html__( 'Featured Page', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'dropdown-pages',
	) );
	$wp_customize->selective_refresh->add_partial( 'featured_page_3', array(
		'selector'            => '.featured-page-3',
		'container_inclusive' => true,
		'render_callback'     => 'business-lander_refresh_services_section',
	) );

	/**
	 * CTA section.
	 */

	// Call to action title.
	$wp_customize->add_setting( 'cta_title', array(
		'default'           => wp_kses_post( __( 'Expect the extraordinary', 'business-lander' ) ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'cta_title', array(
		'label'   => esc_html__( 'Call To Action Title', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'textarea',
	) );

	// Call to action text.
	$wp_customize->add_setting( 'cta_text', array(
		'default'           => wp_kses_post( __( 'We are A Team of Experts', 'business-lander' ) ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'cta_text', array(
		'label'   => esc_html__( 'Call To Action Text', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'textarea',
	) );

	// Call to action links.
	$wp_customize->add_setting( 'cta_button_text', array(
		'default'           => esc_html__( 'contact us', 'business-lander' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'cta_button_text', array(
		'label'   => esc_html__( 'Call To Action Link Text', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'cta_button_url', array(
		'default'           => esc_url( 'https://gretathemes.com/' ),
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'cta_button_url', array(
		'label'   => esc_html__( 'Call To Action Link URL', 'business-lander' ),
		'section' => 'homepage',
		'type'    => 'text',
	) );

	// Call to action background.
	$wp_customize->add_setting( 'cta_background', array(
		'sanitize_callback' => 'business_lander_sanitize_image',
		'default'           => get_template_directory_uri() . '/images/bg-cta.jpg',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'cta_section',
			array(
				'label'    => esc_html__( 'Call To Action Backround Image', 'business-lander' ),
				'section'  => 'homepage',
				'settings' => 'cta_background',
			)
		)
	);

	/**
	 * Blog.
	 */
	$wp_customize->add_section( 'blog', array(
		'title' => esc_html__( 'Blog', 'business-lander' ),
		'panel' => 'business-lander',
	) );

	$wp_customize->add_setting( 'blog_style', array(
		'capability'        => 'edit_theme_options',
		'default'           => 'grid',
		'sanitize_callback' => 'business_lander_sanitize_radio',
	) );

	$wp_customize->add_control( 'blog_style', array(
		'type'        => 'radio',
		'section'     => 'blog',
		'label'       => __( 'Blog Style', 'business-lander' ),
		'description' => __( 'Choose how to display posts in the blog.', 'business-lander' ),
		'choices'     => array(
			'grid' => __( 'Grid', 'business-lander' ),
			'list' => __( 'List', 'business-lander' ),
		),
	) );
}

add_action( 'customize_register', 'business_lander_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function business_lander_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function business_lander_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function business_lander_customize_preview_js() {
	wp_enqueue_script( 'business-lander-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'business_lander_customize_preview_js' );

/**
 * Sanitizes Image Upload.
 *
 * @param string $input potentially dangerous data.
 *
 * @return string
 */
function business_lander_sanitize_image( $input ) {
	$filetype = wp_check_filetype( $input );
	if ( $filetype['ext'] && wp_ext2type( $filetype['ext'] ) === 'image' ) {
		return esc_url( $input );
	}

	return '';
}

/**
 * Sanitize radio choices.
 *
 * @param string $input choice slug.
 * @param WP_Customize_Setting $setting Setting instance.
 *
 * @return string User choices; otherwise, the setting default.
 */
function business_lander_sanitize_radio( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function businesslander_customize_preview_js() {
	wp_enqueue_script( 'business_lander_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20180426', true );
}

add_action( 'customize_preview_init', 'businesslander_customize_preview_js' );
