<?php
/**
 * ==========================================================
 * MADRASHA HISTORY — Custom Post Type
 * Post Title      => Accordion Heading (e.g. "১৯৪৬ — সূচনা")
 * Post Content    => Accordion Body (description)
 * Order           => Drag & drop via Page Attributes (menu_order)
 * ==========================================================
 */

function rs_register_madrasha_history_cpt() {

    $labels = array(
        'name'          => __( 'Madrasha History', 'rs-madrasha' ),
        'singular_name' => __( 'History Item', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New History Item', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit History Item', 'rs-madrasha' ),
        'menu_name'     => __( 'Madrasha History', 'rs-madrasha' ),
    );

    register_post_type( 'madrasha_history', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-backup',
        'supports'      => array( 'title', 'editor', 'page-attributes' ), // editor = description box
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_madrasha_history_cpt' );


/*--------------------------------------------------------
    Make the default "editor" box smaller & labeled
    (optional UX polish — safe to remove if not wanted)
--------------------------------------------------------*/
function rs_history_editor_settings( $settings ) {
    global $post_type;
    if ( 'madrasha_history' === $post_type ) {
        $settings['media_buttons'] = false;
        $settings['textarea_rows'] = 5;
    }
    return $settings;
}
add_filter( 'wp_editor_settings', 'rs_history_editor_settings' );


/*--------------------------------------------------------
    Rename "Content" label to "Description" for clarity
--------------------------------------------------------*/
function rs_history_rename_editor_label() {
    global $post_type;
    if ( 'madrasha_history' === $post_type ) {
        echo '<style>
            #postdivrich .wp-editor-tabs { position: relative; }
            #postdivrich:before {
                content: "' . esc_js( __( 'Description', 'rs-madrasha' ) ) . '";
                display: block;
                font-weight: 600;
                margin-bottom: 8px;
                font-size: 14px;
            }
        </style>';
    }
}
add_action( 'edit_form_after_title', 'rs_history_rename_editor_label' );