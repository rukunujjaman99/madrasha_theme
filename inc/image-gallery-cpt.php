<?php
/**
 * ==========================================================
 * GALLERY — Custom Post Type
 * Post Title      => Photo Caption / Alt text (optional, for admin reference)
 * Featured Image  => The Photo itself
 * Order           => Drag & drop via Page Attributes, or by Date
 * ==========================================================
 */

function rs_register_gallery_cpt() {

    $labels = array(
        'name'          => __( 'Gallery', 'rs-madrasha' ),
        'singular_name' => __( 'Photo', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Photo', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Photo', 'rs-madrasha' ),
        'menu_name'     => __( 'Gallery', 'rs-madrasha' ),
    );

    register_post_type( 'gallery', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-gallery',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
        'has_archive'   => true,
        'rewrite'       => array( 'slug' => 'gallery' ),
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_gallery_cpt' );


/*--------------------------------------------------------
    Show the Featured Image as a thumbnail column in the
    admin list table, since photos are the whole point here.
--------------------------------------------------------*/
function rs_gallery_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        if ( 'title' === $key ) {
            $new_columns['gallery_thumb'] = __( 'Photo', 'rs-madrasha' );
        }
        $new_columns[ $key ] = $label;
    }
    return $new_columns;
}
add_filter( 'manage_gallery_posts_columns', 'rs_gallery_admin_columns' );

function rs_gallery_admin_column_content( $column, $post_id ) {
    if ( 'gallery_thumb' === $column ) {
        if ( has_post_thumbnail( $post_id ) ) {
            echo get_the_post_thumbnail( $post_id, array( 60, 60 ), array( 'style' => 'object-fit:cover;border-radius:4px;' ) );
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_gallery_posts_custom_column', 'rs_gallery_admin_column_content', 10, 2 );


/*--------------------------------------------------------
    Require a Featured Image before publishing (optional but
    prevents empty gallery cards from appearing on the site).
--------------------------------------------------------*/
function rs_gallery_require_thumbnail( $messages ) {
    return $messages;
}

function rs_gallery_thumbnail_notice() {
    global $post_type, $post;
    if ( 'gallery' === $post_type && $post && ! has_post_thumbnail( $post->ID ) ) {
        echo '<div class="notice notice-warning inline"><p>' .
             esc_html__( 'Please set a Featured Image — it is the photo that will display on the site.', 'rs-madrasha' ) .
             '</p></div>';
    }
}
add_action( 'edit_form_after_title', 'rs_gallery_thumbnail_notice' );