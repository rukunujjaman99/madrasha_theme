<?php
/**
 * ==========================================================
 * BEST STUDENT — Custom Post Type + Meta Fields
 * Post Title      => Student Name
 * Featured Image  => Student Photo
 * Meta Fields     => Department (dept), Result/Badge, Roll
 * Section Title/Subtitle => via Customizer (applies to whole section)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_student_cpt() {

    $labels = array(
        'name'          => __( 'Best Students', 'rs-madrasha' ),
        'singular_name' => __( 'Student', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Student', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Student', 'rs-madrasha' ),
        'menu_name'     => __( 'Best Students', 'rs-madrasha' ),
    );

    register_post_type( 'student', array(
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
add_action( 'init', 'rs_register_student_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Department / Result / Roll
--------------------------------------------------------*/
function rs_add_student_metabox() {
    add_meta_box(
        'rs_student_details',
        __( 'Student Details', 'rs-madrasha' ),
        'rs_render_student_metabox',
        'student',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_student_metabox' );

function rs_render_student_metabox( $post ) {

    wp_nonce_field( 'rs_student_save', 'rs_student_nonce' );

    $dept   = get_post_meta( $post->ID, '_student_dept', true );
    $result = get_post_meta( $post->ID, '_student_result', true );
    $roll   = get_post_meta( $post->ID, '_student_roll', true );

    $dept_options = array(
        'dakhil' => 'দাখিল',
        'alim'   => 'আলিম',
        'fazil'  => 'ফাযিল',
        'kamil'  => 'কামিল',
    );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="student_dept"><?php _e( 'Department', 'rs-madrasha' ); ?></label></th>
            <td>
                <select name="student_dept" id="student_dept" class="widefat">
                    <?php foreach ( $dept_options as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $dept, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="student_result"><?php _e( 'Result / Badge Text', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="student_result" name="student_result" class="widefat"
                       value="<?php echo esc_attr( $result ); ?>" placeholder="জিপিএ ৫.০০ / ১ম শ্রেণি, ১ম স্থান">
            </td>
        </tr>
        <tr>
            <th><label for="student_roll"><?php _e( 'Roll Number', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="student_roll" name="student_roll" class="widefat"
                       value="<?php echo esc_attr( $roll ); ?>" placeholder="রোল: ০১">
            </td>
        </tr>
    </table>
    <p class="description">
        <?php _e( 'Set the student photo using the Featured Image box.', 'rs-madrasha' ); ?>
    </p>
    <?php
}

function rs_save_student_meta( $post_id ) {

    if ( ! isset( $_POST['rs_student_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_student_nonce'], 'rs_student_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['student_dept'] ) ) {
        update_post_meta( $post_id, '_student_dept', sanitize_text_field( $_POST['student_dept'] ) );
    }

    if ( isset( $_POST['student_result'] ) ) {
        update_post_meta( $post_id, '_student_result', sanitize_text_field( $_POST['student_result'] ) );
    }

    if ( isset( $_POST['student_roll'] ) ) {
        update_post_meta( $post_id, '_student_roll', sanitize_text_field( $_POST['student_roll'] ) );
    }
}
add_action( 'save_post_student', 'rs_save_student_meta' );


/*--------------------------------------------------------
    3) Customizer: Section Title & Subtitle
--------------------------------------------------------*/
function rs_student_section_customizer( $wp_customize ) {

    $wp_customize->add_section( 'rs_student_section', array(
        'title'    => __( 'Best Students Section', 'rs-madrasha' ),
        'priority' => 95,
    ) );

    // Section Title
    $wp_customize->add_setting( 'rs_student_title', array(
        'default'           => 'এ বছরের সেরা শিক্ষার্থী',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_student_title', array(
        'label'   => __( 'Section Title', 'rs-madrasha' ),
        'section' => 'rs_student_section',
        'type'    => 'text',
    ) );

    // Section Subtitle
    $wp_customize->add_setting( 'rs_student_subtitle', array(
        'default'           => 'বিভাগ অনুযায়ী ফিল্টার করুন, বিস্তারিত দেখতে ছবিতে ক্লিক করুন',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rs_student_subtitle', array(
        'label'   => __( 'Section Subtitle', 'rs-madrasha' ),
        'section' => 'rs_student_section',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'rs_student_section_customizer' );


?>