<?php
/**
 * ==========================================================
 * COMMITTEE — Custom Post Type
 * Post Title   => Member Name (নাম)
 * Meta Fields  => Designation (পদবি), Responsibility (দায়িত্ব)
 * Order        => Drag & drop via Page Attributes (menu_order)
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_committee_cpt() {

    $labels = array(
        'name'          => __( 'Committee', 'rs-madrasha' ),
        'singular_name' => __( 'Committee Member', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Committee Member', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Committee Member', 'rs-madrasha' ),
        'menu_name'     => __( 'Committee', 'rs-madrasha' ),
    );

    register_post_type( 'committee', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-groups',
        'supports'      => array( 'title', 'page-attributes' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_committee_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Designation + Responsibility
--------------------------------------------------------*/
function rs_add_committee_metabox() {
    add_meta_box(
        'rs_committee_details',
        __( 'Committee Member Details', 'rs-madrasha' ),
        'rs_render_committee_metabox',
        'committee',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_committee_metabox' );

function rs_render_committee_metabox( $post ) {

    wp_nonce_field( 'rs_committee_save', 'rs_committee_nonce' );

    $designation   = get_post_meta( $post->ID, '_committee_designation', true );
    $responsibility = get_post_meta( $post->ID, '_committee_responsibility', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="committee_designation"><?php _e( 'Designation (পদবি)', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="committee_designation" name="committee_designation" class="widefat"
                       value="<?php echo esc_attr( $designation ); ?>"
                       placeholder="<?php esc_attr_e( 'প্রতিষ্ঠাতা ও সভাপতি', 'rs-madrasha' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="committee_responsibility"><?php _e( 'Responsibility (দায়িত্ব)', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="committee_responsibility" name="committee_responsibility" class="widefat"
                       value="<?php echo esc_attr( $responsibility ); ?>"
                       placeholder="<?php esc_attr_e( 'পরিচালনা কমিটি', 'rs-madrasha' ); ?>">
            </td>
        </tr>
    </table>
    <p class="description">
        <?php _e( 'Use Page Attributes → Order (in the sidebar) to control the row order in the table.', 'rs-madrasha' ); ?>
    </p>
    <?php
}

function rs_save_committee_meta( $post_id ) {

    if ( ! isset( $_POST['rs_committee_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_committee_nonce'], 'rs_committee_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['committee_designation'] ) ) {
        update_post_meta( $post_id, '_committee_designation', sanitize_text_field( $_POST['committee_designation'] ) );
    }

    if ( isset( $_POST['committee_responsibility'] ) ) {
        update_post_meta( $post_id, '_committee_responsibility', sanitize_text_field( $_POST['committee_responsibility'] ) );
    }
}
add_action( 'save_post_committee', 'rs_save_committee_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Designation & Responsibility columns
--------------------------------------------------------*/
function rs_committee_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['committee_designation']   = __( 'Designation', 'rs-madrasha' );
            $new_columns['committee_responsibility'] = __( 'Responsibility', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_committee_posts_columns', 'rs_committee_admin_columns' );

function rs_committee_admin_column_content( $column, $post_id ) {
    if ( 'committee_designation' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_committee_designation', true ) );
    }
    if ( 'committee_responsibility' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_committee_responsibility', true ) );
    }
}
add_action( 'manage_committee_posts_custom_column', 'rs_committee_admin_column_content', 10, 2 );