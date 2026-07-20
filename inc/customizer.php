<?php


function rs_madrasha_customize_register($wp_customize){

    /*==============================
        TOP BAR
    ==============================*/
    $wp_customize->add_section('rs_topbar', array(
        'title'       => __('Top Bar', 'rs-madrasha'),
        'priority'    => 10,
        'description' => __('Manage Top Bar Content', 'rs-madrasha'),
    ));

    // Madrasah Code
    $wp_customize->add_setting('rs_madrasah_code', array(
        'default'           => '১১১১২',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_madrasah_code', array(
        'label'   => __('Madrasah Code', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'text',
    ));

    // EIIN
    $wp_customize->add_setting('rs_eiin', array(
        'default'           => '136452',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_eiin', array(
        'label'   => __('EIIN Number', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'text',
    ));

    // Button Text
    $wp_customize->add_setting('rs_apply_button_text', array(
        'default'           => 'অনলাইন আবেদন',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_apply_button_text', array(
        'label'   => __('Application Button Text', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'text',
    ));

    /*==============================
        APPLICATION 1
    ==============================*/

    $wp_customize->add_setting('rs_apply1_text', array(
        'default'           => 'দাখিল ভর্তি আবেদন',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_apply1_text', array(
        'label'   => __('Application 1 Text', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_apply1_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_apply1_url', array(
        'label'   => __('Application 1 URL', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'url',
    ));

    /*==============================
        APPLICATION 2
    ==============================*/

    $wp_customize->add_setting('rs_apply2_text', array(
        'default'           => 'আলিম ভর্তি আবেদন',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_apply2_text', array(
        'label'   => __('Application 2 Text', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_apply2_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_apply2_url', array(
        'label'   => __('Application 2 URL', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'url',
    ));

    /*==============================
        APPLICATION 3
    ==============================*/

    $wp_customize->add_setting('rs_apply3_text', array(
        'default'           => 'কামিল ভর্তি আবেদন',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_apply3_text', array(
        'label'   => __('Application 3 Text', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_apply3_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_apply3_url', array(
        'label'   => __('Application 3 URL', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'url',
    ));

    /*==============================
        SHOW CLOCK
    ==============================*/

    $wp_customize->add_setting('rs_show_clock', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('rs_show_clock', array(
        'label'   => __('Show Live Clock', 'rs-madrasha'),
        'section' => 'rs_topbar',
        'type'    => 'checkbox',
    ));

}

add_action('customize_register', 'rs_madrasha_customize_register');




function rs_header_customizer($wp_customize){

    $wp_customize->add_section('rs_site_header', array(
        'title'       => __('Site Header', 'rs-madrasha'),
        'priority'    => 20,
        'description' => __('Header Settings', 'rs-madrasha'),
    ));

    // Logo
    $wp_customize->add_setting('rs_header_logo', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'rs_header_logo',
            array(
                'label'     => __('Header Logo', 'rs-madrasha'),
                'section'   => 'rs_site_header',
                'mime_type' => 'image',
            )
        )
    );

    // Arabic Title
    $wp_customize->add_setting('rs_header_arabic', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_header_arabic', array(
        'label'   => __('Arabic Title', 'rs-madrasha'),
        'section' => 'rs_site_header',
        'type'    => 'text',
    ));

    // Bangla Title
    $wp_customize->add_setting('rs_header_bangla', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_header_bangla', array(
        'label'   => __('Bangla Title', 'rs-madrasha'),
        'section' => 'rs_site_header',
        'type'    => 'text',
    ));

    // English Title
    $wp_customize->add_setting('rs_header_english', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_header_english', array(
        'label'   => __('English Title', 'rs-madrasha'),
        'section' => 'rs_site_header',
        'type'    => 'text',
    ));

    // Right Banner
    $wp_customize->add_setting('rs_header_banner', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'rs_header_banner',
            array(
                'label'     => __('Header Banner', 'rs-madrasha'),
                'section'   => 'rs_site_header',
                'mime_type' => 'image',
            )
        )
    );

}




add_action('customize_register', 'rs_header_customizer');

// footer customizer 


function rs_footer_customizer($wp_customize){

    /*=========================================
        Footer Section
    =========================================*/
    $wp_customize->add_section('rs_footer', array(
        'title'       => __('Footer Settings', 'rs-madrasha'),
        'priority'    => 90,
        'description' => __('Footer Content Settings', 'rs-madrasha'),
    ));

    /*==============================
        Footer Logo
    ==============================*/

    $wp_customize->add_setting('rs_footer_logo', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'rs_footer_logo',
            array(
                'label'     => __('Footer Logo', 'rs-madrasha'),
                'section'   => 'rs_footer',
                'mime_type' => 'image',
            )
        )
    );

    /*==============================
        Institution Name
    ==============================*/

    $wp_customize->add_setting('rs_footer_name', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_name', array(
        'label'   => __('Institution Name', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    /*==============================
        Address
    ==============================*/

    $wp_customize->add_setting('rs_footer_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_address', array(
        'label'   => __('Address', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'textarea',
    ));

    /*==============================
        Phone
    ==============================*/

    $wp_customize->add_setting('rs_footer_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_phone', array(
        'label'   => __('Phone Number', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    /*==============================
        Email
    ==============================*/

    $wp_customize->add_setting('rs_footer_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('rs_footer_email', array(
        'label'   => __('Email', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'email',
    ));

    /*==============================
        Website
    ==============================*/

    $wp_customize->add_setting('rs_footer_website', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_website', array(
        'label'   => __('Website URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'url',
    ));

    /*=========================================
        IMPORTANT LINKS
    =========================================*/

    $wp_customize->add_setting('rs_footer_links_heading', array(
        'default'           => 'গুরুত্বপূর্ণ লিংকসমূহ',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_links_heading', array(
        'label'   => __('Important Links Heading', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    /*========== Link 1 ==========*/

    $wp_customize->add_setting('rs_footer_link1_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_link1_text', array(
        'label' => __('Link 1 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    $wp_customize->add_setting('rs_footer_link1_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_link1_url', array(
        'label' => __('Link 1 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'url',
    ));

    /*========== Link 2 ==========*/

    $wp_customize->add_setting('rs_footer_link2_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_link2_text', array(
        'label' => __('Link 2 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    $wp_customize->add_setting('rs_footer_link2_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_link2_url', array(
        'label' => __('Link 2 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'url',
    ));

    /*========== Link 3 ==========*/

    $wp_customize->add_setting('rs_footer_link3_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_link3_text', array(
        'label' => __('Link 3 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    $wp_customize->add_setting('rs_footer_link3_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_link3_url', array(
        'label' => __('Link 3 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'url',
    ));

    /*========== Link 4 ==========*/

    $wp_customize->add_setting('rs_footer_link4_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_link4_text', array(
        'label' => __('Link 4 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    $wp_customize->add_setting('rs_footer_link4_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_link4_url', array(
        'label' => __('Link 4 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'url',
    ));

    /*=========================================
        FOOTER PAGES
    =========================================*/

    // Pages Heading
    $wp_customize->add_setting('rs_footer_pages_heading', array(
        'default'           => 'পেইজ সমূহ',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_pages_heading', array(
        'label'   => __('Pages Heading', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    /*==============================
        Page 1
    ==============================*/

    $wp_customize->add_setting('rs_footer_page1_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_page1_text', array(
        'label'   => __('Page 1 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_footer_page1_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_page1_url', array(
        'label'   => __('Page 1 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'url',
    ));

    /*==============================
        Page 2
    ==============================*/

    $wp_customize->add_setting('rs_footer_page2_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_page2_text', array(
        'label'   => __('Page 2 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_footer_page2_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_page2_url', array(
        'label'   => __('Page 2 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'url',
    ));

    /*==============================
        Page 3
    ==============================*/

    $wp_customize->add_setting('rs_footer_page3_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_page3_text', array(
        'label'   => __('Page 3 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_footer_page3_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_page3_url', array(
        'label'   => __('Page 3 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'url',
    ));

    /*==============================
        Page 4
    ==============================*/

    $wp_customize->add_setting('rs_footer_page4_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_page4_text', array(
        'label'   => __('Page 4 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_footer_page4_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_page4_url', array(
        'label'   => __('Page 4 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'url',
    ));

    /*==============================
        Page 5
    ==============================*/

    $wp_customize->add_setting('rs_footer_page5_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_page5_text', array(
        'label'   => __('Page 5 Text', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('rs_footer_page5_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_page5_url', array(
        'label'   => __('Page 5 URL', 'rs-madrasha'),
        'section' => 'rs_footer',
        'type'    => 'url',
    ));

    /*=========================================
        FACEBOOK SECTION
    =========================================*/

    // Facebook Title
    $wp_customize->add_setting('rs_footer_fb_title', array(
        'default' => 'কাউনিয়া বালিকা ফাজিল',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_fb_title', array(
        'label' => __('Facebook Title','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    // Followers
    $wp_customize->add_setting('rs_footer_fb_followers', array(
        'default' => '৮৩,৭৩৫ Followers',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_fb_followers', array(
        'label' => __('Followers Text','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    // Facebook URL
    $wp_customize->add_setting('rs_footer_fb_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_fb_url', array(
        'label' => __('Facebook URL','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'url',
    ));

    // Follow Button
    $wp_customize->add_setting('rs_footer_follow_btn', array(
        'default' => 'Follow Page',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_follow_btn', array(
        'label' => __('Follow Button Text','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    // Share Button
    $wp_customize->add_setting('rs_footer_share_btn', array(
        'default' => 'Share',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_share_btn', array(
        'label' => __('Share Button Text','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    /*=========================================
        COPYRIGHT
    =========================================*/

    // Copyright
    $wp_customize->add_setting('rs_footer_copyright', array(
        'default' => 'Copyright © 2025, All Rights Reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_copyright', array(
        'label' => __('Copyright Text','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'textarea',
    ));

    // Technical Support
    $wp_customize->add_setting('rs_footer_support_text', array(
        'default' => 'Technical Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_support_text', array(
        'label' => __('Support Text','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    // Support Name
    $wp_customize->add_setting('rs_footer_support_name', array(
        'default' => 'Rukunujjaman',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_footer_support_name', array(
        'label' => __('Support Name','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'text',
    ));

    // Support URL
    $wp_customize->add_setting('rs_footer_support_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('rs_footer_support_url', array(
        'label' => __('Support URL','rs-madrasha'),
        'section' => 'rs_footer',
        'type' => 'url',
    ));

}
add_action('customize_register', 'rs_footer_customizer');

// home about section customizer


function rs_home_about_customizer($wp_customize){

    /*=========================================
        Home About Section
    =========================================*/

    $wp_customize->add_section('rs_home_about', array(
        'title'       => __('Home Page About', 'rs-madrasha'),
        'priority'    => 30,
        'description' => __('Home About Section Settings', 'rs-madrasha'),
    ));

    /*-------------------------
        Title
    -------------------------*/

    $wp_customize->add_setting('rs_home_about_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_home_about_title', array(
        'label'   => __('Section Title', 'rs-madrasha'),
        'section' => 'rs_home_about',
        'type'    => 'text',
    ));

    /*-------------------------
        Description
    -------------------------*/

    $wp_customize->add_setting('rs_home_about_description', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('rs_home_about_description', array(
        'label'   => __('Short Description', 'rs-madrasha'),
        'section' => 'rs_home_about',
        'type'    => 'textarea',
    ));

    /*-------------------------
        Long Description
    -------------------------*/

    $wp_customize->add_setting('rs_home_about_more', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('rs_home_about_more', array(
        'label'   => __('Long Description', 'rs-madrasha'),
        'section' => 'rs_home_about',
        'type'    => 'textarea',
    ));

    /*-------------------------
        Read More Button
    -------------------------*/

    $wp_customize->add_setting('rs_home_about_btn', array(
        'default'           => 'আরও পড়ুন',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('rs_home_about_btn', array(
        'label'   => __('Read More Button Text', 'rs-madrasha'),
        'section' => 'rs_home_about',
        'type'    => 'text',
    ));

}

add_action('customize_register', 'rs_home_about_customizer');


/**
 * ==========================================================
 * PRINCIPAL CARD — Customizer Settings
 * A single, fixed info block (not repeatable), so Customizer
 * fields are used — same pattern as the Footer settings.
 * ==========================================================
 */

function rs_principal_card_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_principal_card', array(
        'title'    => __( 'Principal Card', 'rs-madrasha' ),
        'priority' => 96,
    ) );

    /*==============================
        Principal Photo
    ==============================*/
    $wp_customize->add_setting( 'rs_principal_photo', array(
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'rs_principal_photo',
            array(
                'label'     => __( 'Principal Photo', 'rs-madrasha' ),
                'section'   => 'rs_principal_card',
                'mime_type' => 'image',
            )
        )
    );

    /*==============================
        Badge / Designation Label
    ==============================*/
    $wp_customize->add_setting( 'rs_principal_badge', array(
        'default'           => 'প্রতিষ্ঠাতা অধ্যক্ষ',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_principal_badge', array(
        'label'   => __( 'Badge Text', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'text',
    ) );

    /*==============================
        Principal Name
    ==============================*/
    $wp_customize->add_setting( 'rs_principal_name', array(
        'default'           => 'মাওলানা মোহাম্মদ আমির হোসেন তালুকদার',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_principal_name', array(
        'label'   => __( 'Principal Name', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'text',
    ) );

    /*==============================
        Qualification
    ==============================*/
    $wp_customize->add_setting( 'rs_principal_qualification', array(
        'default'           => 'কামিল (হাদিস, তাফসীর) ১ম শ্রেণি; দাওরায়ে হাদিস-১ম শ্রেণি; এম.এ, বি.এড-১ম শ্রেণি',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_principal_qualification', array(
        'label'   => __( 'Qualification', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'textarea',
    ) );

    /*==============================
        Button Text
    ==============================*/
    $wp_customize->add_setting( 'rs_principal_btn_text', array(
        'default'           => 'অধ্যক্ষের বাণী পড়ুন »',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_principal_btn_text', array(
        'label'   => __( 'Button Text', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'text',
    ) );

    /*==============================
        Button URL
    ==============================*/
    $wp_customize->add_setting( 'rs_principal_btn_url', array(
        'default'           => '#principal-speech',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'rs_principal_btn_url', array(
        'label'   => __( 'Button URL', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'url',
    ) );

    /*==============================================
        PRINCIPAL'S SPEECH (full "অধ্যক্ষের কথা" block)
        Reuses rs_principal_photo, rs_principal_name,
        rs_principal_badge from above for the photo/name/
        designation shown beside the speech.
    ==============================================*/

    // Institution Name (line under designation)
    $wp_customize->add_setting( 'rs_principal_institution', array(
        'default'           => 'কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদরাসা',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_principal_institution', array(
        'label'   => __( 'Institution Name (under photo)', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'text',
    ) );

    // Address (line under institution name)
    $wp_customize->add_setting( 'rs_principal_address', array(
        'default'           => 'বরিশাল-৮২০০',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_principal_address', array(
        'label'   => __( 'Address (under institution name)', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'text',
    ) );

    // Speech Body (multiple paragraphs — one blank line = new paragraph)
    $wp_customize->add_setting( 'rs_principal_speech', array(
        'default'           => "সমস্ত প্রশংসা মহান আল্লাহ তায়ালার, দরুদ ও সালাম বিশ্বনবী হযরত মুহাম্মদ (স.) ও তাঁর আল আসহাব, আহালদের প্রতি। বর্তমান বিশ্বে যুগের চাহিদা অনুযায়ী ইসলামী শিক্ষার সাথে আধুনিক শিক্ষার সমন্বয় সাধন করা অপরিহার্য। মাতা-পিতা হচ্ছেন সন্তানের প্রাথমিক আদর্শ শিক্ষক ও ভালো মানুষ হওয়ার প্রেরণা এবং শিক্ষক হচ্ছেন জাতির কর্ণধার। একজন ভালো শিক্ষার্থীকে তিন ব্যক্তিত্বের সমন্বয়ে দেশ ও জাতির কল্যাণে আত্মোৎসর্গ করাই হবে তার প্রকৃত লক্ষ্য।\n\nআমাদের সন্তান আদর্শ নাগরিক তথা বিশ্বনাগরিক হয়ে মানুষ হওয়ার নজির স্থাপন করবে বলে আমি দৃঢ় বিশ্বাস করি। তাই বর্তমান সময়ের দাবি ও চাহিদা অনুযায়ী তাদের আরবি, ইংরেজি, গণিত, বিজ্ঞান ও তথ্যপ্রযুক্তি বিষয়ে যুগোপযোগী জ্ঞান অর্জন করে পৃথিবীর বিশাল জনগোষ্ঠির মধ্যে শীর্ষে উপনীত হওয়ার দৃঢ় প্রত্যয় থাকতে হবে। প্রকৃত ইসলামী শিক্ষাই নারী জাতির অধিকার, মর্যাদা ও আদর্শের দাবি।\n\nআধুনিক ও যুগোপযোগী শিক্ষার ধারা অব্যাহত রেখে সর্বোচ্চ নৈতিকতা সম্পন্ন দক্ষ মানব সম্পদ তৈরি করাই আমাদের অন্যতম উদ্দেশ্য। আজকের শিশুরা ভবিষ্যতে দেশ ও জাতি গড়ার পথ প্রদর্শক হবে বলে আমি বিশ্বাস করি। এ জন্য মহান আল্লাহর নিকট আমাদের দোয়া করতে হবে এই বলে —",
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'rs_principal_speech', array(
        'label'       => __( 'Speech Body', 'rs-madrasha' ),
        'description' => __( 'Leave a blank line between paragraphs — each will become its own paragraph on the site.', 'rs-madrasha' ),
        'section'     => 'rs_principal_card',
        'type'        => 'textarea',
    ) );

    // Closing Quote (styled with the orange left-border block)
    $wp_customize->add_setting( 'rs_principal_quote', array(
        'default'           => 'হে আমার রব, আমার অন্তর খুলে দিন, আমার কাজ আমার জন্য সহজ করে দিন এবং আমার জবানের সকল জড়তা দূর করে দিন। যেন মানুষেরা আমার কথা বুঝতে পারে। আমীন।',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'rs_principal_quote', array(
        'label'   => __( 'Closing Quote', 'rs-madrasha' ),
        'section' => 'rs_principal_card',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'rs_principal_card_customizer' );


// Mission & Vision Section — Customizer Settings
 
function rs_mission_vision_customizer( $wp_customize ) {
 
    $wp_customize->add_section( 'rs_mission_vision', array(
        'title'    => __( 'Mission & Vision Section', 'rs-madrasha' ),
        'priority' => 97,
    ) );
 
    /*==============================
        Section Title
    ==============================*/
    $wp_customize->add_setting( 'rs_mv_title', array(
        'default'           => 'লক্ষ্য ও উদ্দেশ্য',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
 
    $wp_customize->add_control( 'rs_mv_title', array(
        'label'   => __( 'Section Title', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'text',
    ) );
 
    /*==============================
        Tab 1 — Mission (লক্ষ্য)
    ==============================*/
    $wp_customize->add_setting( 'rs_mv_mission_label', array(
        'default'           => 'লক্ষ্য',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_mv_mission_label', array(
        'label'   => __( 'Tab 1 — Label', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'text',
    ) );
 
    $wp_customize->add_setting( 'rs_mv_mission_content', array(
        'default'           => 'কুরআন-হাদিসের জ্ঞানের পাশাপাশি আধুনিক শিক্ষার সমন্বয়ে শিক্ষার্থীদের নৈতিক, আধ্যাত্মিক ও একাডেমিক দিক থেকে যোগ্য নাগরিক হিসেবে গড়ে তোলা।',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'rs_mv_mission_content', array(
        'label'   => __( 'Tab 1 — Content', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'textarea',
    ) );
 
    /*==============================
        Tab 2 — Vision (উদ্দেশ্য)
    ==============================*/
    $wp_customize->add_setting( 'rs_mv_vision_label', array(
        'default'           => 'উদ্দেশ্য',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_mv_vision_label', array(
        'label'   => __( 'Tab 2 — Label', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'text',
    ) );
 
    $wp_customize->add_setting( 'rs_mv_vision_content', array(
        'default'           => 'একটি আদর্শ দ্বীনি শিক্ষা প্রতিষ্ঠান হিসেবে দেশ ও জাতি গঠনে অবদান রাখা এবং প্রতিটি শিক্ষার্থীকে ইলম ও আমলের সমন্বয়ে গড়ে তোলা।',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'rs_mv_vision_content', array(
        'label'   => __( 'Tab 2 — Content', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'textarea',
    ) );
 
    /*==============================
        Tab 3 — Values (মূল্যবোধ)
    ==============================*/
    $wp_customize->add_setting( 'rs_mv_value_label', array(
        'default'           => 'মূল্যবোধ',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_mv_value_label', array(
        'label'   => __( 'Tab 3 — Label', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'text',
    ) );
 
    $wp_customize->add_setting( 'rs_mv_value_content', array(
        'default'           => 'সততা, শৃঙ্খলা, সহনশীলতা ও পারস্পরিক শ্রদ্ধাবোধ — এই মূল্যবোধগুলোর চর্চা মাদরাসার প্রতিটি কার্যক্রমে প্রতিফলিত হয়।',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'rs_mv_value_content', array(
        'label'   => __( 'Tab 3 — Content', 'rs-madrasha' ),
        'section' => 'rs_mission_vision',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'rs_mission_vision_customizer' );

// founder card customizer

function rs_founder_card_customizer( $wp_customize ) {
 
    $wp_customize->add_section( 'rs_founder_card', array(
        'title'    => __( 'Founder Card', 'rs-madrasha' ),
        'priority' => 98,
    ) );
 
    /*==============================
        Founder Photo
    ==============================*/
    $wp_customize->add_setting( 'rs_founder_photo', array(
        'sanitize_callback' => 'absint',
    ) );
 
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'rs_founder_photo',
            array(
                'label'     => __( 'Founder Photo', 'rs-madrasha' ),
                'section'   => 'rs_founder_card',
                'mime_type' => 'image',
            )
        )
    );
 
    /*==============================
        Badge / Designation Label
    ==============================*/
    $wp_customize->add_setting( 'rs_founder_badge', array(
        'default'           => 'প্রতিষ্ঠাতা',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
 
    $wp_customize->add_control( 'rs_founder_badge', array(
        'label'   => __( 'Badge Text', 'rs-madrasha' ),
        'section' => 'rs_founder_card',
        'type'    => 'text',
    ) );
 
    /*==============================
        Founder Name
    ==============================*/
    $wp_customize->add_setting( 'rs_founder_name', array(
        'default'           => 'আলহাজ্ব এ্যাড. মোঃ মজিবর রহমান সরোয়ার',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
 
    $wp_customize->add_control( 'rs_founder_name', array(
        'label'   => __( 'Founder Name', 'rs-madrasha' ),
        'section' => 'rs_founder_card',
        'type'    => 'text',
    ) );
 
    /*==============================
        Qualification (new field)
    ==============================*/
    $wp_customize->add_setting( 'rs_founder_qualification', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
 
    $wp_customize->add_control( 'rs_founder_qualification', array(
        'label'       => __( 'Qualification (optional)', 'rs-madrasha' ),
        'description' => __( 'e.g. এল.এল.বি, সাবেক সংসদ সদস্য — leave blank to hide this line.', 'rs-madrasha' ),
        'section'     => 'rs_founder_card',
        'type'        => 'text',
    ) );
 
    /*==============================
        Institution Name
    ==============================*/
    $wp_customize->add_setting( 'rs_founder_institution', array(
        'default'           => 'কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদরাসা',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
 
    $wp_customize->add_control( 'rs_founder_institution', array(
        'label'   => __( 'Institution Name', 'rs-madrasha' ),
        'section' => 'rs_founder_card',
        'type'    => 'text',
    ) );
 
    /*==============================
        Address
    ==============================*/
    $wp_customize->add_setting( 'rs_founder_address', array(
        'default'           => 'বরিশাল সদর, বরিশাল',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
 
    $wp_customize->add_control( 'rs_founder_address', array(
        'label'   => __( 'Address', 'rs-madrasha' ),
        'section' => 'rs_founder_card',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'rs_founder_card_customizer' );







/**
 * ==========================================================
 * INFRASTRUCTURE — Customizer Settings
 * A fixed set of 4 label/value stat rows — same pattern as
 * the Footer's Important Links (fixed count, not a repeater).
 * ==========================================================
 */

function rs_infrastructure_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_infrastructure', array(
        'title'    => __( 'Infrastructure Widget', 'rs-madrasha' ),
        'priority' => 99,
    ) );

    /*==============================
        Widget Heading
    ==============================*/
    $wp_customize->add_setting( 'rs_infra_heading', array(
        'default'           => 'অবকাঠামো',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_infra_heading', array(
        'label'   => __( 'Widget Heading', 'rs-madrasha' ),
        'section' => 'rs_infrastructure',
        'type'    => 'text',
    ) );

    /*==============================
        Default rows (label => value)
    ==============================*/
    $rows_defaults = array(
        1 => array( 'label' => 'শ্রেণিকক্ষ',    'value' => '৪৮টি' ),
        2 => array( 'label' => 'হোস্টেল ভবন',   'value' => '৩টি' ),
        3 => array( 'label' => 'লাইব্রেরি বই',   'value' => '১৫,০০০+' ),
        4 => array( 'label' => 'খেলার মাঠ',     'value' => '২টি' ),
    );

    foreach ( $rows_defaults as $i => $row ) {

        // Label
        $wp_customize->add_setting( "rs_infra_row{$i}_label", array(
            'default'           => $row['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( "rs_infra_row{$i}_label", array(
            'label'   => sprintf( __( 'Row %d — Label', 'rs-madrasha' ), $i ),
            'section' => 'rs_infrastructure',
            'type'    => 'text',
        ) );

        // Value
        $wp_customize->add_setting( "rs_infra_row{$i}_value", array(
            'default'           => $row['value'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( "rs_infra_row{$i}_value", array(
            'label'   => sprintf( __( 'Row %d — Value', 'rs-madrasha' ), $i ),
            'section' => 'rs_infrastructure',
            'type'    => 'text',
        ) );
    }
}
add_action( 'customize_register', 'rs_infrastructure_customizer' );
 





/**
 * ==========================================================
 * FOUNDING HISTORY (About page intro) — Customizer Settings
 * A single title + paragraph(s) block.
 * ==========================================================
 */

function rs_founding_history_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_founding_history', array(
        'title'    => __( 'About Page — Founding History', 'rs-madrasha' ),
        'priority' => 100,
    ) );

    /*==============================
        Section Title
    ==============================*/
    $wp_customize->add_setting( 'rs_history_title', array(
        'default'           => 'প্রতিষ্ঠার ইতিহাস',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_history_title', array(
        'label'   => __( 'Section Title', 'rs-madrasha' ),
        'section' => 'rs_founding_history',
        'type'    => 'text',
    ) );

    /*==============================
        Body Text (one or more paragraphs)
    ==============================*/
    $wp_customize->add_setting( 'rs_history_body', array(
        'default'           => 'ঢাকার অদূরে দেমরায় অবস্থিত কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদ্রাসা দীর্ঘ আশি বছরের বেশি সময় ধরে দ্বীনি ও আধুনিক শিক্ষার সমন্বয়ে একটি আদর্শ শিক্ষা প্রতিষ্ঠান হিসেবে কাজ করে যাচ্ছে। ১৯৪৬ সালে একটি স্থানীয় মাহফিলকে কেন্দ্র করে এই অঞ্চলে দ্বীনি শিক্ষা প্রতিষ্ঠার স্বপ্ন দেখা শুরু হয়, যা পরবর্তীতে কয়েক দশকের প্রচেষ্টায় আজকের এই বিশাল প্রাঙ্গণে রূপ নিয়েছে।',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'rs_history_body', array(
        'label'       => __( 'Body Text', 'rs-madrasha' ),
        'description' => __( 'Leave a blank line between paragraphs to start a new paragraph on the site.', 'rs-madrasha' ),
        'section'     => 'rs_founding_history',
        'type'        => 'textarea',
    ) );
}
add_action( 'customize_register', 'rs_founding_history_customizer' );




/**
 * ==========================================================
 * CONTACT PAGE — Customizer Settings
 * Covers two fixed blocks:
 *   1) Contact Info Cards (Address / Phone / Email)
 *   2) Location Map + Department-wise Contact Table
 * ==========================================================
 */

function rs_contact_page_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_contact_page', array(
        'title'    => __( 'Contact Page', 'rs-madrasha' ),
        'priority' => 101,
    ) );

    /*==============================================
        BLOCK 1 — Contact Info Cards
    ==============================================*/

    // Address
    $wp_customize->add_setting( 'rs_contact_address', array(
        'default'           => 'কাউনিয়া, বরিশাল সদর, বরিশাল',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_address', array(
        'label'   => __( 'Address', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    // Phone — Principal
    $wp_customize->add_setting( 'rs_contact_phone1', array(
        'default'           => '০১৩০৯-১০৭৯০৬ (অধ্যক্ষ)',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_phone1', array(
        'label'   => __( 'Phone Line 1', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    // Phone — Vice Principal
    $wp_customize->add_setting( 'rs_contact_phone2', array(
        'default'           => '০১৮১৬-১০৪০০ (উপাধ্যক্ষ)',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_phone2', array(
        'label'   => __( 'Phone Line 2', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    // Email 1
    $wp_customize->add_setting( 'rs_contact_email1', array(
        'default'           => 'kawniagirls.fazil@gmail.com',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_email1', array(
        'label'   => __( 'Email Line 1', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    // Email 2 / Website
    $wp_customize->add_setting( 'rs_contact_email2', array(
        'default'           => 'kgfmm.edu.bd',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_email2', array(
        'label'   => __( 'Email Line 2 / Website', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    /*==============================================
        BLOCK 2 — Map + Department Contact Table
    ==============================================*/

    // Section Title
    $wp_customize->add_setting( 'rs_contact_map_title', array(
        'default'           => 'অবস্থান',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_map_title', array(
        'label'   => __( 'Map Section Title', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    // Map Embed URL
    $wp_customize->add_setting( 'rs_contact_map_url', array(
        'default'           => 'https://www.google.com/maps?q=Demra,Dhaka&output=embed',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'rs_contact_map_url', array(
        'label'       => __( 'Google Maps Embed URL', 'rs-madrasha' ),
        'description' => __( 'Get this from Google Maps → Share → Embed a map → copy the src="..." URL.', 'rs-madrasha' ),
        'section'     => 'rs_contact_page',
        'type'        => 'url',
    ) );

    // Department Table Heading
    $wp_customize->add_setting( 'rs_contact_dept_heading', array(
        'default'           => 'বিভাগভিত্তিক যোগাযোগ',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_contact_dept_heading', array(
        'label'   => __( 'Department Table Heading', 'rs-madrasha' ),
        'section' => 'rs_contact_page',
        'type'    => 'text',
    ) );

    // Department Rows (fixed 5)
    $dept_rows_defaults = array(
        1 => array( 'label' => 'দাখিল বিভাগ',    'phone' => '০১৭১২-৪৫৭৬২০' ),
        2 => array( 'label' => 'আলিম বিভাগ',     'phone' => '০১৯১৪-৫৮৭৯১৩' ),
        3 => array( 'label' => 'ফাযিল বিভাগ',    'phone' => '০১৯১৬-৬০৪২২৫' ),
        4 => array( 'label' => 'কামিল বিভাগ',    'phone' => '০১১২৫-৭৪৫৭৩৬' ),
        5 => array( 'label' => 'হোস্টেল সুপার',  'phone' => '০১৭১২-৪৮১৮৭' ),
    );

    foreach ( $dept_rows_defaults as $i => $row ) {

        $wp_customize->add_setting( "rs_contact_dept{$i}_label", array(
            'default'           => $row['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "rs_contact_dept{$i}_label", array(
            'label'   => sprintf( __( 'Department Row %d — Label', 'rs-madrasha' ), $i ),
            'section' => 'rs_contact_page',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "rs_contact_dept{$i}_phone", array(
            'default'           => $row['phone'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "rs_contact_dept{$i}_phone", array(
            'label'   => sprintf( __( 'Department Row %d — Phone', 'rs-madrasha' ), $i ),
            'section' => 'rs_contact_page',
            'type'    => 'text',
        ) );
    }
}
add_action( 'customize_register', 'rs_contact_page_customizer' );




/**
 * ==========================================================
 * ADMISSION PAGE — Customizer Settings
 * Covers three fixed blocks:
 *   1) General Instructions Box
 *   2) Admission Schedule (4 fixed rows)
 *   3) Admission Office Contact
 * ==========================================================
 */

function rs_admission_page_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_admission_page', array(
        'title'    => __( 'Admission Page', 'rs-madrasha' ),
        'priority' => 102,
    ) );

    /*==============================================
        BLOCK 1 — Instructions Box
    ==============================================*/
    $wp_customize->add_setting( 'rs_adm_instructions_heading', array(
        'default'           => 'ভর্তি সংক্রান্ত সাধারণ নির্দেশনা',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_adm_instructions_heading', array(
        'label'   => __( 'Instructions Heading', 'rs-madrasha' ),
        'section' => 'rs_admission_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'rs_adm_instructions_text', array(
        'default'           => 'নিচের তালিকা থেকে আপনার প্রয়োজনীয় স্তরের ভর্তি ফরম ডাউনলোড করুন। পূরণকৃত ফরম প্রয়োজনীয় কাগজপত্রসহ নির্ধারিত সময়ের মধ্যে অফিসে জমা দিতে হবে।',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'rs_adm_instructions_text', array(
        'label'   => __( 'Instructions Text', 'rs-madrasha' ),
        'section' => 'rs_admission_page',
        'type'    => 'textarea',
    ) );

    /*==============================================
        BLOCK 2 — Admission Schedule (fixed 4 rows)
    ==============================================*/
    $schedule_defaults = array(
        1 => array( 'label' => 'দাখিল', 'value' => '১-৩১ জুলাই' ),
        2 => array( 'label' => 'আলিম',  'value' => '১-২০ জুলাই' ),
        3 => array( 'label' => 'ফাযিল', 'value' => '১-১৫ আগস্ট' ),
        4 => array( 'label' => 'কামিল', 'value' => '১-১০ আগস্ট' ),
    );

    $wp_customize->add_setting( 'rs_adm_schedule_heading', array(
        'default'           => 'ভর্তি সময়সূচি',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_adm_schedule_heading', array(
        'label'   => __( 'Schedule Widget Heading', 'rs-madrasha' ),
        'section' => 'rs_admission_page',
        'type'    => 'text',
    ) );

    foreach ( $schedule_defaults as $i => $row ) {
        $wp_customize->add_setting( "rs_adm_schedule{$i}_label", array(
            'default'           => $row['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "rs_adm_schedule{$i}_label", array(
            'label'   => sprintf( __( 'Schedule Row %d — Label', 'rs-madrasha' ), $i ),
            'section' => 'rs_admission_page',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "rs_adm_schedule{$i}_value", array(
            'default'           => $row['value'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "rs_adm_schedule{$i}_value", array(
            'label'   => sprintf( __( 'Schedule Row %d — Date Range', 'rs-madrasha' ), $i ),
            'section' => 'rs_admission_page',
            'type'    => 'text',
        ) );
    }

    /*==============================================
        BLOCK 3 — Admission Office Contact
    ==============================================*/
    $wp_customize->add_setting( 'rs_adm_contact_phone', array(
        'default'           => '০১৭১২-৪৫৭৬২০ (ভর্তি শাখা)',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_adm_contact_phone', array(
        'label'   => __( 'Admission Office Phone', 'rs-madrasha' ),
        'section' => 'rs_admission_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'rs_adm_contact_email', array(
        'default'           => 'kawniagirls.fazil@gmail.com',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_adm_contact_email', array(
        'label'   => __( 'Admission Office Email', 'rs-madrasha' ),
        'section' => 'rs_admission_page',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'rs_admission_page_customizer' );



?>