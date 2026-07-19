<?php
/**
 * ==========================================================
 * NOTICE — Custom Post Type
 * Post Title   => Notice Title
 * Post Date    => Notice Date (native WP publish date)
 * Meta Fields  => Department (dept), Attached File (pdf/word/image)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_notice_cpt() {

    $labels = array(
        'name'          => __( 'Notices', 'rs-madrasha' ),
        'singular_name' => __( 'Notice', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Notice', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Notice', 'rs-madrasha' ),
        'menu_name'     => __( 'Notices', 'rs-madrasha' ),
    );

    register_post_type( 'notice', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-megaphone',
        'supports'      => array( 'title' ),
        'has_archive'   => true,
        'rewrite'       => array( 'slug' => 'notice' ),
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_notice_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Department + File Upload
--------------------------------------------------------*/
function rs_add_notice_metabox() {
    add_meta_box(
        'rs_notice_details',
        __( 'Notice Details', 'rs-madrasha' ),
        'rs_render_notice_metabox',
        'notice',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_notice_metabox' );

function rs_render_notice_metabox( $post ) {

    wp_nonce_field( 'rs_notice_save', 'rs_notice_nonce' );
    wp_enqueue_media();

    $dept      = get_post_meta( $post->ID, '_notice_dept', true );
    $tag_label = get_post_meta( $post->ID, '_notice_tag_label', true );
    $file_id   = get_post_meta( $post->ID, '_notice_file', true );
    $file_url  = $file_id ? wp_get_attachment_url( $file_id ) : '';
    $file_name = $file_id ? basename( get_attached_file( $file_id ) ) : '';

    $dept_options = array(
        'dakhil'    => 'দাখিল',
        'alim'      => 'আলিম',
        'fazil'     => 'ফাযিল',
        'kamil'     => 'কামিল',
        'admission' => 'ভর্তি (Admission)',
    );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="notice_dept"><?php _e( 'Category', 'rs-madrasha' ); ?></label></th>
            <td>
                <select name="notice_dept" id="notice_dept" class="widefat">
                    <?php foreach ( $dept_options as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $dept, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Controls which filter tab this notice appears under.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="notice_tag_label"><?php _e( 'Badge Text (optional)', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="notice_tag_label" name="notice_tag_label" class="widefat"
                       value="<?php echo esc_attr( $tag_label ); ?>" placeholder="<?php esc_attr_e( 'e.g. সাধারণ — leave blank to use the Category label', 'rs-madrasha' ); ?>">
                <p class="description"><?php _e( 'Overrides the small colored tag shown next to the notice title, without changing which filter tab it appears under.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label><?php _e( 'Notice File', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="hidden" name="notice_file" id="notice_file" value="<?php echo esc_attr( $file_id ); ?>">

                <div id="notice-file-preview" style="margin-bottom:8px;">
                    <?php if ( $file_url ) : ?>
                        <span class="dashicons dashicons-media-default"></span>
                        <a href="<?php echo esc_url( $file_url ); ?>" target="_blank"><?php echo esc_html( $file_name ); ?></a>
                    <?php else : ?>
                        <em><?php _e( 'No file uploaded yet.', 'rs-madrasha' ); ?></em>
                    <?php endif; ?>
                </div>

                <button type="button" class="button" id="notice-upload-btn">
                    <?php _e( 'Select / Upload File', 'rs-madrasha' ); ?>
                </button>
                <button type="button" class="button" id="notice-remove-btn" style="<?php echo $file_id ? '' : 'display:none;'; ?>">
                    <?php _e( 'Remove File', 'rs-madrasha' ); ?>
                </button>

                <p class="description"><?php _e( 'Accepted formats: PDF, Word (.doc/.docx), Image (jpg/png).', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
    </table>

    <script>
    (function(){
        var frame;
        var uploadBtn  = document.getElementById('notice-upload-btn');
        var removeBtn  = document.getElementById('notice-remove-btn');
        var fileInput  = document.getElementById('notice_file');
        var preview    = document.getElementById('notice-file-preview');

        uploadBtn.addEventListener('click', function (e) {
            e.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: '<?php echo esc_js( __( 'Select Notice File', 'rs-madrasha' ) ); ?>',
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

function rs_save_notice_meta( $post_id ) {

    if ( ! isset( $_POST['rs_notice_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_notice_nonce'], 'rs_notice_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['notice_dept'] ) ) {
        update_post_meta( $post_id, '_notice_dept', sanitize_text_field( $_POST['notice_dept'] ) );
    }

    if ( isset( $_POST['notice_tag_label'] ) ) {
        update_post_meta( $post_id, '_notice_tag_label', sanitize_text_field( $_POST['notice_tag_label'] ) );
    }

    if ( isset( $_POST['notice_file'] ) ) {
        update_post_meta( $post_id, '_notice_file', absint( $_POST['notice_file'] ) );
    }
}
add_action( 'save_post_notice', 'rs_save_notice_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Department + Date columns
--------------------------------------------------------*/
function rs_notice_admin_columns( $columns ) {
    $new_columns = array();

    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;

        // Insert Department right after Title
        if ( 'title' === $key ) {
            $new_columns['notice_dept'] = __( 'Department', 'rs-madrasha' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_notice_posts_columns', 'rs_notice_admin_columns' );

function rs_notice_admin_column_content( $column, $post_id ) {
    if ( 'notice_dept' === $column ) {
        $dept_labels = array(
            'dakhil' => 'দাখিল',
            'alim'   => 'আলিম',
            'fazil'  => 'ফাযিল',
            'kamil'  => 'কামিল',
        );
        $dept = get_post_meta( $post_id, '_notice_dept', true );
        echo isset( $dept_labels[ $dept ] ) ? esc_html( $dept_labels[ $dept ] ) : '—';
    }
}
add_action( 'manage_notice_posts_custom_column', 'rs_notice_admin_column_content', 10, 2 );

// Make Department column sortable
function rs_notice_sortable_columns( $columns ) {
    $columns['notice_dept'] = 'notice_dept';
    return $columns;
}
add_filter( 'manage_edit-notice_sortable_columns', 'rs_notice_sortable_columns' );

function rs_notice_sortable_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( 'notice_dept' === $query->get( 'orderby' ) ) {
        $query->set( 'meta_key', '_notice_dept' );
        $query->set( 'orderby', 'meta_value' );
    }
}
add_action( 'pre_get_posts', 'rs_notice_sortable_orderby' );


/*--------------------------------------------------------
    4) Restrict Media Library type list shown in the modal
       (extra safety net alongside the JS `library.type` filter)
--------------------------------------------------------*/
function rs_allowed_notice_mimes( $mimes ) {
    return array(
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png'  => 'image/png',
    );
}
// NOTE: only hook this if you want to globally restrict uploads to these types.
// Left commented out since it would affect the whole media library, not just Notices.
// add_filter( 'upload_mimes', 'rs_allowed_notice_mimes' );