<?php
/**
 * ==========================================================
 * MADRASHA FEATURE — Custom Post Type + Repeater Meta Box
 * Post Title  => used as the Section Title (e.g. "কেন কাউনিয়া বালিকা ফাজিল")
 * Repeater    => Icon (Bootstrap Icon class), Title, Description
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_madrasha_feature_cpt() {

    $labels = array(
        'name'               => __( 'Madrasha Features', 'rs-madrasha' ),
        'singular_name'      => __( 'Madrasha Feature', 'rs-madrasha' ),
        'add_new_item'       => __( 'Add New Feature Section', 'rs-madrasha' ),
        'edit_item'          => __( 'Edit Feature Section', 'rs-madrasha' ),
        'menu_name'          => __( 'Madrasha Features', 'rs-madrasha' ),
    );

    register_post_type( 'madrasha_feature', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-star-filled',
        'supports'      => array( 'title' ), // Title = Section Title
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_madrasha_feature_cpt' );


/*--------------------------------------------------------
    2) Add Repeater Meta Box
--------------------------------------------------------*/
function rs_add_feature_repeater_metabox() {
    add_meta_box(
        'rs_feature_repeater',
        __( 'Feature Items (Icon / Title / Description)', 'rs-madrasha' ),
        'rs_render_feature_repeater_metabox',
        'madrasha_feature',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_feature_repeater_metabox' );


function rs_render_feature_repeater_metabox( $post ) {

    wp_nonce_field( 'rs_feature_repeater_save', 'rs_feature_repeater_nonce' );

    $items = get_post_meta( $post->ID, '_rs_feature_items', true );
    if ( ! is_array( $items ) || empty( $items ) ) {
        $items = array(
            array( 'icon' => 'bi bi-star', 'title' => '', 'desc' => '' ),
        );
    }
    ?>

    <style>
        .rs-repeater-row{display:flex;gap:10px;align-items:flex-start;border:1px solid #dcdcde;padding:12px;margin-bottom:10px;background:#fff;border-radius:4px;}
        .rs-repeater-row .rs-field{display:flex;flex-direction:column;}
        .rs-repeater-row .rs-field label{font-weight:600;font-size:12px;margin-bottom:3px;}
        .rs-repeater-row .rs-icon{width:160px;}
        .rs-repeater-row .rs-title{width:220px;}
        .rs-repeater-row .rs-desc{flex:1;}
        .rs-repeater-row textarea{height:38px;resize:vertical;}
        .rs-remove-row{background:#dc3232;border:none;color:#fff;border-radius:3px;width:32px;height:32px;align-self:center;cursor:pointer;}
        .rs-repeater-row .rs-icon-preview{font-size:20px;margin-top:4px;color:#2271b1;}
    </style>

    <div id="rs-repeater-wrap">
        <?php foreach ( $items as $i => $item ) : ?>
            <div class="rs-repeater-row">
                <div class="rs-field rs-icon">
                    <label><?php _e( 'Icon Class', 'rs-madrasha' ); ?></label>
                    <input type="text" class="widefat rs-icon-input"
                           name="rs_feature_items[<?php echo esc_attr( $i ); ?>][icon]"
                           value="<?php echo esc_attr( $item['icon'] ); ?>"
                           placeholder="bi bi-book-half">
                    <i class="<?php echo esc_attr( $item['icon'] ); ?> rs-icon-preview"></i>
                </div>
                <div class="rs-field rs-title">
                    <label><?php _e( 'Title', 'rs-madrasha' ); ?></label>
                    <input type="text" class="widefat"
                           name="rs_feature_items[<?php echo esc_attr( $i ); ?>][title]"
                           value="<?php echo esc_attr( $item['title'] ); ?>"
                           placeholder="কুরআন-হাদিস শিক্ষা">
                </div>
                <div class="rs-field rs-desc">
                    <label><?php _e( 'Description', 'rs-madrasha' ); ?></label>
                    <textarea class="widefat"
                              name="rs_feature_items[<?php echo esc_attr( $i ); ?>][desc]"
                              placeholder="নূরানী থেকে কামিল পর্যন্ত মানসম্মত দ্বীনি শিক্ষা"><?php echo esc_textarea( $item['desc'] ); ?></textarea>
                </div>
                <button type="button" class="rs-remove-row" title="<?php esc_attr_e( 'Remove', 'rs-madrasha' ); ?>">&times;</button>
            </div>
        <?php endforeach; ?>
    </div>

    <p>
        <button type="button" class="button button-primary" id="rs-add-row">
            + <?php _e( 'Add Feature Item', 'rs-madrasha' ); ?>
        </button>
    </p>

    <!-- Hidden template row for cloning -->
    <div class="rs-repeater-row" id="rs-row-template" style="display:none;">
        <div class="rs-field rs-icon">
            <label><?php _e( 'Icon Class', 'rs-madrasha' ); ?></label>
            <input type="text" class="widefat rs-icon-input" name="rs_feature_items[__INDEX__][icon]" placeholder="bi bi-book-half">
            <i class="rs-icon-preview"></i>
        </div>
        <div class="rs-field rs-title">
            <label><?php _e( 'Title', 'rs-madrasha' ); ?></label>
            <input type="text" class="widefat" name="rs_feature_items[__INDEX__][title]" placeholder="শিরোনাম">
        </div>
        <div class="rs-field rs-desc">
            <label><?php _e( 'Description', 'rs-madrasha' ); ?></label>
            <textarea class="widefat" name="rs_feature_items[__INDEX__][desc]" placeholder="বিবরণ"></textarea>
        </div>
        <button type="button" class="rs-remove-row">&times;</button>
    </div>

    <script>
    (function(){
        var wrap   = document.getElementById('rs-repeater-wrap');
        var addBtn = document.getElementById('rs-add-row');
        var template = document.getElementById('rs-row-template');
        var index = <?php echo (int) count( $items ); ?>;

        function bindIconPreview(row) {
            var iconInput = row.querySelector('.rs-icon-input');
            var preview   = row.querySelector('.rs-icon-preview');
            iconInput.addEventListener('input', function () {
                preview.className = iconInput.value + ' rs-icon-preview';
            });
        }

        function bindRemove(row) {
            row.querySelector('.rs-remove-row').addEventListener('click', function () {
                if (wrap.querySelectorAll('.rs-repeater-row').length > 1) {
                    row.remove();
                } else {
                    row.querySelectorAll('input, textarea').forEach(function (f) { f.value = ''; });
                }
            });
        }

        // Bind existing rows
        wrap.querySelectorAll('.rs-repeater-row').forEach(function (row) {
            bindIconPreview(row);
            bindRemove(row);
        });

        addBtn.addEventListener('click', function () {
            var clone = template.cloneNode(true);
            clone.style.display = '';
            clone.removeAttribute('id');
            clone.innerHTML = clone.innerHTML.replace(/__INDEX__/g, index);
            wrap.appendChild(clone);
            bindIconPreview(clone);
            bindRemove(clone);
            index++;
        });
    })();
    </script>
    <?php
}


/*--------------------------------------------------------
    3) Save Repeater Data
--------------------------------------------------------*/
function rs_save_feature_repeater( $post_id ) {

    if ( ! isset( $_POST['rs_feature_repeater_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_feature_repeater_nonce'], 'rs_feature_repeater_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( ! isset( $_POST['rs_feature_items'] ) || ! is_array( $_POST['rs_feature_items'] ) ) {
        delete_post_meta( $post_id, '_rs_feature_items' );
        return;
    }

    $clean_items = array();

    foreach ( $_POST['rs_feature_items'] as $item ) {

        $icon  = isset( $item['icon'] ) ? sanitize_text_field( $item['icon'] ) : '';
        $title = isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
        $desc  = isset( $item['desc'] ) ? sanitize_textarea_field( $item['desc'] ) : '';

        // Skip completely empty rows
        if ( '' === $icon && '' === $title && '' === $desc ) {
            continue;
        }

        $clean_items[] = array(
            'icon'  => $icon,
            'title' => $title,
            'desc'  => $desc,
        );
    }

    update_post_meta( $post_id, '_rs_feature_items', $clean_items );
}
add_action( 'save_post_madrasha_feature', 'rs_save_feature_repeater' );