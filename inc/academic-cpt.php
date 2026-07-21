<?php
/**
 * ==========================================================
 * ACADEMIC PROGRAM — Custom Post Type
 * Post Title   => Program Name (e.g. "দাখিল")
 * Meta Fields  => Band Color, Description, Link URL
 * Order        => Drag & drop via Page Attributes (menu_order)
 * Also includes: Section Heading/Subtitle via Customizer
 * (the fixed title above the repeatable card grid)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_academic_program_cpt() {

    $labels = array(
        'name'          => __( 'Academic Programs', 'rs-madrasha' ),
        'singular_name' => __( 'Academic Program', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Program', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Program', 'rs-madrasha' ),
        'menu_name'     => __( 'Academic Programs', 'rs-madrasha' ),
    );

    register_post_type( 'academic_program', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-welcome-learn-more',
        'supports'      => array( 'title', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_academic_program_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Band Color / Description / Link
--------------------------------------------------------*/
function rs_add_academic_program_metabox() {
    add_meta_box(
        'rs_academic_program_details',
        __( 'Program Details', 'rs-madrasha' ),
        'rs_render_academic_program_metabox',
        'academic_program',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_academic_program_metabox' );

function rs_render_academic_program_metabox( $post ) {

    wp_nonce_field( 'rs_academic_program_save', 'rs_academic_program_nonce' );

    $band_type   = get_post_meta( $post->ID, '_program_band_type', true ) ?: 'preset';
    $band_preset = get_post_meta( $post->ID, '_program_band_preset', true ) ?: 'rose';
    $band_custom = get_post_meta( $post->ID, '_program_band_custom', true ) ?: '#c0392b';
    $description = get_post_meta( $post->ID, '_program_description', true );
    $link_url    = get_post_meta( $post->ID, '_program_link', true );

    $preset_options = array(
        'rose'   => __( 'Rose', 'rs-madrasha' ),
        'green'  => __( 'Green', 'rs-madrasha' ),
        'orange' => __( 'Orange', 'rs-madrasha' ),
        'navy'   => __( 'Navy', 'rs-madrasha' ),
    );
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e( 'Band Color', 'rs-madrasha' ); ?></label></th>
            <td>
                <label style="margin-right:16px;">
                    <input type="radio" name="program_band_type" value="preset" <?php checked( $band_type, 'preset' ); ?> class="rs-band-type-toggle">
                    <?php _e( 'Use theme color', 'rs-madrasha' ); ?>
                </label>
                <label>
                    <input type="radio" name="program_band_type" value="custom" <?php checked( $band_type, 'custom' ); ?> class="rs-band-type-toggle">
                    <?php _e( 'Custom color', 'rs-madrasha' ); ?>
                </label>

                <div id="rs-band-preset-row" style="margin-top:10px;">
                    <select name="program_band_preset" class="widefat" style="max-width:200px;">
                        <?php foreach ( $preset_options as $slug => $label ) : ?>
                            <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $band_preset, $slug ); ?>>
                                <?php echo esc_html( $label ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="rs-band-custom-row" style="margin-top:10px;">
                    <input type="text" name="program_band_custom" value="<?php echo esc_attr( $band_custom ); ?>" class="rs-color-picker">
                </div>
            </td>
        </tr>
        <tr>
            <th><label for="program_description"><?php _e( 'Description', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="program_description" name="program_description" class="widefat"
                       value="<?php echo esc_attr( $description ); ?>"
                       placeholder="<?php esc_attr_e( '৬ষ্ঠ থেকে ১০ম শ্রেণি — মাধ্যমিক স্তর', 'rs-madrasha' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="program_link"><?php _e( 'Link URL', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="url" id="program_link" name="program_link" class="widefat"
                       value="<?php echo esc_attr( $link_url ); ?>" placeholder="https://yoursite.com/notice">
                <p class="description"><?php _e( 'Where "বিস্তারিত »" should link to.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
    </table>

    <?php wp_enqueue_script( 'wp-color-picker' ); wp_enqueue_style( 'wp-color-picker' ); ?>
    <script>
    (function(){
        if (window.jQuery && jQuery.fn.wpColorPicker) {
            jQuery('.rs-color-picker').wpColorPicker();
        }

        var toggles    = document.querySelectorAll('.rs-band-type-toggle');
        var presetRow  = document.getElementById('rs-band-preset-row');
        var customRow  = document.getElementById('rs-band-custom-row');

        function syncRows() {
            var selected = document.querySelector('.rs-band-type-toggle:checked').value;
            presetRow.style.display = (selected === 'preset') ? '' : 'none';
            customRow.style.display = (selected === 'custom') ? '' : 'none';
        }
        toggles.forEach(function (t) { t.addEventListener('change', syncRows); });
        syncRows();
    })();
    </script>
    <?php
}

function rs_save_academic_program_meta( $post_id ) {

    if ( ! isset( $_POST['rs_academic_program_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_academic_program_nonce'], 'rs_academic_program_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['program_band_type'] ) ) {
        update_post_meta( $post_id, '_program_band_type', sanitize_text_field( $_POST['program_band_type'] ) );
    }

    if ( isset( $_POST['program_band_preset'] ) ) {
        update_post_meta( $post_id, '_program_band_preset', sanitize_text_field( $_POST['program_band_preset'] ) );
    }

    if ( isset( $_POST['program_band_custom'] ) ) {
        update_post_meta( $post_id, '_program_band_custom', sanitize_hex_color( $_POST['program_band_custom'] ) );
    }

    if ( isset( $_POST['program_description'] ) ) {
        update_post_meta( $post_id, '_program_description', sanitize_text_field( $_POST['program_description'] ) );
    }

    if ( isset( $_POST['program_link'] ) ) {
        update_post_meta( $post_id, '_program_link', esc_url_raw( $_POST['program_link'] ) );
    }
}
add_action( 'save_post_academic_program', 'rs_save_academic_program_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Color / Description columns
--------------------------------------------------------*/
function rs_academic_program_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['program_color']       = __( 'Color', 'rs-madrasha' );
            $new_columns['program_description'] = __( 'Description', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_academic_program_posts_columns', 'rs_academic_program_admin_columns' );

function rs_academic_program_admin_column_content( $column, $post_id ) {
    if ( 'program_color' === $column ) {
        $type = get_post_meta( $post_id, '_program_band_type', true );
        $color = ( 'custom' === $type )
            ? get_post_meta( $post_id, '_program_band_custom', true )
            : get_post_meta( $post_id, '_program_band_preset', true );
        echo '<span style="display:inline-block;width:16px;height:16px;border-radius:3px;vertical-align:middle;margin-right:6px;background:' . esc_attr( $color ) . ';"></span>' . esc_html( $color );
    }

    if ( 'program_description' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_program_description', true ) ?: '—' );
    }
}
add_action( 'manage_academic_program_posts_custom_column', 'rs_academic_program_admin_column_content', 10, 2 );


/*--------------------------------------------------------
    4) Section Heading/Subtitle — Customizer
       (the fixed title above the repeatable card grid)
--------------------------------------------------------*/
function rs_academic_program_section_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_academic_program_section', array(
        'title'    => __( 'Academic Programs Section', 'rs-madrasha' ),
        'priority' => 103,
    ) );

    $wp_customize->add_setting( 'rs_program_section_title', array(
        'default'           => 'শিক্ষা কার্যক্রম',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_program_section_title', array(
        'label'   => __( 'Section Title', 'rs-madrasha' ),
        'section' => 'rs_academic_program_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'rs_program_section_subtitle', array(
        'default'           => 'ইবতেদায়ী থেকে কামিল মাস্টার্স পর্যন্ত সকল স্তরের পাঠদান',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rs_program_section_subtitle', array(
        'label'   => __( 'Section Subtitle', 'rs-madrasha' ),
        'section' => 'rs_academic_program_section',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'rs_academic_program_section_customizer' );