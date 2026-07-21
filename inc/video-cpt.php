<?php
/**
 * ==========================================================
 * VIDEO — Custom Post Type + Category Taxonomy
 * Post Title   => Video Title
 * Taxonomy     => video_category (add/edit/remove terms freely
 *                 from Videos → Categories — no code changes needed)
 * Meta Field   => YouTube URL/ID only (duration removed)
 * Thumbnail    => Auto-pulled from YouTube — no upload needed
 * Order        => Drag & drop via Page Attributes (menu_order)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_video_cpt() {

    $labels = array(
        'name'          => __( 'Videos', 'rs-madrasha' ),
        'singular_name' => __( 'Video', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Video', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Video', 'rs-madrasha' ),
        'menu_name'     => __( 'Videos', 'rs-madrasha' ),
    );

    register_post_type( 'video', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-video-alt3',
        'supports'      => array( 'title', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_video_cpt' );


/*--------------------------------------------------------
    2) Register Category Taxonomy (like Post Categories —
       admin can add/edit/delete terms freely from wp-admin)
--------------------------------------------------------*/
function rs_register_video_category_taxonomy() {

    $labels = array(
        'name'          => __( 'Video Categories', 'rs-madrasha' ),
        'singular_name' => __( 'Video Category', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Category', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Category', 'rs-madrasha' ),
        'menu_name'     => __( 'Categories', 'rs-madrasha' ),
    );

    register_taxonomy( 'video_category', 'video', array(
        'labels'            => $labels,
        'hierarchical'      => true, // behaves like Categories (checkboxes), not Tags
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => false,
        'rewrite'           => false,
    ) );
}
add_action( 'init', 'rs_register_video_category_taxonomy' );

// Seed the starting categories once, so the site isn't empty on first use.
// After this, admins manage categories entirely from Videos → Categories.
function rs_seed_default_video_categories() {
    if ( get_option( 'rs_video_categories_seeded' ) ) {
        return;
    }

    $defaults = array( 'অনুষ্ঠান', 'ক্যাম্পাস ভ্রমণ', 'সাংস্কৃতিক', 'খেলাধুলা' );

    foreach ( $defaults as $term_name ) {
        if ( ! term_exists( $term_name, 'video_category' ) ) {
            wp_insert_term( $term_name, 'video_category' );
        }
    }

    update_option( 'rs_video_categories_seeded', 1 );
}
add_action( 'init', 'rs_seed_default_video_categories', 20 ); // after taxonomy is registered


/*--------------------------------------------------------
    3) Meta Box: YouTube URL/ID only
--------------------------------------------------------*/
function rs_add_video_metabox() {
    add_meta_box(
        'rs_video_details',
        __( 'Video Details', 'rs-madrasha' ),
        'rs_render_video_metabox',
        'video',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_video_metabox' );

// Accepts a full YouTube URL (watch, youtu.be, embed) OR a bare 11-char ID, returns just the ID.
function rs_extract_youtube_id( $input ) {
    $input = trim( $input );

    if ( preg_match( '/^[a-zA-Z0-9_-]{11}$/', $input ) ) {
        return $input; // already a bare ID
    }

    if ( preg_match( '~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([a-zA-Z0-9_-]{11})~', $input, $m ) ) {
        return $m[1];
    }

    return '';
}

function rs_render_video_metabox( $post ) {

    wp_nonce_field( 'rs_video_save', 'rs_video_nonce' );

    $youtube_id = get_post_meta( $post->ID, '_video_youtube_id', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="video_youtube_url"><?php _e( 'YouTube URL or Video ID', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="video_youtube_url" name="video_youtube_url" class="widefat"
                       value="<?php echo esc_attr( $youtube_id ); ?>"
                       placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                <p class="description"><?php _e( 'Paste the full YouTube link, or just the video ID. The thumbnail is pulled automatically from YouTube — no image upload needed.', 'rs-madrasha' ); ?></p>

                <?php if ( $youtube_id ) : ?>
                    <img src="https://img.youtube.com/vi/<?php echo esc_attr( $youtube_id ); ?>/hqdefault.jpg"
                         style="max-width:200px;margin-top:8px;border-radius:4px;display:block;">
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <p class="description">
        <?php _e( 'Set the Category using the "Video Categories" box in the sidebar — you can add new categories anytime from Videos → Categories.', 'rs-madrasha' ); ?>
    </p>
    <?php
}

function rs_save_video_meta( $post_id ) {

    if ( ! isset( $_POST['rs_video_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_video_nonce'], 'rs_video_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['video_youtube_url'] ) ) {
        $youtube_id = rs_extract_youtube_id( sanitize_text_field( $_POST['video_youtube_url'] ) );
        update_post_meta( $post_id, '_video_youtube_id', $youtube_id );
    }
}
add_action( 'save_post_video', 'rs_save_video_meta' );


/*--------------------------------------------------------
    4) Admin List Table — Thumbnail column
       (Category column is added automatically by
       'show_admin_column' => true on the taxonomy above)
--------------------------------------------------------*/
function rs_video_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        if ( 'title' === $key ) {
            $new_columns['video_thumb'] = __( 'Thumbnail', 'rs-madrasha' );
        }
        $new_columns[ $key ] = $label;
    }
    return $new_columns;
}
add_filter( 'manage_video_posts_columns', 'rs_video_admin_columns' );

function rs_video_admin_column_content( $column, $post_id ) {
    if ( 'video_thumb' === $column ) {
        $youtube_id = get_post_meta( $post_id, '_video_youtube_id', true );
        if ( $youtube_id ) {
            echo '<img src="https://img.youtube.com/vi/' . esc_attr( $youtube_id ) . '/default.jpg" style="width:60px;height:45px;object-fit:cover;border-radius:4px;">';
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_video_posts_custom_column', 'rs_video_admin_column_content', 10, 2 );