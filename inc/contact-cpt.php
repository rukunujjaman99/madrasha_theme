<?php
/**
 * ==========================================================
 * CONTACT QUERY — Custom SQL Table Storage + Admin UI
 * Table: {$wpdb->prefix}rs_contact_queries
 * No CPT involved — pure custom table, queried directly via $wpdb.
 * ==========================================================
 */

define( 'RS_CONTACT_DB_VERSION', '1.0' );

/*--------------------------------------------------------
    1) Create the custom table (runs automatically if missing)
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
register_activation_hook( __FILE__, 'rs_create_contact_queries_table' ); // if this code lives in a plugin file
add_action( 'after_switch_theme', 'rs_create_contact_queries_table' );    // if it lives in functions.php

// Safety net: auto-create the table if it's ever missing (e.g. code added without a theme switch)
function rs_maybe_create_contact_queries_table() {
    if ( get_option( 'rs_contact_db_version' ) !== RS_CONTACT_DB_VERSION ) {
        rs_create_contact_queries_table();
    }
}
add_action( 'admin_init', 'rs_maybe_create_contact_queries_table' );


/*--------------------------------------------------------
    2) Custom Admin Menu
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
    3) WP_List_Table — reads directly from the custom table
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
            parent::__construct( array(
                'singular' => 'contact_query',
                'plural'   => 'contact_queries',
                'ajax'     => false,
            ) );
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
            $view_url = add_query_arg( array(
                'page' => 'rs-contact-query-view',
                'id'   => $item->id,
            ), admin_url( 'admin.php' ) );

            $delete_url = wp_nonce_url(
                add_query_arg( array(
                    'page'   => 'rs-contact-queries',
                    'action' => 'delete',
                    'id'     => $item->id,
                ), admin_url( 'admin.php' ) ),
                'rs_delete_query_' . $item->id
            );

            $actions = array(
                'view'   => sprintf( '<a href="%s">%s</a>', esc_url( $view_url ), __( 'View', 'rs-madrasha' ) ),
                'delete' => sprintf(
                    '<a href="%s" onclick="return confirm(\'%s\');" style="color:#b32d2e;">%s</a>',
                    esc_url( $delete_url ),
                    esc_js( __( 'Delete this query permanently?', 'rs-madrasha' ) ),
                    __( 'Delete', 'rs-madrasha' )
                ),
            );

            return sprintf(
                '<a href="%s"><strong>%s</strong></a>%s',
                esc_url( $view_url ),
                esc_html( $item->name ),
                $this->row_actions( $actions )
            );
        }

        protected function column_default( $item, $column_name ) {
            switch ( $column_name ) {
                case 'phone':
                    return esc_html( $item->phone ?: '—' );
                case 'email':
                    return esc_html( $item->email ?: '—' );
                case 'subject':
                    return esc_html( $item->subject ?: '—' );
                case 'date':
                    return esc_html( mysql2date( 'd M Y, h:i A', $item->created_at ) );
                default:
                    return '—';
            }
        }

        public function get_bulk_actions() {
            return array(
                'bulk_delete' => __( 'Delete', 'rs-madrasha' ),
            );
        }

        public function prepare_items() {
            global $wpdb;
            $table = rs_contact_queries_table_name();

            $per_page     = 20;
            $current_page = $this->get_pagenum();
            $offset       = ( $current_page - 1 ) * $per_page;
            $search       = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';

            $where = '';
            $params = array();

            if ( $search ) {
                $where = " WHERE name LIKE %s OR phone LIKE %s OR email LIKE %s OR subject LIKE %s ";
                $like  = '%' . $wpdb->esc_like( $search ) . '%';
                $params = array( $like, $like, $like, $like );
            }

            // Total count
            if ( $params ) {
                $total_items = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table}{$where}", $params ) );
            } else {
                $total_items = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
            }

            // Page of results
            $query = "SELECT * FROM {$table}{$where} ORDER BY created_at DESC LIMIT %d OFFSET %d";
            $query_params = array_merge( $params, array( $per_page, $offset ) );
            $this->items = $wpdb->get_results( $wpdb->prepare( $query, $query_params ) );

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
    4) Render: List Page (Data Table)
--------------------------------------------------------*/
function rs_render_contact_query_list_page() {
    global $wpdb;

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to view this page.', 'rs-madrasha' ) );
    }

    $table = rs_contact_queries_table_name();

    // Single delete
    if ( isset( $_GET['action'], $_GET['id'] ) && 'delete' === $_GET['action'] ) {
        $id = absint( $_GET['id'] );
        check_admin_referer( 'rs_delete_query_' . $id );
        $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'বার্তাটি মুছে ফেলা হয়েছে।', 'rs-madrasha' ) . '</p></div>';
    }

    // Bulk delete
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
            <?php
            wp_nonce_field( 'bulk-contact_queries' );
            $list_table->display();
            ?>
        </form>
    </div>
    <?php
}


