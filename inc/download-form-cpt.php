<?php
/**
 * ==========================================================
 * DOWNLOAD FORM — Custom Post Type
 * Post Title   => Link Text (e.g. "ভর্তি ফরম দাখিল")
 * Meta Field   => Attached File (PDF / Word / Image)
 * Order        => Drag & drop via Page Attributes (menu_order)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_download_form_cpt() {

    $labels = array(
        'name'          => __( 'Download Forms', 'rs-madrasha' ),
        'singular_name' => __( 'Download Form', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Download Form', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Download Form', 'rs-madrasha' ),
        'menu_name'     => __( 'Download Forms', 'rs-madrasha' ),
    );

    register_post_type( 'download_form', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-download',
        'supports'      => array( 'title', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_download_form_cpt' );


/*--------------------------------------------------------
    2) Meta Box: File Upload
--------------------------------------------------------*/
function rs_add_download_form_metabox() {
    add_meta_box(
        'rs_download_form_file',
        __( 'Form File', 'rs-madrasha' ),
        'rs_render_download_form_metabox',
        'download_form',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_download_form_metabox' );

function rs_render_download_form_metabox( $post ) {

    wp_nonce_field( 'rs_download_form_save', 'rs_download_form_nonce' );
    wp_enqueue_media();

    $file_id   = get_post_meta( $post->ID, '_download_file', true );
    $file_url  = $file_id ? wp_get_attachment_url( $file_id ) : '';
    $file_name = $file_id ? basename( get_attached_file( $file_id ) ) : '';
    ?>
    <input type="hidden" name="download_file" id="download_file" value="<?php echo esc_attr( $file_id ); ?>">

    <div id="download-file-preview" style="margin-bottom:8px;">
        <?php if ( $file_url ) : ?>
            <span class="dashicons dashicons-media-default"></span>
            <a href="<?php echo esc_url( $file_url ); ?>" target="_blank"><?php echo esc_html( $file_name ); ?></a>
        <?php else : ?>
            <em><?php _e( 'No file uploaded yet.', 'rs-madrasha' ); ?></em>
        <?php endif; ?>
    </div>

    <button type="button" class="button" id="download-upload-btn">
        <?php _e( 'Select / Upload File', 'rs-madrasha' ); ?>
    </button>
    <button type="button" class="button" id="download-remove-btn" style="<?php echo $file_id ? '' : 'display:none;'; ?>">
        <?php _e( 'Remove File', 'rs-madrasha' ); ?>
    </button>

    <p class="description"><?php _e( 'Accepted formats: PDF, Word (.doc/.docx), Image (jpg/png).', 'rs-madrasha' ); ?></p>

    <script>
    (function(){
        var frame;
        var uploadBtn = document.getElementById('download-upload-btn');
        var removeBtn = document.getElementById('download-remove-btn');
        var fileInput = document.getElementById('download_file');
        var preview   = document.getElementById('download-file-preview');

        uploadBtn.addEventListener('click', function (e) {
            e.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: '<?php echo esc_js( __( 'Select Form File', 'rs-madrasha' ) ); ?>',
                button: { text: '<?php echo esc_js( __( 'Use this file', 'rs-madrasha' ) ); ?>' },
                library: {
                    type: [ 'application/pdf', 'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'image' ]
                },
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

function rs_save_download_form_meta( $post_id ) {

    if ( ! isset( $_POST['rs_download_form_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_download_form_nonce'], 'rs_download_form_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['download_file'] ) ) {
        update_post_meta( $post_id, '_download_file', absint( $_POST['download_file'] ) );
    }
}
add_action( 'save_post_download_form', 'rs_save_download_form_meta' );


/*--------------------------------------------------------
    3) Admin List Table — File column (quick visual check)
--------------------------------------------------------*/
function rs_download_form_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['download_file'] = __( 'File', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_download_form_posts_columns', 'rs_download_form_admin_columns' );

function rs_download_form_admin_column_content( $column, $post_id ) {
    if ( 'download_file' === $column ) {
        $file_id = get_post_meta( $post_id, '_download_file', true );
        if ( $file_id ) {
            echo '<a href="' . esc_url( wp_get_attachment_url( $file_id ) ) . '" target="_blank">' .
                 esc_html( basename( get_attached_file( $file_id ) ) ) . '</a>';
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_download_form_posts_custom_column', 'rs_download_form_admin_column_content', 10, 2 );