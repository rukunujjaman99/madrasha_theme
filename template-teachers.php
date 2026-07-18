<?php 
// Template Name: Teachers Page
get_header(); ?>

<style> 

  .teacher-image{
    width:80px;
    height:80px;
   
    object-fit:cover;
    margin:15px auto 10px;
    display:block;
    border:3px solid #eee;
}
</style>



<div class="page-hero">
  <div class="container">
    <h1>শিক্ষকবৃন্দ</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / শিক্ষকবৃন্দ</div>
  </div>
</div>

<div class="container my-5">
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 reveal teacher-filter">

    <select id="teacherDept" class="form-select" style="max-width:220px;">

        <option value="all">সকল</option>

        <?php

        global $wpdb;

        $departments = $wpdb->get_results("
            SELECT DISTINCT meta_value
            FROM {$wpdb->postmeta}
            WHERE meta_key = '_department'
            AND meta_value <> ''
            ORDER BY meta_value ASC
        ");

        if($departments){

            foreach($departments as $dept){

                $slug = sanitize_title($dept->meta_value);

                echo '<option value="'.esc_attr($slug).'">'
                        .esc_html($dept->meta_value).
                     '</option>';

            }

        }

        ?>

    </select>

    <input
        id="teacherSearch"
        type="text"
        class="form-control"
        style="max-width:240px;"
        placeholder="শিক্ষকের নাম খুঁজুন...">

</div>

  <div class="row g-4" id="teacherGrid">

 <div class="row g-4" id="teacherGrid">

<?php

$teachers = new WP_Query(array(
    'post_type'      => 'teacher',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
));

if($teachers->have_posts()) :

while($teachers->have_posts()) : $teachers->the_post();
$name = get_the_title();
$designation = get_post_meta(get_the_ID(),'_designation',true);
$department  = get_post_meta(get_the_ID(),'_department',true);
$phone       = get_post_meta(get_the_ID(),'_phone',true);

$dept_slug = sanitize_title($department);

?>

<div class="col-6 col-md-4 col-lg-3 teacher-col reveal">

    <div
        class="teacher-card"
        data-name="<?php echo esc_attr(get_the_title()); ?>"
        data-dept="<?php echo esc_attr($dept_slug); ?>">

        <?php if(has_post_thumbnail()) : ?>

            <?php the_post_thumbnail('medium',array(
                'class'=>'teacher-image'
            )); ?>

        <?php else : ?>

            <div class="avatar-initial">
                <?php echo mb_substr(get_the_title(),0,1); ?>
            </div>

        <?php endif; ?>

        <div class="info">

            <h6><?php the_title(); ?></h6>

            <small class="text-secondary">
                <?php echo esc_html($designation); ?>
            </small>

            <br>

            <span class="dept-tag">
                <?php echo esc_html($department); ?>
            </span>

            <?php if($phone): ?>

            <div class="phone-line">
                <i class="bi bi-telephone-fill"></i>
                <?php echo esc_html($phone); ?>
            </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php

endwhile;

wp_reset_postdata();

endif;

?>

</div>


  </div>
</div>

<?php get_footer(); ?>
