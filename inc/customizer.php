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
}
add_action( 'customize_register', 'rs_principal_card_customizer' );

?>