<?php 



function rs_register_slider_cpt() {

    $labels = array(
        'name'               => __('Sliders', 'rs-madrasha'),
        'singular_name'      => __('Slider', 'rs-madrasha'),
        'add_new'            => __('Add New Slide', 'rs-madrasha'),
        'add_new_item'       => __('Add New Slide', 'rs-madrasha'),
        'edit_item'          => __('Edit Slide', 'rs-madrasha'),
        'new_item'           => __('New Slide', 'rs-madrasha'),
        'all_items'          => __('All Slides', 'rs-madrasha'),
        'view_item'          => __('View Slide', 'rs-madrasha'),
        'search_items'       => __('Search Slides', 'rs-madrasha'),
        'not_found'          => __('No Slides Found', 'rs-madrasha'),
        'menu_name'          => __('Sliders', 'rs-madrasha'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array('title', 'thumbnail', 'page-attributes'),
        'has_archive'        => false,
        'show_in_rest'       => true,
        'rewrite'            => array('slug' => 'slider'),
    );

    register_post_type('slider', $args);
}
add_action('init', 'rs_register_slider_cpt');



















?>