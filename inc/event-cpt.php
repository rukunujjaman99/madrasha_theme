<?php
/**
 * ==========================================================
 * EVENT PROGRAM — Custom Post Type
 * Post Title   => Event Title (e.g. "নতুন শিক্ষাবর্ষ ১৪৪৮ হিজরী উদ্বোধন")
 * Meta Fields  => Eyebrow Label, Display Text (date/location line),
 *                 Countdown Target (actual datetime the countdown counts down to)
 * Frontend automatically shows whichever event's Countdown Target
 * is the SOONEST upcoming one — no manual "which event is active" toggle needed.
 * ==========================================================
 */

/*--------------------------------------------------------
    1) Register Custom Post Type
--------------------------------------------------------*/
function rs_register_event_program_cpt() {

    $labels = array(
        'name'          => __( 'Event Programs', 'rs-madrasha' ),
        'singular_name' => __( 'Event Program', 'rs-madrasha' ),
        'add_new_item'  => __( 'Add New Event', 'rs-madrasha' ),
        'edit_item'     => __( 'Edit Event', 'rs-madrasha' ),
        'menu_name'     => __( 'Event Programs', 'rs-madrasha' ),
    );

    register_post_type( 'event_program', array(
        'labels'        => $labels,
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-calendar-alt',
        'supports'      => array( 'title' ),
        'has_archive'   => false,
        'rewrite'       => false,
        'show_in_rest'  => false,
    ) );
}
add_action( 'init', 'rs_register_event_program_cpt' );


/*--------------------------------------------------------
    2) Meta Box: Eyebrow / Display Text / Countdown Target
--------------------------------------------------------*/
function rs_add_event_program_metabox() {
    add_meta_box(
        'rs_event_program_details',
        __( 'Event Details', 'rs-madrasha' ),
        'rs_render_event_program_metabox',
        'event_program',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rs_add_event_program_metabox' );

function rs_render_event_program_metabox( $post ) {

    wp_nonce_field( 'rs_event_program_save', 'rs_event_program_nonce' );

    $eyebrow      = get_post_meta( $post->ID, '_event_eyebrow', true ) ?: 'আসন্ন অনুষ্ঠান';
    $display_text = get_post_meta( $post->ID, '_event_display_text', true );
    $target       = get_post_meta( $post->ID, '_event_countdown_target', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="event_eyebrow"><?php _e( 'Eyebrow Label', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="event_eyebrow" name="event_eyebrow" class="widefat"
                       value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="আসন্ন অনুষ্ঠান">
            </td>
        </tr>
        <tr>
            <th><label for="event_display_text"><?php _e( 'Display Text (date/location line)', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="text" id="event_display_text" name="event_display_text" class="widefat"
                       value="<?php echo esc_attr( $display_text ); ?>"
                       placeholder="<?php esc_attr_e( '১লা সেপ্টেম্বর, ২০২৬ — সকাল ৯টায় কেন্দ্রীয় মিলনায়তনে', 'rs-madrasha' ); ?>">
                <p class="description"><?php _e( 'The human-readable line shown under the title. This is separate from the countdown target below, since Bengali date formatting is written manually here.', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="event_countdown_target"><?php _e( 'Countdown Target Date & Time', 'rs-madrasha' ); ?></label></th>
            <td>
                <input type="datetime-local" id="event_countdown_target" name="event_countdown_target" class="widefat" style="max-width:260px;"
                       value="<?php echo esc_attr( $target ); ?>">
                <p class="description"><?php _e( 'The exact moment the countdown counts down to. The site automatically displays whichever event has the SOONEST upcoming target — no need to manually mark one as "active".', 'rs-madrasha' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function rs_save_event_program_meta( $post_id ) {

    if ( ! isset( $_POST['rs_event_program_nonce'] ) ||
         ! wp_verify_nonce( $_POST['rs_event_program_nonce'], 'rs_event_program_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['event_eyebrow'] ) ) {
        update_post_meta( $post_id, '_event_eyebrow', sanitize_text_field( $_POST['event_eyebrow'] ) );
    }

    if ( isset( $_POST['event_display_text'] ) ) {
        update_post_meta( $post_id, '_event_display_text', sanitize_text_field( $_POST['event_display_text'] ) );
    }

    if ( isset( $_POST['event_countdown_target'] ) ) {
        update_post_meta( $post_id, '_event_countdown_target', sanitize_text_field( $_POST['event_countdown_target'] ) );
    }
}
add_action( 'save_post_event_program', 'rs_save_event_program_meta' );


/*--------------------------------------------------------
    3) Admin List Table — Countdown Target column
--------------------------------------------------------*/
function rs_event_program_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['event_target'] = __( 'Countdown Target', 'rs-madrasha' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_event_program_posts_columns', 'rs_event_program_admin_columns' );

function rs_event_program_admin_column_content( $column, $post_id ) {
    if ( 'event_target' === $column ) {
        $target = get_post_meta( $post_id, '_event_countdown_target', true );
        if ( $target ) {
            $timestamp = strtotime( $target );
            $is_past   = $timestamp < current_time( 'timestamp' );
            echo esc_html( date_i18n( 'd M Y, h:i A', $timestamp ) );
            if ( $is_past ) {
                echo ' <span style="color:#b32d2e;">(' . esc_html__( 'past', 'rs-madrasha' ) . ')</span>';
            }
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_event_program_posts_custom_column', 'rs_event_program_admin_column_content', 10, 2 );