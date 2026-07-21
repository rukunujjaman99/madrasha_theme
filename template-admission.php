<?php 
// Template Name: Admission Page
get_header();
?>

<div class="page-hero">
  <div class="container">
    <h1>ভর্তি তথ্য ও ফরম</h1>
    <div class="breadcrumb-custom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">হোম</a> / ভর্তি</div>
  </div>
</div>

<?php
/**
 * Frontend Output — Admission Page
 * Drop this where the static markup used to be.
 */

$cat_labels = array(
    'dakhil' => 'দাখিল',
    'alim'   => 'আলিম',
    'fazil'  => 'ফাযিল',
    'kamil'  => 'কামিল',
);

$schedule_defaults = array(
    1 => array( 'label' => 'দাখিল', 'value' => '১-৩১ জুলাই' ),
    2 => array( 'label' => 'আলিম',  'value' => '১-২০ জুলাই' ),
    3 => array( 'label' => 'ফাযিল', 'value' => '১-১৫ আগস্ট' ),
    4 => array( 'label' => 'কামিল', 'value' => '১-১০ আগস্ট' ),
);

$forms_query = new WP_Query( array(
    'post_type'      => 'admission_form',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

<div class="container my-5">
  <div class="row g-4">

    <div class="col-lg-8">

      <div class="reveal p-4 mb-4" style="background:var(--cream);border-radius:10px;">
        <h5 class="fw-bold" style="color:var(--navy)">
          <i class="bi bi-info-circle"></i>
          <?php echo esc_html( get_theme_mod( 'rs_adm_instructions_heading', 'ভর্তি সংক্রান্ত সাধারণ নির্দেশনা' ) ); ?>
        </h5>
        <p class="text-secondary small mb-0">
          <?php echo esc_html( get_theme_mod( 'rs_adm_instructions_text', '' ) ); ?>
        </p>
      </div>

      <div class="d-flex flex-wrap gap-2 mb-3 notice-filter reveal" id="admFilter">
        <button class="active" data-cat="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></button>
        <?php foreach ( $cat_labels as $slug => $label ) : ?>
          <button data-cat="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="reveal" id="admList">

        <?php if ( $forms_query->have_posts() ) : ?>

          <?php while ( $forms_query->have_posts() ) : $forms_query->the_post();

            $category = get_post_meta( get_the_ID(), '_admission_category', true );
            $badge    = get_post_meta( get_the_ID(), '_admission_badge', true );
            $file_id  = get_post_meta( get_the_ID(), '_admission_file', true );
            $file_url = $file_id ? wp_get_attachment_url( $file_id ) : '';

            $label = $badge ? $badge : ( isset( $cat_labels[ $category ] ) ? $cat_labels[ $category ] : '' );
          ?>

            <div class="notice-row" data-cat="<?php echo esc_attr( $category ); ?>">
              <div>
                <span class="tag"><?php echo esc_html( $label ); ?></span>
                <span class="fw-bold ms-2" style="color:var(--navy);"><?php the_title(); ?></span>
              </div>
              <?php if ( $file_url ) : ?>
                <a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener"
                   class="btn btn-sm" style="background:var(--rose);color:#fff;">
                  <i class="bi bi-download"></i> PDF
                </a>
              <?php endif; ?>
            </div>

          <?php endwhile; wp_reset_postdata(); ?>

        <?php else : ?>

          <p class="text-secondary"><?php esc_html_e( 'কোনো ভর্তি ফরম পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

        <?php endif; ?>

      </div>
    </div>

    <div class="col-lg-4">

      <div class="side-card reveal">
        <div class="side-card-head navy">
          <?php echo esc_html( get_theme_mod( 'rs_adm_schedule_heading', 'ভর্তি সময়সূচি' ) ); ?>
        </div>
        <div class="side-card-body">
          <?php $i = 0; $row_count = count( $schedule_defaults ); foreach ( $schedule_defaults as $index => $default ) :
              $i++;
              $label = get_theme_mod( "rs_adm_schedule{$index}_label", $default['label'] );
              $value = get_theme_mod( "rs_adm_schedule{$index}_value", $default['value'] );

              if ( '' === $label && '' === $value ) {
                  continue;
              }

              $is_last = ( $i === $row_count );
          ?>
            <div class="d-flex justify-content-between <?php echo $is_last ? 'py-2' : 'border-bottom py-2'; ?>">
              <span><?php echo esc_html( $label ); ?></span>
              <b style="color:var(--navy)"><?php echo esc_html( $value ); ?></b>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="side-card reveal">
        <div class="side-card-head"><?php esc_html_e( 'যোগাযোগ', 'rs-madrasha' ); ?></div>
        <div class="side-card-body small">
          <?php $rs_adm_phone = get_theme_mod( 'rs_adm_contact_phone', '০১৭১২-৪৫৭৬২০ (ভর্তি শাখা)' ); ?>
          <?php if ( $rs_adm_phone ) : ?>
            <p class="mb-1"><i class="bi bi-telephone"></i> <?php echo esc_html( $rs_adm_phone ); ?></p>
          <?php endif; ?>

          <?php $rs_adm_email = get_theme_mod( 'rs_adm_contact_email', 'kawniagirls.fazil@gmail.com' ); ?>
          <?php if ( $rs_adm_email ) : ?>
            <p class="mb-0"><i class="bi bi-envelope"></i> <?php echo esc_html( $rs_adm_email ); ?></p>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var filterWrap = document.getElementById('admFilter');
    var rows       = document.querySelectorAll('#admList .notice-row');

    if (!filterWrap || !rows.length) {
        return;
    }

    filterWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;

        filterWrap.querySelectorAll('button').forEach(function (b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        var cat = btn.getAttribute('data-cat');

        rows.forEach(function (row) {
            var show = (cat === 'all') || (row.getAttribute('data-cat') === cat);
            row.style.display = show ? '' : 'none';
        });
    });
});
</script>

<?php get_footer(); ?>