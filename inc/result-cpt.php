<?php
/**
 * ==========================================================
 * RESULT — Custom Post Type
 * Post Title      => Result Title (PDF list) / Image Caption (gallery)
 * Featured Image  => Used only when Type = Image
 * Meta Fields     => Type (pdf/image), Category (দাখিল/আলিম/ফাযিল/কামিল),
 *                    Attached File (used only when Type = PDF)
 * Date            => Native publish date (shown on PDF rows)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_result_cpt() {

    $labels = array(
        'name'          => __( 'Results', 'rs-madrasha' ),
        'singular_name' => __( 'Result', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Result', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Result', 'rs-madrasha' ),
        'menu_name'     => __( 'Results', 'rs-madrasha' ),
    );

    register_post_type( 'result', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-awards',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_result_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Type / Category / File
--------------------------------------------------------*/
function rs_add_result_metabox() {
    add_meta_box(
        'rs_result_details',
        __( 'Result Details', 'rs-madrasha' ),
        'rs_render_result_metabox',
        'result',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_result_metabox' );

function rs_render_result_metabox( $post ) {

    wp_nonce_field( 'rs_result_save', 'rs_result_nonce' );
    wp_enqueue_media();

    $type      = get_post_meta( $post->ID, '_result_type', true ) ?: 'pdf';
    $category  = get_post_meta( $post->ID, '_result_category', true );
    $file_id   = get_post_meta( $post->ID, '_result_file', true );
    $file_url  = $file_id ? wp_get_attachment_url( $file_id ) : '';
    $file_name = $file_id ? basename( get_attached_file( $file_id ) ) : '';

    $cat_options = array(
        'dakhil' => 'দাখিল',
        'alim'   => 'আলিম',
        'fazil'  => 'ফাযিল',
        'kamil'  => 'কামিল',
    );
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e( 'Result Type', 'rs-madrasha' ); ?></label></th>
            <td>
                <label style="margin-right:20px;">
                    <input type="radio" name="result_type" value="pdf" <?php checked( $type, 'pdf' ); ?> class="rs-result-type-toggle">
                    <?php _e( 'PDF (shows in "ফলাফল পিডিএফ" list)', 'rs-madrasha' ); ?>
                </label>
                <label>
                    <input type="radio" name="result_type" value="image" <?php checked( $type, 'image' ); ?> class="rs-result-type-toggle">
                    <?php _e( 'Image (shows in "ফলাফল ছবি" gallery)', 'rs-madrasha' ); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="result_category"><?php _e( 'Category', 'rs-madrasha' ); ?></label></th>
            <td>
                <select name="result_category" id="result_category" class="widefat">
                    <?php foreach ( $cat_options as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $category, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Controls the tag/filter tab (used for both PDF list and Image gallery captions).', 'rs-madrasha' ); ?></p>
            </td>
        </tr>

        <tr class="rs-result-pdf-row">
            <th><label><?php _e( 'PDF File', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="hidden" name="result_file" id="result_file" value="<?php echo esc_attr( $file_id ); ?>">

                <div id="result-file-preview" style="margin-bottom:8px;">
                    <?php if ( $file_url ) : ?>
                        <span class="dashicons dashicons-media-default"></span>
                        <a href="<?php echo esc_url( $file_url ); ?>" target="_blank"><?php echo esc_html( $file_name ); ?></a>
                    <?php else : ?>
                        <em><?php _e( 'No file uploaded yet.', 'rs-madrasha' ); ?></em>
                    <?php endif; ?>
                </div>

                <button type="button" class="button" id="result-upload-btn"><?php _e( 'Select / Upload PDF', 'rs-madrasha' ); ?></button>
                <button type="button" class="button" id="result-remove-btn" style="<?php echo $file_id ? '' : 'display:none;'; ?>"><?php _e( 'Remove File', 'rs-madrasha' ); ?></button>
            </td>
        </tr>

        <tr class="rs-result-image-row">
            <th></th>
            <td>
                <p class="description"><?php _e( 'For Image results, set the picture using the Featured Image box in the sidebar. The Post Title above is used as the caption shown on the image overlay.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
    </table>

    <script>
    (function(){
        var frame;
        var uploadBtn = document.getElementById('result-upload-btn');
        var removeBtn = document.getElementById('result-remove-btn');
        var fileInput = document.getElementById('result_file');
        var preview   = document.getElementById('result-file-preview');
        var toggles   = document.querySelectorAll('.rs-result-type-toggle');
        var pdfRow    = document.querySelector('.rs-result-pdf-row');
        var imgRow    = document.querySelector('.rs-result-image-row');

        function syncRows() {
            var selected = document.querySelector('.rs-result-type-toggle:checked').value;
            pdfRow.style.display = (selected === 'pdf') ? '' : 'none';
            imgRow.style.display = (selected === 'image') ? '' : 'none';
        }
        toggles.forEach(function (t) { t.addEventListener('change', syncRows); });
        syncRows();

        uploadBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }

            frame = wp.media({
                title: '<?php echo esc_js( __( 'Select Result PDF', 'rs-madrasha' ) ); ?>',
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

function rs_save_result_meta( $post_id ) {

    if ( ! isset( $_POST['rs_result_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_result_nonce'], 'rs_result_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['result_type'] ) ) {
        update_post_meta( $post_id, '_result_type', sanitize_text_field( $_POST['result_type'] ) );
    }

    if ( isset( $_POST['result_category'] ) ) {
        update_post_meta( $post_id, '_result_category', sanitize_text_field( $_POST['result_category'] ) );
    }

    if ( isset( $_POST['result_file'] ) ) {
        update_post_meta( $post_id, '_result_file', absint( $_POST['result_file'] ) );
    }
}
add_action( 'save_post_result', 'rs_save_result_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Type / Category / File columns
--------------------------------------------------------*/
function rs_result_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['result_type']     = __( 'Type', 'rs-madrasha' );
            $new_columns['result_category'] = __( 'Category', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_result_posts_columns', 'rs_result_admin_columns' );

function rs_result_admin_column_content( $column, $post_id ) {
    $cat_options = array(
        'dakhil' => 'দাখিল',
        'alim'   => 'আলিম',
        'fazil'  => 'ফাযিল',
        'kamil'  => 'কামিল',
    );

    if ( 'result_type' === $column ) {
        $type = get_post_meta( $post_id, '_result_type', true );
        echo ( 'image' === $type ) ? esc_html__( 'Image', 'rs-madrasha' ) : esc_html__( 'PDF', 'rs-madrasha' );
    }

    if ( 'result_category' === $column ) {
        $cat = get_post_meta( $post_id, '_result_category', true );
        echo isset( $cat_options[ $cat ] ) ? esc_html( $cat_options[ $cat ] ) : '—';
    }
}
add_action( 'manage_result_posts_custom_column', 'rs_result_admin_column_content', 10, 2 );