/*--------------------------------------------------------
    5) Render: Single View Page
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

    $back_url = admin_url( 'admin.php?page=rs-contact-queries' );

    $delete_url = wp_nonce_url(
        add_query_arg( array(
            'page'   => 'rs-contact-queries',
            'action' => 'delete',
            'id'     => $row->id,
        ), admin_url( 'admin.php' ) ),
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
            <div class="row">
                <div class="label"><?php esc_html_e( 'Name', 'rs-madrasha' ); ?></div>
                <div class="value"><?php echo esc_html( $row->name ); ?></div>
            </div>
            <div class="row">
                <div class="label"><?php esc_html_e( 'Submitted On', 'rs-madrasha' ); ?></div>
                <div class="value"><?php echo esc_html( mysql2date( 'd F Y, h:i A', $row->created_at ) ); ?></div>
            </div>
            <div class="row">
                <div class="label"><?php esc_html_e( 'Phone', 'rs-madrasha' ); ?></div>
                <div class="value">
                    <?php echo $row->phone ? '<a href="tel:' . esc_attr( $row->phone ) . '">' . esc_html( $row->phone ) . '</a>' : '—'; ?>
                </div>
            </div>
            <div class="row">
                <div class="label"><?php esc_html_e( 'Email', 'rs-madrasha' ); ?></div>
                <div class="value">
                    <?php echo $row->email ? '<a href="mailto:' . esc_attr( $row->email ) . '">' . esc_html( $row->email ) . '</a>' : '—'; ?>
                </div>
            </div>
            <div class="row">
                <div class="label"><?php esc_html_e( 'Subject', 'rs-madrasha' ); ?></div>
                <div class="value"><?php echo esc_html( $row->subject ? $row->subject : '—' ); ?></div>
            </div>
            <div class="row">
                <div class="label"><?php esc_html_e( 'Message', 'rs-madrasha' ); ?></div>
                <div class="value message"><?php echo esc_html( $row->message ); ?></div>
            </div>
        </div>

        <p style="margin-top:16px;">
            <a href="<?php echo esc_url( $delete_url ); ?>"
               class="button button-secondary"
               style="color:#b32d2e;border-color:#b32d2e;"
               onclick="return confirm('<?php echo esc_js( __( 'Delete this query permanently?', 'rs-madrasha' ) ); ?>');">
                <?php esc_html_e( 'Delete This Query', 'rs-madrasha' ); ?>
            </a>
        </p>
    </div>
    <?php
}


/*--------------------------------------------------------
    6) AJAX Handler — Save Frontend Form Submission (into SQL table)
--------------------------------------------------------*/
function rs_handle_contact_form_submit() {
    global $wpdb;

    check_ajax_referer( 'rs_contact_form_nonce', 'nonce' );

    $name    = isset( $_POST['name'] )    ? sanitize_text_field( $_POST['name'] )    : '';
    $phone   = isset( $_POST['phone'] )   ? sanitize_text_field( $_POST['phone'] )   : '';
    $email   = isset( $_POST['email'] )   ? sanitize_email( $_POST['email'] )        : '';
    $subject = isset( $_POST['subject'] ) ? sanitize_text_field( $_POST['subject'] ) : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

    $errors = array();

    if ( '' === $name ) {
        $errors[] = __( 'নাম আবশ্যক', 'rs-madrasha' );
    }
    if ( ! preg_match( '/^[0-9]{11}$/', $phone ) ) {
        $errors[] = __( 'সঠিক ১১ ডিজিটের মোবাইল নম্বর দিন', 'rs-madrasha' );
    }
    if ( ! is_email( $email ) ) {
        $errors[] = __( 'সঠিক ইমেইল দিন', 'rs-madrasha' );
    }
    if ( '' === $message ) {
        $errors[] = __( 'বার্তা লিখুন', 'rs-madrasha' );
    }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( array( 'message' => implode( ' ', $errors ) ) );
    }

    // Make sure the table exists before inserting (safety net)
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

    if ( false === $inserted ) {
        wp_send_json_error( array(
            'message' => __( 'দুঃখিত, ডাটাবেসে সংরক্ষণ করা যায়নি। আবার চেষ্টা করুন।', 'rs-madrasha' ),
            'debug'   => $wpdb->last_error, // remove/hide this in production if you don't want to expose SQL errors
        ) );
    }

    wp_send_json_success( array(
        'message' => __( 'আপনার বার্তা সফলভাবে পাঠানো হয়েছে। ধন্যবাদ!', 'rs-madrasha' ),
    ) );
}
add_action( 'wp_ajax_rs_contact_form_submit', 'rs_handle_contact_form_submit' );
add_action( 'wp_ajax_nopriv_rs_contact_form_submit', 'rs_handle_contact_form_submit' );


