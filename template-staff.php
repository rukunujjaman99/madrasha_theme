<?php 
// Template Name: Staff Page
get_header();

?>




<div class="page-hero">
  <div class="container">
    <h1>কর্মকর্তা ও কর্মচারী</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / কর্মকর্তা ও কর্মচারী</div>
  </div>
</div>

<?php
/**
 * Frontend Output — Staff Grid
 * Drop this where the static staff block used to be.
 */
?>

<div class="container my-5">

  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 reveal teacher-filter">
    <select id="teacherDept" class="form-select" style="max-width:220px;">
      <option value="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></option>
      <option value="kormokorta"><?php esc_html_e( 'কর্মকর্তা', 'rs-madrasha' ); ?></option>
      <option value="kormochari"><?php esc_html_e( 'কর্মচারী', 'rs-madrasha' ); ?></option>
    </select>
    <input id="teacherSearch" type="text" class="form-control" style="max-width:240px;"
           placeholder="<?php esc_attr_e( 'নাম খুঁজুন...', 'rs-madrasha' ); ?>">
  </div>

  <div class="row g-4" id="teacherGrid">

    <?php
    $staff_query = new WP_Query( array(
        'post_type'      => 'staff',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );

    if ( $staff_query->have_posts() ) :

        while ( $staff_query->have_posts() ) : $staff_query->the_post();

            $name          = get_the_title();
            $designation   = get_post_meta( get_the_ID(), '_staff_designation', true );
            $qualification = get_post_meta( get_the_ID(), '_staff_qualification', true );
            $dept          = get_post_meta( get_the_ID(), '_staff_dept', true );
            $phone         = get_post_meta( get_the_ID(), '_staff_phone', true );

            $dept_labels = array(
                'kormokorta' => 'কর্মকর্তা',
                'kormochari' => 'কর্মচারী',
            );
            $dept_label = isset( $dept_labels[ $dept ] ) ? $dept_labels[ $dept ] : '';
        ?>

        <div class="col-6 col-md-4 col-lg-3 teacher-col reveal">
            <div class="teacher-card"
                 data-name="<?php echo esc_attr( mb_strtolower( $name ) ); ?>"
                 data-dept="<?php echo esc_attr( $dept ); ?>">

                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'teacher-image' ) ); ?>
                <?php else : ?>
                    <div class="avatar-initial">
                        <?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="info">
                    <h6><?php echo esc_html( $name ); ?></h6>

                    <?php if ( $designation ) : ?>
                        <small class="text-secondary"><?php echo esc_html( $designation ); ?></small><br>
                    <?php endif; ?>

                    <?php if ( $qualification ) : ?>
                        <small class="text-secondary"><?php echo esc_html( $qualification ); ?></small><br>
                    <?php endif; ?>

                    <?php if ( $dept_label ) : ?>
                        <span class="dept-tag"><?php echo esc_html( $dept_label ); ?></span>
                    <?php endif; ?>

                    <?php if ( $phone ) : ?>
                        <div class="phone-line">
                            <i class="bi bi-telephone-fill"></i> <?php echo esc_html( $phone ); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>

        <p class="text-center w-100"><?php esc_html_e( 'কোনো তথ্য পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

    <?php endif; ?>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var deptSelect  = document.getElementById('teacherDept');
    var searchInput = document.getElementById('teacherSearch');
    var teacherCols = document.querySelectorAll('#teacherGrid .teacher-col');

    if (!deptSelect || !searchInput || !teacherCols.length) {
        return;
    }

    function filterStaff() {
        var dept  = deptSelect.value;
        var query = searchInput.value.trim().toLowerCase();

        teacherCols.forEach(function (col) {
            var card = col.querySelector('.teacher-card');
            if (!card) return;

            var matchesDept = (dept === 'all') || (card.getAttribute('data-dept') === dept);
            var matchesName = card.getAttribute('data-name').indexOf(query) !== -1;

            col.style.display = (matchesDept && matchesName) ? '' : 'none';
        });
    }

    deptSelect.addEventListener('change', filterStaff);
    searchInput.addEventListener('input', filterStaff);
});
</script>

<?php get_footer(); ?>