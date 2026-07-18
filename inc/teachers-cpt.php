<?php 


function rs_register_teacher_cpt() {

    $labels = array(
        'name'               => 'Teachers',
        'singular_name'      => 'Teacher',
        'add_new'            => 'Add Teacher',
        'add_new_item'       => 'Add New Teacher',
        'edit_item'          => 'Edit Teacher',
        'new_item'           => 'New Teacher',
        'all_items'          => 'All Teachers',
        'menu_name'          => 'Teachers',
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_icon'     => 'dashicons-businessperson',
        'supports'      => array(
            'title',
            'thumbnail',
            'page-attributes'
        ),
        'show_in_rest'  => true,
        'has_archive'   => false,
        'rewrite'       => array(
            'slug' => 'teacher'
        ),
    );

    register_post_type('teacher',$args);

}
add_action('init','rs_register_teacher_cpt');

function rs_teacher_meta_box(){

    add_meta_box(
        'teacher_info',
        'Teacher Information',
        'rs_teacher_meta_callback',
        'teacher',
        'normal',
        'high'
    );

}
add_action('add_meta_boxes','rs_teacher_meta_box');


function rs_teacher_meta_callback($post){

    wp_nonce_field('teacher_meta_nonce','teacher_meta_nonce');

    $designation = get_post_meta($post->ID,'_designation',true);
    $department  = get_post_meta($post->ID,'_department',true);
    $phone       = get_post_meta($post->ID,'_phone',true);
?>

<table class="form-table">

<tr>
<th><label>Designation</label></th>
<td>
<input type="text"
name="designation"
value="<?php echo esc_attr($designation); ?>"
class="regular-text">
</td>
</tr>

<tr>
<th><label>Department</label></th>
<td>
<input type="text"
name="department"
value="<?php echo esc_attr($department); ?>"
class="regular-text">
</td>
</tr>

<tr>
<th><label>Phone</label></th>
<td>
<input type="text"
name="phone"
value="<?php echo esc_attr($phone); ?>"
class="regular-text">
</td>
</tr>

</table>

<?php
}

function rs_save_teacher_meta($post_id){

    if(!isset($_POST['teacher_meta_nonce'])) return;

    if(!wp_verify_nonce($_POST['teacher_meta_nonce'],'teacher_meta_nonce')) return;

    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if(isset($_POST['designation'])){
        update_post_meta(
            $post_id,
            '_designation',
            sanitize_text_field($_POST['designation'])
        );
    }

    if(isset($_POST['department'])){
        update_post_meta(
            $post_id,
            '_department',
            sanitize_text_field($_POST['department'])
        );
    }

    if(isset($_POST['phone'])){
        update_post_meta(
            $post_id,
            '_phone',
            sanitize_text_field($_POST['phone'])
        );
    }

}
add_action('save_post_teacher','rs_save_teacher_meta');



























?>