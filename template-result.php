<?php
// Template Name: Result Page 
get_header();
?>




<div class="page-hero">
  <div class="container">
    <h1>পরীক্ষার ফলাফল</h1>
    <div class="breadcrumb-custom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">হোম</a> / ফলাফল</div>
  </div>
</div>



<?php
/**
 * Frontend Output — Results Page (PDF list + Image gallery tabs)
 * Drop this where the static markup used to be.
 */

$cat_labels = array(
    'dakhil' => 'দাখিল',
    'alim'   => 'আলিম',
    'fazil'  => 'ফাযিল',
    'kamil'  => 'কামিল',
);

$pdf_results = new WP_Query( array(
    'post_type'      => 'result',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => array(
        array( 'key' => '_result_type', 'value' => 'pdf' ),
    ),
) );

$image_results = new WP_Query( array(
    'post_type'      => 'result',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'meta_query'     => array(
        array( 'key' => '_result_type', 'value' => 'image' ),
    ),
) );
?>

<div class="container my-5">

  <ul class="nav nav-pills mv-tabs mb-4 reveal">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#res-pdf"><?php esc_html_e( 'ফলাফল পিডিএফ', 'rs-madrasha' ); ?></button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#res-img"><?php esc_html_e( 'ফলাফল ছবি', 'rs-madrasha' ); ?></button></li>
  </ul>

  <div class="tab-content">

    <!-- PDF LIST -->
    <div class="tab-pane fade show active" id="res-pdf">

      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 reveal">
        <div class="notice-filter" id="resultFilter">
          <button class="active" data-cat="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></button>
          <?php foreach ( $cat_labels as $slug => $label ) : ?>
            <button data-cat="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
          <?php endforeach; ?>
        </div>
        <input id="resultSearch" type="text" class="form-control" style="max-width:240px;"
               placeholder="<?php esc_attr_e( 'ফলাফল খুঁজুন...', 'rs-madrasha' ); ?>">
      </div>

      <div class="reveal" id="resultRows">

        <?php if ( $pdf_results->have_posts() ) : ?>

          <?php while ( $pdf_results->have_posts() ) : $pdf_results->the_post();

            $category = get_post_meta( get_the_ID(), '_result_category', true );
            $file_id  = get_post_meta( get_the_ID(), '_result_file', true );
            $file_url = $file_id ? wp_get_attachment_url( $file_id ) : '';
            $title    = get_the_title();
            $label    = isset( $cat_labels[ $category ] ) ? $cat_labels[ $category ] : '';
          ?>

            <div class="notice-row" data-cat="<?php echo esc_attr( $category ); ?>" data-title="<?php echo esc_attr( $title ); ?>">
              <div>
                <span class="tag"><?php echo esc_html( $label ); ?></span>
                <a href="<?php echo $file_url ? esc_url( $file_url ) : '#'; ?>" target="_blank" rel="noopener"
                   class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">
                  <?php echo esc_html( $title ); ?>
                </a>
              </div>
              <div class="d-flex align-items-center gap-3">
                <span class="date"><?php echo esc_html( get_the_date( 'd F Y' ) ); ?></span>
                <?php if ( $file_url ) : ?>
                  <a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener"
                     class="btn btn-sm" style="background:var(--rose);color:#fff;">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                  </a>
                <?php endif; ?>
              </div>
            </div>

          <?php endwhile; wp_reset_postdata(); ?>

        <?php else : ?>

          <p class="text-secondary"><?php esc_html_e( 'কোনো ফলাফল পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

        <?php endif; ?>

      </div>
    </div>

    <!-- IMAGE RESULTS -->
    <div class="tab-pane fade" id="res-img">
      <div class="row g-3">

        <?php if ( $image_results->have_posts() ) : ?>

          <?php while ( $image_results->have_posts() ) : $image_results->the_post();

            $category   = get_post_meta( get_the_ID(), '_result_category', true );
            $label      = isset( $cat_labels[ $category ] ) ? $cat_labels[ $category ] : '';
            $full_url   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $thumb_url  = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
            $caption    = get_the_title();

            if ( ! $full_url ) {
                continue; // skip entries with no image set
            }
          ?>

            <div class="col-6 col-md-4 col-lg-3 reveal">
              <div class="gallery-item" data-img="<?php echo esc_url( $full_url ); ?>">
                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
                <div class="gallery-overlay">
                  <span><?php echo esc_html( ( $label ? $label . ' — ' : '' ) . $caption ); ?></span>
                </div>
              </div>
            </div>

          <?php endwhile; wp_reset_postdata(); ?>

        <?php else : ?>

          <p class="text-secondary"><?php esc_html_e( 'কোনো ছবি পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

        <?php endif; ?>

      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var filterWrap = document.getElementById('resultFilter');
    var searchBox  = document.getElementById('resultSearch');
    var rows       = document.querySelectorAll('#resultRows .notice-row');

    if (!filterWrap || !rows.length) {
        return;
    }

    function applyFilters() {
        var activeBtn = filterWrap.querySelector('button.active');
        var cat   = activeBtn ? activeBtn.getAttribute('data-cat') : 'all';
        var query = searchBox.value.trim().toLowerCase();

        rows.forEach(function (row) {
            var matchesCat   = (cat === 'all') || (row.getAttribute('data-cat') === cat);
            var matchesTitle = row.getAttribute('data-title').toLowerCase().indexOf(query) !== -1;
            row.style.display = (matchesCat && matchesTitle) ? '' : 'none';
        });
    }

    filterWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;

        filterWrap.querySelectorAll('button').forEach(function (b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        applyFilters();
    });

    searchBox.addEventListener('input', applyFilters);
});
</script>






<?php get_footer(); ?>