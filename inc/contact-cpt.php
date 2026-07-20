<?php
/**
 * ==========================================================
 * CONTACT QUERY — Full System (admin-post.php based, no AJAX)
 * Replaces ALL earlier versions. Use ONLY this file.
 * ==========================================================
 */

define( 'RS_CONTACT_DB_VERSION', '1.0' );

/*--------------------------------------------------------
    1) Custom Table
--------------------------------------------------------*/
function rs_contact_queries_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'rs_contact_queries';
}

function rs_create_contact_queries_table() {
    global $wpdb;

    $table_name      = rs_contact_queries_table_name();
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table_name} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(191) NOT NULL,
        phone varchar(20) NOT NULL,
        email varchar(191) NOT NULL,
        subject varchar(191) DEFAULT '',
        message text NOT NULL,
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    update_option( 'rs_contact_db_version', RS_CONTACT_DB_VERSION );
}
add_action( 'after_switch_theme', 'rs_create_contact_queries_table' );

function rs_maybe_create_contact_queries_table() {
    if ( get_option( 'rs_contact_db_version' ) !== RS_CONTACT_DB_VERSION ) {
        rs_create_contact_queries_table();
    }
}
add_action( 'init', 'rs_maybe_create_contact_queries_table' ); // runs on EVERY request now, not just admin — guarantees it exists before any form submit


/*--------------------------------------------------------
    2) Admin Menu
--------------------------------------------------------*/
function rs_contact_query_admin_menu() {
    global $wpdb;

    $table = rs_contact_queries_table_name();
    $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
    $bubble = $total > 0 ? ' <span class="awaiting-mod count-' . $total . '"><span class="pending-count">' . $total . '</span></span>' : '';

    add_menu_page(
        __( 'Contact Queries', 'rs-madrasha' ),
        __( 'Contact Queries', 'rs-madrasha' ) . $bubble,
        'manage_options',
        'rs-contact-queries',
        'rs_render_contact_query_list_page',
        'dashicons-email-alt',
        26
    );

    add_submenu_page(
        null,
        __( 'View Query', 'rs-madrasha' ),
        __( 'View Query', 'rs-madrasha' ),
        'manage_options',
        'rs-contact-query-view',
        'rs_render_contact_query_single_page'
    );
}
add_action( 'admin_menu', 'rs_contact_query_admin_menu' );


