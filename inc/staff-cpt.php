<?php
/**
 * ==========================================================
 * STAFF — Custom Post Type
 * Post Title      => Staff Name
 * Featured Image  => Staff Photo (optional — falls back to avatar-initial)
 * Meta Fields     => Designation, Qualification (optional), Department, Phone
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_staff_cpt() {

    $labels = array(
        'name'          => __( 'Staff', 'rs-madrasha' ),
        'singular_name' => __( 'Staff Member', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Staff Member', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Staff Member', 'rs-madrasha' ),
        'menu_name'     => __( 'Staff', 'rs-madrasha' ),
    );

    register_post_type( 'staff', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-groups',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_staff_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Designation / Qualification / Department / Phone
--------------------------------------------------------*/
function rs_add_staff_metabox() {
    add_meta_box(
        'rs_staff_details',
        __( 'Staff Details', 'rs-madrasha' ),
        'rs_render_staff_metabox',
        'staff',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_staff_metabox' );

function rs_render_staff_metabox( $post ) {

    wp_nonce_field( 'rs_staff_save', 'rs_staff_nonce' );

    $designation  = get_post_meta( $post->ID, '_staff_designation', true );
    $qualification = get_post_meta( $post->ID, '_staff_qualification', true );
    $dept         = get_post_meta( $post->ID, '_staff_dept', true );
    $phone        = get_post_meta( $post->ID, '_staff_phone', true );

    $dept_options = array(
        'kormokorta' => 'কর্মকর্তা',
        'kormochari' => 'কর্মচারী',
    );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="staff_designation"><?php _e( 'Designation', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="staff_designation" name="staff_designation" class="widefat"
                       value="<?php echo esc_attr( $designation ); ?>"
                       placeholder="<?php esc_attr_e( 'অফিস সহ-কাম হিসাব সহকারী', 'rs-madrasha' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="staff_qualification"><?php _e( 'Qualification (optional)', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="staff_qualification" name="staff_qualification" class="widefat"
                       value="<?php echo esc_attr( $qualification ); ?>"
                       placeholder="<?php esc_attr_e( 'কামিল হাদীস (১ম শ্রেণি)', 'rs-madrasha' ); ?>">
                <p class="description"><?php _e( 'Leave blank if not applicable — it will simply be skipped on the site.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="staff_dept"><?php _e( 'Department', 'rs-madrasha' ); ?></label></th>
            <td>
                <select name="staff_dept" id="staff_dept" class="widefat">
                    <?php foreach ( $dept_options as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $dept, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="staff_phone"><?php _e( 'Phone Number', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="staff_phone" name="staff_phone" class="widefat"
                       value="<?php echo esc_attr( $phone ); ?>" placeholder="০১৭৪৪-৪২৭১৯৩">
            </td>
        </tr>
    </table>
    <p class="description">
        <?php _e( 'Featured Image is optional. If not set, the site will show a circular avatar with the first letter of the name instead.', 'rs-madrasha' ); ?>
    </p>
    <?php
}

function rs_save_staff_meta( $post_id ) {

    if ( ! isset( $_POST['rs_staff_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_staff_nonce'], 'rs_staff_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['staff_designation'] ) ) {
        update_post_meta( $post_id, '_staff_designation', sanitize_text_field( $_POST['staff_designation'] ) );
    }

    if ( isset( $_POST['staff_qualification'] ) ) {
        update_post_meta( $post_id, '_staff_qualification', sanitize_text_field( $_POST['staff_qualification'] ) );
    }

    if ( isset( $_POST['staff_dept'] ) ) {
        update_post_meta( $post_id, '_staff_dept', sanitize_text_field( $_POST['staff_dept'] ) );
    }

    if ( isset( $_POST['staff_phone'] ) ) {
        update_post_meta( $post_id, '_staff_phone', sanitize_text_field( $_POST['staff_phone'] ) );
    }
}
add_action( 'save_post_staff', 'rs_save_staff_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Designation & Department columns
--------------------------------------------------------*/
function rs_staff_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['staff_designation'] = __( 'Designation', 'rs-madrasha' );
            $new_columns['staff_dept']        = __( 'Department', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_staff_posts_columns', 'rs_staff_admin_columns' );

function rs_staff_admin_column_content( $column, $post_id ) {
    if ( 'staff_designation' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_staff_designation', true ) );
    }

    if ( 'staff_dept' === $column ) {
        $dept_options = array(
            'kormokorta' => 'কর্মকর্তা',
            'kormochari' => 'কর্মচারী',
        );
        $dept = get_post_meta( $post_id, '_staff_dept', true );
        echo isset( $dept_options[ $dept ] ) ? esc_html( $dept_options[ $dept ] ) : '—';
    }
}
add_action( 'manage_staff_posts_custom_column', 'rs_staff_admin_column_content', 10, 2 );