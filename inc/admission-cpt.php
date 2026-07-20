<?php
/**
 * ==========================================================
 * ADMISSION FORM — Custom Post Type
 * Post Title   => Form/Document Title (e.g. "দাখিল ভর্তি নির্দেশিকা-২০২৬")
 * Meta Fields  => Category (দাখিল/আলিম/ফাযিল/কামিল), Badge Text (optional
 *                 override, e.g. "সাধারণ"), Attached File (PDF/Word/Image)
 * Order        => Drag & drop via Page Attributes (menu_order)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_admission_form_cpt() {

    $labels = array(
        'name'          => __( 'Admission Forms', 'rs-madrasha' ),
        'singular_name' => __( 'Admission Form', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Admission Form', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Admission Form', 'rs-madrasha' ),
        'menu_name'     => __( 'Admission Forms', 'rs-madrasha' ),
    );

    register_post_type( 'admission_form', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-clipboard',
        'supports'      => array( 'title', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_admission_form_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Category / Badge / File Upload
--------------------------------------------------------*/
function rs_add_admission_form_metabox() {
    add_meta_box(
        'rs_admission_form_details',
        __( 'Admission Form Details', 'rs-madrasha' ),
        'rs_render_admission_form_metabox',
        'admission_form',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_admission_form_metabox' );

function rs_render_admission_form_metabox( $post ) {

    wp_nonce_field( 'rs_admission_form_save', 'rs_admission_form_nonce' );
    wp_enqueue_media();

    $category  = get_post_meta( $post->ID, '_admission_category', true );
    $badge     = get_post_meta( $post->ID, '_admission_badge', true );
    $file_id   = get_post_meta( $post->ID, '_admission_file', true );
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
            <th><label for="admission_category"><?php _e( 'Category', 'rs-madrasha' ); ?></label></th>
            <td>
                <select name="admission_category" id="admission_category" class="widefat">
                    <?php foreach ( $cat_options as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $category, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Controls which filter tab this item appears under.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="admission_badge"><?php _e( 'Badge Text (optional)', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="admission_badge" name="admission_badge" class="widefat"
                       value="<?php echo esc_attr( $badge ); ?>"
                       placeholder="<?php esc_attr_e( 'e.g. সাধারণ — leave blank to use the Category label', 'rs-madrasha' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label><?php _e( 'Form File', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="hidden" name="admission_file" id="admission_file" value="<?php echo esc_attr( $file_id ); ?>">

                <div id="admission-file-preview" style="margin-bottom:8px;">
                    <?php if ( $file_url ) : ?>
                        <span class="dashicons dashicons-media-default"></span>
                        <a href="<?php echo esc_url( $file_url ); ?>" target="_blank"><?php echo esc_html( $file_name ); ?></a>
                    <?php else : ?>
                        <em><?php _e( 'No file uploaded yet.', 'rs-madrasha' ); ?></em>
                    <?php endif; ?>
                </div>

                <button type="button" class="button" id="admission-upload-btn"><?php _e( 'Select / Upload File', 'rs-madrasha' ); ?></button>
                <button type="button" class="button" id="admission-remove-btn" style="<?php echo $file_id ? '' : 'display:none;'; ?>"><?php _e( 'Remove File', 'rs-madrasha' ); ?></button>

                <p class="description"><?php _e( 'Accepted formats: PDF, Word (.doc/.docx), Image (jpg/png).', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
    </table>

    <script>
    (function(){
        var frame;
        var uploadBtn = document.getElementById('admission-upload-btn');
        var removeBtn = document.getElementById('admission-remove-btn');
        var fileInput = document.getElementById('admission_file');
        var preview   = document.getElementById('admission-file-preview');

        uploadBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }

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

function rs_save_admission_form_meta( $post_id ) {

    if ( ! isset( $_POST['rs_admission_form_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_admission_form_nonce'], 'rs_admission_form_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['admission_category'] ) ) {
        update_post_meta( $post_id, '_admission_category', sanitize_text_field( $_POST['admission_category'] ) );
    }

    if ( isset( $_POST['admission_badge'] ) ) {
        update_post_meta( $post_id, '_admission_badge', sanitize_text_field( $_POST['admission_badge'] ) );
    }

    if ( isset( $_POST['admission_file'] ) ) {
        update_post_meta( $post_id, '_admission_file', absint( $_POST['admission_file'] ) );
    }
}
add_action( 'save_post_admission_form', 'rs_save_admission_form_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Category & File columns
--------------------------------------------------------*/
function rs_admission_form_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['admission_category'] = __( 'Category', 'rs-madrasha' );
            $new_columns['admission_file']     = __( 'File', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_admission_form_posts_columns', 'rs_admission_form_admin_columns' );

function rs_admission_form_admin_column_content( $column, $post_id ) {
    $cat_options = array(
        'dakhil' => 'দাখিল',
        'alim'   => 'আলিম',
        'fazil'  => 'ফাযিল',
        'kamil'  => 'কামিল',
    );

    if ( 'admission_category' === $column ) {
        $cat = get_post_meta( $post_id, '_admission_category', true );
        echo isset( $cat_options[ $cat ] ) ? esc_html( $cat_options[ $cat ] ) : '—';
    }

    if ( 'admission_file' === $column ) {
        $file_id = get_post_meta( $post_id, '_admission_file', true );
        if ( $file_id ) {
            echo '<a href="' . esc_url( wp_get_attachment_url( $file_id ) ) . '" target="_blank">' .
                 esc_html( basename( get_attached_file( $file_id ) ) ) . '</a>';
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_admission_form_posts_custom_column', 'rs_admission_form_admin_column_content', 10, 2 );