/*--------------------------------------------------------
    3) WP_List_Table
--------------------------------------------------------*/
function rs_load_contact_query_list_table() {
    if ( ! class_exists( 'WP_List_Table' ) ) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
    }
    if ( class_exists( 'RS_Contact_Query_List_Table' ) ) {
        return;
    }

    class RS_Contact_Query_List_Table extends WP_List_Table {

        public function __construct() {
            parent::__construct( array( 'singular' => 'contact_query', 'plural' => 'contact_queries', 'ajax' => false ) );
        }

        public function get_columns() {
            return array(
                'cb'      => '<input type="checkbox" />',
                'name'    => __( 'Name', 'rs-madrasha' ),
                'phone'   => __( 'Phone', 'rs-madrasha' ),
                'email'   => __( 'Email', 'rs-madrasha' ),
                'subject' => __( 'Subject', 'rs-madrasha' ),
                'date'    => __( 'Submitted', 'rs-madrasha' ),
            );
        }

        protected function column_cb( $item ) {
            return sprintf( '<input type="checkbox" name="query_ids[]" value="%d" />', $item->id );
        }

        protected function column_name( $item ) {
            $view_url = add_query_arg( array( 'page' => 'rs-contact-query-view', 'id' => $item->id ), admin_url( 'admin.php' ) );
            $delete_url = wp_nonce_url(
                add_query_arg( array( 'page' => 'rs-contact-queries', 'action' => 'delete', 'id' => $item->id ), admin_url( 'admin.php' ) ),
                'rs_delete_query_' . $item->id
            );

            $actions = array(
                'view'   => sprintf( '<a href="%s">%s</a>', esc_url( $view_url ), __( 'View', 'rs-madrasha' ) ),
                'delete' => sprintf(
                    '<a href="%s" onclick="return confirm(\'%s\');" style="color:#b32d2e;">%s</a>',
                    esc_url( $delete_url ), esc_js( __( 'Delete this query permanently?', 'rs-madrasha' ) ), __( 'Delete', 'rs-madrasha' )
                ),
            );

            return sprintf( '<a href="%s"><strong>%s</strong></a>%s', esc_url( $view_url ), esc_html( $item->name ), $this->row_actions( $actions ) );
        }

        protected function column_default( $item, $column_name ) {
            switch ( $column_name ) {
                case 'phone':   return esc_html( $item->phone ?: '—' );
                case 'email':   return esc_html( $item->email ?: '—' );
                case 'subject': return esc_html( $item->subject ?: '—' );
                case 'date':    return esc_html( mysql2date( 'd M Y, h:i A', $item->created_at ) );
                default:        return '—';
            }
        }

        public function get_bulk_actions() {
            return array( 'bulk_delete' => __( 'Delete', 'rs-madrasha' ) );
        }

        public function prepare_items() {
            global $wpdb;
            $table = rs_contact_queries_table_name();

            $per_page     = 20;
            $current_page = $this->get_pagenum();
            $offset       = ( $current_page - 1 ) * $per_page;
            $search       = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';

            $where  = '';
            $params = array();

            if ( $search ) {
                $where  = " WHERE name LIKE %s OR phone LIKE %s OR email LIKE %s OR subject LIKE %s ";
                $like   = '%' . $wpdb->esc_like( $search ) . '%';
                $params = array( $like, $like, $like, $like );
            }

            $total_items = $params
                ? (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table}{$where}", $params ) )
                : (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

            $query        = "SELECT * FROM {$table}{$where} ORDER BY created_at DESC LIMIT %d OFFSET %d";
            $query_params = array_merge( $params, array( $per_page, $offset ) );
            $this->items  = $wpdb->get_results( $wpdb->prepare( $query, $query_params ) );

            $this->_column_headers = array( $this->get_columns(), array(), array() );

            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil( $total_items / $per_page ),
            ) );
        }

        public function no_items() {
            esc_html_e( 'কোনো বার্তা পাওয়া যায়নি।', 'rs-madrasha' );
        }
    }
}
add_action( 'admin_init', 'rs_load_contact_query_list_table' );


/*--------------------------------------------------------
    4) List Page
--------------------------------------------------------*/
function rs_render_contact_query_list_page() {
    global $wpdb;

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to view this page.', 'rs-madrasha' ) );
    }

    $table = rs_contact_queries_table_name();

    if ( isset( $_GET['action'], $_GET['id'] ) && 'delete' === $_GET['action'] ) {
        $id = absint( $_GET['id'] );
        check_admin_referer( 'rs_delete_query_' . $id );
        $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'বার্তাটি মুছে ফেলা হয়েছে।', 'rs-madrasha' ) . '</p></div>';
    }

    if ( isset( $_POST['query_ids'] ) && isset( $_POST['action'] ) && 'bulk_delete' === $_POST['action'] ) {
        check_admin_referer( 'bulk-contact_queries' );
        foreach ( (array) $_POST['query_ids'] as $id ) {
            $wpdb->delete( $table, array( 'id' => absint( $id ) ), array( '%d' ) );
        }
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'নির্বাচিত বার্তাগুলো মুছে ফেলা হয়েছে।', 'rs-madrasha' ) . '</p></div>';
    }

    $list_table = new RS_Contact_Query_List_Table();
    $list_table->prepare_items();
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e( 'Contact Queries', 'rs-madrasha' ); ?></h1>
        <hr class="wp-header-end">

        <form method="get">
            <input type="hidden" name="page" value="rs-contact-queries">
            <?php $list_table->search_box( __( 'Search', 'rs-madrasha' ), 'rs-contact-query-search' ); ?>
        </form>

        <form method="post">
            <?php wp_nonce_field( 'bulk-contact_queries' ); $list_table->display(); ?>
        </form>
    </div>
    <?php
}


