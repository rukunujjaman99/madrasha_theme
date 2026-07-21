<?php
/**
 * ==========================================================
 * PUBLICATION — Custom Post Type
 * Post Title   => Publication Title (e.g. "বার্ষিক ম্যাগাজিন...")
 * Meta Fields  => Icon (Bootstrap Icon class), Description, PDF File
 * Order        => Drag & drop via Page Attributes (menu_order)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_publication_cpt() {

    $labels = array(
        'name'          => __( 'Publications', 'rs-madrasha' ),
        'singular_name' => __( 'Publication', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Publication', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Publication', 'rs-madrasha' ),
        'menu_name'     => __( 'Publications', 'rs-madrasha' ),
    );

    register_post_type( 'publication', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-media-document',
        'supports'      => array( 'title', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_publication_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Icon / Description / PDF File
--------------------------------------------------------*/
function rs_add_publication_metabox() {
    add_meta_box(
        'rs_publication_details',
        __( 'Publication Details', 'rs-madrasha' ),
        'rs_render_publication_metabox',
        'publication',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_publication_metabox' );

function rs_render_publication_metabox( $post ) {

    wp_nonce_field( 'rs_publication_save', 'rs_publication_nonce' );
    wp_enqueue_media();

    $icon        = get_post_meta( $post->ID, '_publication_icon', true ) ?: 'bi bi-journal-richtext';
    $description = get_post_meta( $post->ID, '_publication_description', true );
    $file_id     = get_post_meta( $post->ID, '_publication_file', true );
    $file_url    = $file_id ? wp_get_attachment_url( $file_id ) : '';
    $file_name   = $file_id ? basename( get_attached_file( $file_id ) ) : '';
    ?>
    <table class="form-table">
        <tr>
            <th><label for="publication_icon"><?php _e( 'Icon Class', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="publication_icon" name="publication_icon" class="widefat"
                       value="<?php echo esc_attr( $icon ); ?>" placeholder="bi bi-journal-richtext">
                <i class="<?php echo esc_attr( $icon ); ?>" id="publication-icon-preview" style="font-size:24px;margin-top:6px;display:inline-block;color:var(--rose,#c0392b);"></i>
                <p class="description"><?php _e( 'A Bootstrap Icon class, e.g. bi bi-journal-richtext, bi bi-mortarboard, bi bi-newspaper.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="publication_description"><?php _e( 'Short Description', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="publication_description" name="publication_description" class="widefat"
                       value="<?php echo esc_attr( $description ); ?>"
                       placeholder="<?php esc_attr_e( 'শিক্ষার্থীদের লেখা, কবিতা ও প্রবন্ধ সংকলন', 'rs-madrasha' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label><?php _e( 'PDF File', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="hidden" name="publication_file" id="publication_file" value="<?php echo esc_attr( $file_id ); ?>">

                <div id="publication-file-preview" style="margin-bottom:8px;">
                    <?php if ( $file_url ) : ?>
                        <span class="dashicons dashicons-media-default"></span>
                        <a href="<?php echo esc_url( $file_url ); ?>" target="_blank"><?php echo esc_html( $file_name ); ?></a>
                    <?php else : ?>
                        <em><?php _e( 'No file uploaded yet.', 'rs-madrasha' ); ?></em>
                    <?php endif; ?>
                </div>

                <button type="button" class="button" id="publication-upload-btn"><?php _e( 'Select / Upload PDF', 'rs-madrasha' ); ?></button>
                <button type="button" class="button" id="publication-remove-btn" style="<?php echo $file_id ? '' : 'display:none;'; ?>"><?php _e( 'Remove File', 'rs-madrasha' ); ?></button>
            </td>
        </tr>
    </table>

    <script>
    (function(){
        var frame;
        var uploadBtn = document.getElementById('publication-upload-btn');
        var removeBtn = document.getElementById('publication-remove-btn');
        var fileInput = document.getElementById('publication_file');
        var preview   = document.getElementById('publication-file-preview');
        var iconInput = document.getElementById('publication_icon');
        var iconPreview = document.getElementById('publication-icon-preview');

        iconInput.addEventListener('input', function () {
            iconPreview.className = iconInput.value;
        });

        uploadBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }

            frame = wp.media({
                title: '<?php echo esc_js( __( 'Select Publication PDF', 'rs-madrasha' ) ); ?>',
                button: { text: '<?php echo esc_js( __( 'Use this file', 'rs-madrasha' ) ); ?>' },
                library: { type: [ 'application/pdf' ] },
                multiple: false
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                fileInput.value = attachment.id;
                preview.innerHTML = '<span class="dashicons dashicons-media-default"></span> <a href="' +
                    attachment.url + '" target="_blank">' + attachment.filename + '</a>';
                removeBtn.style.display = '';
            });

            frame.open();
        });

        removeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fileInput.value = '';
            preview.innerHTML = '<em><?php echo esc_js( __( 'No file uploaded yet.', 'rs-madrasha' ) ); ?></em>';
            removeBtn.style.display = 'none';
        });
    })();
    </script>
    <?php
}

function rs_save_publication_meta( $post_id ) {

    if ( ! isset( $_POST['rs_publication_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_publication_nonce'], 'rs_publication_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['publication_icon'] ) ) {
        update_post_meta( $post_id, '_publication_icon', sanitize_text_field( $_POST['publication_icon'] ) );
    }

    if ( isset( $_POST['publication_description'] ) ) {
        update_post_meta( $post_id, '_publication_description', sanitize_text_field( $_POST['publication_description'] ) );
    }

    if ( isset( $_POST['publication_file'] ) ) {
        update_post_meta( $post_id, '_publication_file', absint( $_POST['publication_file'] ) );
    }
}
add_action( 'save_post_publication', 'rs_save_publication_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Icon / Description / File columns
--------------------------------------------------------*/
function rs_publication_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['publication_description'] = __( 'Description', 'rs-madrasha' );
            $new_columns['publication_file']         = __( 'File', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_publication_posts_columns', 'rs_publication_admin_columns' );

function rs_publication_admin_column_content( $column, $post_id ) {
    if ( 'publication_description' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_publication_description', true ) ?: '—' );
    }

    if ( 'publication_file' === $column ) {
        $file_id = get_post_meta( $post_id, '_publication_file', true );
        if ( $file_id ) {
            echo '<a href="' . esc_url( wp_get_attachment_url( $file_id ) ) . '" target="_blank">' .
                 esc_html( basename( get_attached_file( $file_id ) ) ) . '</a>';
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_publication_posts_custom_column', 'rs_publication_admin_column_content', 10, 2 );