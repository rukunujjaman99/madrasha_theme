<?php
/**
 * ==========================================================
 * TESTIMONIAL — Custom Post Type
 * Post Title      => Internal reference name (admin-only, not shown on site)
 * Featured Image  => Person's Photo
 * Meta Fields     => Quote, Designation (e.g. "অভিভাবক, দাখিল বিভাগ")
 * Order           => Drag & drop via Page Attributes (menu_order) — controls carousel sequence
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_testimonial_cpt() {

    $labels = array(
        'name'          => __( 'Testimonials', 'rs-madrasha' ),
        'singular_name' => __( 'Testimonial', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Testimonial', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Testimonial', 'rs-madrasha' ),
        'menu_name'     => __( 'Testimonials', 'rs-madrasha' ),
    );

    register_post_type( 'testimonial', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_testimonial_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Quote / Designation
--------------------------------------------------------*/
function rs_add_testimonial_metabox() {
    add_meta_box(
        'rs_testimonial_details',
        __( 'Testimonial Details', 'rs-madrasha' ),
        'rs_render_testimonial_metabox',
        'testimonial',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_testimonial_metabox' );

function rs_render_testimonial_metabox( $post ) {

    wp_nonce_field( 'rs_testimonial_save', 'rs_testimonial_nonce' );

    $quote       = get_post_meta( $post->ID, '_testimonial_quote', true );
    $designation = get_post_meta( $post->ID, '_testimonial_designation', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="testimonial_quote"><?php _e( 'Quote', 'rs-madrasha' ); ?></label></th>
            <td>
                <textarea id="testimonial_quote" name="testimonial_quote" class="widefat" rows="4"
                          placeholder="<?php esc_attr_e( 'এই মাদরাসায় আমার সন্তানের দ্বীনি ও একাডেমিক উভয় দিকের বিকাশ দেখে আমি সন্তুষ্ট।', 'rs-madrasha' ); ?>"><?php echo esc_textarea( $quote ); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="testimonial_designation"><?php _e( 'Designation', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="testimonial_designation" name="testimonial_designation" class="widefat"
                       value="<?php echo esc_attr( $designation ); ?>"
                       placeholder="<?php esc_attr_e( 'অভিভাবক, দাখিল বিভাগ', 'rs-madrasha' ); ?>">
            </td>
        </tr>
    </table>
    <p class="description">
        <?php _e( 'Set the person\'s photo using the Featured Image box. The Post Title above is just for your own reference in the admin list — it is not shown on the site.', 'rs-madrasha' ); ?>
    </p>
    <?php
}

function rs_save_testimonial_meta( $post_id ) {

    if ( ! isset( $_POST['rs_testimonial_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_testimonial_nonce'], 'rs_testimonial_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['testimonial_quote'] ) ) {
        update_post_meta( $post_id, '_testimonial_quote', sanitize_textarea_field( $_POST['testimonial_quote'] ) );
    }

    if ( isset( $_POST['testimonial_designation'] ) ) {
        update_post_meta( $post_id, '_testimonial_designation', sanitize_text_field( $_POST['testimonial_designation'] ) );
    }
}
add_action( 'save_post_testimonial', 'rs_save_testimonial_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Designation & Quote preview columns
--------------------------------------------------------*/
function rs_testimonial_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        if ( 'title' === $key ) {
            $new_columns['testimonial_thumb'] = __( 'Photo', 'rs-madrasha' );
        }
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['testimonial_designation'] = __( 'Designation', 'rs-madrasha' );
            $new_columns['testimonial_quote']        = __( 'Quote', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_testimonial_posts_columns', 'rs_testimonial_admin_columns' );

function rs_testimonial_admin_column_content( $column, $post_id ) {
    if ( 'testimonial_thumb' === $column ) {
        if ( has_post_thumbnail( $post_id ) ) {
            echo get_the_post_thumbnail( $post_id, array( 50, 50 ), array( 'style' => 'object-fit:cover;border-radius:50%;' ) );
        } else {
            echo '—';
        }
    }

    if ( 'testimonial_designation' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_testimonial_designation', true ) ?: '—' );
    }

    if ( 'testimonial_quote' === $column ) {
        $quote = get_post_meta( $post_id, '_testimonial_quote', true );
        echo esc_html( $quote ? wp_trim_words( $quote, 10 ) : '—' );
    }
}
add_action( 'manage_testimonial_posts_custom_column', 'rs_testimonial_admin_column_content', 10, 2 );