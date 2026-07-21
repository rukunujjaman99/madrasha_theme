<?php
/**
 * Enqueue Theme Styles & Scripts
 */

require_once get_template_directory() . '/inc/slider-cpt.php';
require_once get_template_directory() . '/inc/teachers-cpt.php';
require_once get_template_directory() . '/inc/feature-cpt.php';
require_once get_template_directory() . '/inc/student-cpt.php';
require_once get_template_directory() . '/inc/history-cpt.php';
require_once get_template_directory() . '/inc/notice-cpt.php';
require_once get_template_directory() . '/inc/staff-cpt.php';
require_once get_template_directory() . '/inc/committee-cpt.php';
require_once get_template_directory() . '/inc/contact-cpt.php';
require_once get_template_directory() . '/inc/admission-cpt.php';
require_once get_template_directory() . '/inc/result-cpt.php';
require_once get_template_directory() . '/inc/video-cpt.php';
require_once get_template_directory() . '/inc/publication-cpt.php';
require_once get_template_directory() . '/inc/testimonial-cpt.php';
require_once get_template_directory() . '/inc/academic-cpt.php';
require_once get_template_directory() . '/inc/event-cpt.php';



require_once get_template_directory() . '/inc/download-form-cpt.php';
require_once get_template_directory() . '/inc/image-gallery-cpt.php';


require_once get_template_directory() . '/inc/customizer.php';



function madarsa_enqueue_assets() {

    // Google Fonts
    wp_enqueue_style(
        'madarsa-google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&family=Amiri&display=swap',
        array(),
        null
    );

    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Bootstrap Icons
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        array(),
        '1.11.3'
    );

    // Theme Style
    wp_enqueue_style(
        'madarsa-style',
        get_stylesheet_uri(),
        array('bootstrap'),
        wp_get_theme()->get('Version')
    );

    // Optional: If you have another CSS file
    wp_enqueue_style(
        'madarsa-custom-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array('madarsa-style'),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );

    // Bootstrap Bundle JS
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );

        // Theme Main JS
        wp_enqueue_script(
            'madarsa-main',
            get_template_directory_uri() . '/assets/js/main.js',
            array('bootstrap'),
            filemtime(get_template_directory() . '/assets/js/main.js'),
            true
        );
             wp_enqueue_script(
            'student-filter',
            get_template_directory_uri() . '/assets/js/student.js',
            array('bootstrap'),
            filemtime(get_template_directory() . '/assets/js/student.js'),
            true
        );
             wp_enqueue_script(
            'notice-filter',
            get_template_directory_uri() . '/assets/js/notice.js',
            array('bootstrap'),
            filemtime(get_template_directory() . '/assets/js/notice.js'),
            true
        );

            wp_enqueue_script(
                'contact-form',
                get_template_directory_uri() . '/assets/js/contact.js',
                array('bootstrap'),
                filemtime(get_template_directory() . '/assets/js/contact.js'),
                true
            );
            
            wp_enqueue_script(
                'event-countdown',
                get_template_directory_uri() . '/assets/js/event.js',
                array('bootstrap'),
                filemtime(get_template_directory() . '/assets/js/event.js'),
                true
            );





        


}
add_action('wp_enqueue_scripts', 'madarsa_enqueue_assets');






function madarsa_setup_theme() {
    // Add support for title tag
    add_theme_support('title-tag');

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-width' => true,
        'flex-height' => true,
    ));

    // Register navigation menu
    register_nav_menus(array(
        'Primary' => __('Primary', 'madarsa'),
    ));
}

add_action('after_setup_theme', 'madarsa_setup_theme');