/*--------------------------------------------------------
    5) Single View Page
--------------------------------------------------------*/
function rs_render_contact_query_single_page() {
    global $wpdb;

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to view this page.', 'rs-madrasha' ) );
    }

    $table = rs_contact_queries_table_name();
    $id    = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
    $row   = $id ? $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) ) : null;

    if ( ! $row ) {
        echo '<div class="wrap"><p>' . esc_html__( 'বার্তাটি খুঁজে পাওয়া যায়নি।', 'rs-madrasha' ) . '</p></div>';
        return;
    }

    $back_url   = admin_url( 'admin.php?page=rs-contact-queries' );
    $delete_url = wp_nonce_url(
        add_query_arg( array( 'page' => 'rs-contact-queries', 'action' => 'delete', 'id' => $row->id ), admin_url( 'admin.php' ) ),
        'rs_delete_query_' . $row->id
    );
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e( 'Query from', 'rs-madrasha' ); ?> <?php echo esc_html( $row->name ); ?></h1>
        <a href="<?php echo esc_url( $back_url ); ?>" class="page-title-action"><?php esc_html_e( '← Back to All Queries', 'rs-madrasha' ); ?></a>
        <hr class="wp-header-end">

        <style>
            .rs-query-detail{max-width:700px;background:#fff;border:1px solid #dcdcde;border-radius:4px;padding:20px;margin-top:16px;}
            .rs-query-detail .row{display:flex;border-bottom:1px solid #f0f0f1;padding:12px 0;}
            .rs-query-detail .row:last-child{border-bottom:0;}
            .rs-query-detail .row .label{width:150px;flex-shrink:0;font-weight:600;color:#646970;}
            .rs-query-detail .row .value{flex:1;}
            .rs-query-detail .row .value.message{white-space:pre-wrap;line-height:1.7;}
        </style>

        <div class="rs-query-detail">
            <div class="row"><div class="label"><?php esc_html_e( 'Name', 'rs-madrasha' ); ?></div><div class="value"><?php echo esc_html( $row->name ); ?></div></div>
            <div class="row"><div class="label"><?php esc_html_e( 'Submitted On', 'rs-madrasha' ); ?></div><div class="value"><?php echo esc_html( mysql2date( 'd F Y, h:i A', $row->created_at ) ); ?></div></div>
            <div class="row"><div class="label"><?php esc_html_e( 'Phone', 'rs-madrasha' ); ?></div><div class="value"><?php echo $row->phone ? '<a href="tel:' . esc_attr( $row->phone ) . '">' . esc_html( $row->phone ) . '</a>' : '—'; ?></div></div>
            <div class="row"><div class="label"><?php esc_html_e( 'Email', 'rs-madrasha' ); ?></div><div class="value"><?php echo $row->email ? '<a href="mailto:' . esc_attr( $row->email ) . '">' . esc_html( $row->email ) . '</a>' : '—'; ?></div></div>
            <div class="row"><div class="label"><?php esc_html_e( 'Subject', 'rs-madrasha' ); ?></div><div class="value"><?php echo esc_html( $row->subject ? $row->subject : '—' ); ?></div></div>
            <div class="row"><div class="label"><?php esc_html_e( 'Message', 'rs-madrasha' ); ?></div><div class="value message"><?php echo esc_html( $row->message ); ?></div></div>
        </div>

        <p style="margin-top:16px;">
            <a href="<?php echo esc_url( $delete_url ); ?>" class="button button-secondary" style="color:#b32d2e;border-color:#b32d2e;"
               onclick="return confirm('<?php echo esc_js( __( 'Delete this query permanently?', 'rs-madrasha' ) ); ?>');">
                <?php esc_html_e( 'Delete This Query', 'rs-madrasha' ); ?>
            </a>
        </p>
    </div>
    <?php
}


/*--------------------------------------------------------
    6) FORM SUBMISSION — via admin-post.php (no AJAX/JS needed)
--------------------------------------------------------*/
function rs_handle_contact_form_submit() {
    global $wpdb;

    if ( ! isset( $_POST['rs_contact_nonce'] ) || ! wp_verify_nonce( $_POST['rs_contact_nonce'], 'rs_contact_form_action' ) ) {
        wp_safe_redirect( add_query_arg( 'contact_status', 'error', wp_get_referer() ?: home_url() ) );
        exit;
    }

    $name    = isset( $_POST['name'] )    ? sanitize_text_field( $_POST['name'] )    : '';
    $phone   = isset( $_POST['phone'] )   ? sanitize_text_field( $_POST['phone'] )   : '';
    $email   = isset( $_POST['email'] )   ? sanitize_email( $_POST['email'] )        : '';
    $subject = isset( $_POST['subject'] ) ? sanitize_text_field( $_POST['subject'] ) : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

    $valid = ( '' !== $name ) && preg_match( '/^[0-9]{11}$/', $phone ) && is_email( $email ) && ( '' !== $message );

    if ( ! $valid ) {
        wp_safe_redirect( add_query_arg( 'contact_status', 'invalid', wp_get_referer() ?: home_url() ) );
        exit;
    }

    rs_maybe_create_contact_queries_table();
    $table = rs_contact_queries_table_name();

    $inserted = $wpdb->insert(
        $table,
        array(
            'name'       => $name,
            'phone'      => $phone,
            'email'      => $email,
            'subject'    => $subject,
            'message'    => $message,
            'created_at' => current_time( 'mysql' ),
        ),
        array( '%s', '%s', '%s', '%s', '%s', '%s' )
    );

    $status = ( false === $inserted ) ? 'dberror' : 'success';

    wp_safe_redirect( add_query_arg( 'contact_status', $status, wp_get_referer() ?: home_url() ) );
    exit;
}
add_action( 'admin_post_rs_contact_form_submit', 'rs_handle_contact_form_submit' );
add_action( 'admin_post_nopriv_rs_contact_form_submit', 'rs_handle_contact_form_submit' );


/*--------------------------------------------------------
    7) BUILT-IN DIAGNOSTIC — shows on every wp-admin page.
       Remove this whole block once everything is confirmed working.
--------------------------------------------------------*/
add_action( 'admin_notices', function () {
    global $wpdb;
    $table = rs_contact_queries_table_name();

    echo '<div class="notice notice-info"><p><strong>Contact Form Diagnostic:</strong></p><ul style="margin-left:20px;list-style:disc;">';

    $table_exists = $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table ) ) === $table;
    echo '<li>Table <code>' . esc_html( $table ) . '</code>: ' .
         ( $table_exists ? '<strong style="color:green;">EXISTS ✔</strong>' : '<strong style="color:red;">DOES NOT EXIST ✘</strong>' ) . '</li>';

    if ( $table_exists ) {
        $count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
        echo '<li>Row count: <strong>' . esc_html( $count ) . '</strong></li>';

        if ( $count > 0 ) {
            $rows = $wpdb->get_results( "SELECT id, name, phone, email, created_at FROM {$table} ORDER BY id DESC LIMIT 3" );
            echo '<li>Latest rows:<ul style="margin-left:20px;">';
            foreach ( $rows as $r ) {
                echo '<li>#' . esc_html( $r->id ) . ' — ' . esc_html( $r->name ) . ' — ' . esc_html( $r->phone ) . ' — ' . esc_html( $r->email ) . ' — ' . esc_html( $r->created_at ) . '</li>';
            }
            echo '</ul></li>';
        }
    }

    // Is the admin-post handler actually registered?
    $handler_registered = has_action( 'admin_post_nopriv_rs_contact_form_submit' );
    echo '<li>Form handler registered: ' .
         ( $handler_registered ? '<strong style="color:green;">YES ✔</strong>' : '<strong style="color:red;">NO ✘ — a fatal PHP error elsewhere in functions.php is stopping this file from loading.</strong>' ) . '</li>';

    echo '</ul></div>';
} );