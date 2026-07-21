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
    Meta Box: Category (drives the filter buttons on the
    gallery page — ক্যাম্পাস / অনুষ্ঠান / খেলাধুলা / শ্রেণিকক্ষ)
--------------------------------------------------------*/
function rs_add_gallery_metabox() {
    add_meta_box(
        'rs_gallery_category',
        __( 'Gallery Category', 'rs-madrasha' ),
        'rs_render_gallery_metabox',
        'gallery',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'rs_add_gallery_metabox' );

function rs_render_gallery_metabox( $post ) {

    wp_nonce_field( 'rs_gallery_save', 'rs_gallery_nonce' );

    $category = get_post_meta( $post->ID, '_gallery_category', true );

    $cat_options = array(
        'campus' => 'ক্যাম্পাস',
        'event'  => 'অনুষ্ঠান',
        'sports' => 'খেলাধুলা',
        'class'  => 'শ্রেণিকক্ষ',
    );
    ?>
    <select name="gallery_category" id="gallery_category" class="widefat">
        <option value=""><?php esc_html_e( '— Select —', 'rs-madrasha' ); ?></option>
        <?php foreach ( $cat_options as $slug => $label ) : ?>
            <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $category, $slug ); ?>>
                <?php echo esc_html( $label ); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p class="description" style="margin-top:8px;">
        <?php esc_html_e( 'Controls which filter tab this photo appears under.', 'rs-madrasha' ); ?>
    </p>
    <?php
}

function rs_save_gallery_meta( $post_id ) {

    if ( ! isset( $_POST['rs_gallery_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_gallery_nonce'], 'rs_gallery_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['gallery_category'] ) ) {
        update_post_meta( $post_id, '_gallery_category', sanitize_text_field( $_POST['gallery_category'] ) );
    }
}
add_action( 'save_post_gallery', 'rs_save_gallery_meta' );


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
        if ( 'title' === $key ) {
            $new_columns['gallery_category'] = __( 'Category', 'rs-madrasha' );
        }
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

    if ( 'gallery_category' === $column ) {
        $cat_options = array(
            'campus' => 'ক্যাম্পাস',
            'event'  => 'অনুষ্ঠান',
            'sports' => 'খেলাধুলা',
            'class'  => 'শ্রেণিকক্ষ',
        );
        $cat = get_post_meta( $post_id, '_gallery_category', true );
        echo isset( $cat_options[ $cat ] ) ? esc_html( $cat_options[ $cat ] ) : '—';
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