/*--------------------------------------------------------
    7) Enqueue the frontend form script (inline — no external file needed)
--------------------------------------------------------*/
function rs_enqueue_contact_form_script() {

    wp_register_script( 'rs-contact-form', '', array(), '1.0', true );
    wp_enqueue_script( 'rs-contact-form' );

    wp_localize_script( 'rs-contact-form', 'rsContactForm', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'rs_contact_form_nonce' ),
    ) );

    $inline_js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
    var form        = document.getElementById('contactForm');
    var successBox  = document.getElementById('contactSuccess');
    var successText = document.getElementById('contactSuccessText');
    var errorBox    = document.getElementById('contactError');
    var errorText   = document.getElementById('contactErrorText');
    var submitBtn   = document.getElementById('contactSubmitBtn');
    var btnText     = document.getElementById('contactBtnText');

    if (!form || typeof rsContactForm === 'undefined') {
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        form.classList.add('was-validated');

        if (successBox) successBox.classList.add('d-none');
        if (errorBox) errorBox.classList.add('d-none');

        if (submitBtn) submitBtn.disabled = true;
        var originalBtnText = btnText ? btnText.textContent : '';
        if (btnText) btnText.textContent = 'পাঠানো হচ্ছে...';

        var formData = new FormData(form);
        formData.append('action', 'rs_contact_form_submit');
        formData.append('nonce', rsContactForm.nonce);

        fetch(rsContactForm.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            if (submitBtn) submitBtn.disabled = false;
            if (btnText) btnText.textContent = originalBtnText;

            if (data.success) {
                if (successText) successText.textContent = data.data.message;
                if (successBox) successBox.classList.remove('d-none');
                form.reset();
                form.classList.remove('was-validated');
            } else {
                if (errorText) errorText.textContent = (data.data && data.data.message) || 'দুঃখিত, একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।';
                if (errorBox) errorBox.classList.remove('d-none');
                console.error('Contact form error:', data);
            }
        })
        .catch(function (err) {
            if (submitBtn) submitBtn.disabled = false;
            if (btnText) btnText.textContent = originalBtnText;
            if (errorText) errorText.textContent = 'নেটওয়ার্ক সমস্যা হয়েছে। আবার চেষ্টা করুন।';
            if (errorBox) errorBox.classList.remove('d-none');
            console.error('Contact form network error:', err);
        });
    });
});
JS;

    wp_add_inline_script( 'rs-contact-form', $inline_js );
}
add_action( 'wp_enqueue_scripts', 'rs_enqueue_contact_form_script' );