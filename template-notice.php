<?php 
// Template Name: Notice Board
get_header();
?>

<div class="page-hero">
  <div class="container">
    <h1>নোটিশ বোর্ড</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / নোটিশ</div>
  </div>
</div>

<div class="container my-5">
  <div class="row g-4">
   <?php
/**
 * Template Part: Notice List Column
 * Usage: get_template_part( 'template-parts/notice-list' );
 * (Place inside your own <div class="col-lg-9"> ... </div> wrapper, or use as-is.)
 */

$dept_labels = array(
    'dakhil'    => 'দাখিল',
    'alim'      => 'আলিম',
    'fazil'     => 'ফাযিল',
    'kamil'     => 'কামিল',
    'admission' => 'ভর্তি',
);

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$notices_query = new WP_Query( array(
    'post_type'      => 'notice',
    'posts_per_page' => 8,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

if ( ! function_exists( 'rs_notice_file_icon' ) ) {
    function rs_notice_file_icon( $url ) {
        $ext = strtolower( pathinfo( $url, PATHINFO_EXTENSION ) );
        switch ( $ext ) {
            case 'pdf':   return 'bi bi-file-earmark-pdf';
            case 'doc':
            case 'docx':  return 'bi bi-file-earmark-word';
            case 'jpg':
            case 'jpeg':
            case 'png':   return 'bi bi-file-earmark-image';
            default:       return 'bi bi-file-earmark';
        }
    }
}
?>

<div class="col-lg-9">

  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 reveal">
    <div class="notice-filter" id="noticeFilter">
      <button class="active" data-cat="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></button>
      <?php foreach ( $dept_labels as $slug => $label ) : ?>
        <button data-cat="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
      <?php endforeach; ?>
    </div>
    <input id="noticeSearch" type="text" class="form-control" style="max-width:240px;"
           placeholder="<?php esc_attr_e( 'নোটিশ খুঁজুন...', 'rs-madrasha' ); ?>">
  </div>

  <div class="reveal" id="noticeRows">

    <?php if ( $notices_query->have_posts() ) : ?>

      <?php while ( $notices_query->have_posts() ) : $notices_query->the_post();

        $dept      = get_post_meta( get_the_ID(), '_notice_dept', true );
        $tag_label = get_post_meta( get_the_ID(), '_notice_tag_label', true );
        $file_id   = get_post_meta( get_the_ID(), '_notice_file', true );
        $file_url  = $file_id ? wp_get_attachment_url( $file_id ) : '';
        $title     = get_the_title();

        $badge = $tag_label ? $tag_label : ( isset( $dept_labels[ $dept ] ) ? $dept_labels[ $dept ] : '' );
      ?>

      <div class="notice-row" data-cat="<?php echo esc_attr( $dept ); ?>" data-title="<?php echo esc_attr( $title ); ?>">
        <div>
          <span class="tag"><?php echo esc_html( $badge ); ?></span>
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
              <i class="bi bi-download"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>

      <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>

      <p class="text-secondary"><?php esc_html_e( 'কোনো নোটিশ পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

    <?php endif; ?>

    <p class="text-secondary small mt-2 d-none" id="noticeNoResults">
      <?php esc_html_e( 'এই পাতায় কোনো ফলাফল পাওয়া যায়নি।', 'rs-madrasha' ); ?>
    </p>

  </div>

  <?php if ( $notices_query->max_num_pages > 1 ) :

      $page_links = paginate_links( array(
          'total'     => $notices_query->max_num_pages,
          'current'   => $paged,
          'prev_text' => __( 'আগে', 'rs-madrasha' ),
          'next_text' => __( 'পরে', 'rs-madrasha' ),
          'type'      => 'array',
          'mid_size'  => 1,
          'end_size'  => 1,
      ) );
  ?>
  <nav class="mt-4 reveal">
    <ul class="pagination justify-content-center">
      <?php foreach ( $page_links as $link ) :
          $is_current = ( false !== strpos( $link, 'current' ) );
          $is_dots    = ( false !== strpos( $link, 'dots' ) );
          $li_class   = $is_dots ? 'page-item disabled' : ( $is_current ? 'page-item active' : 'page-item' );
          $style      = $is_current
              ? ' style="background:var(--navy);border-color:var(--navy);"'
              : ' style="color:var(--navy);"';
          $link = preg_replace( '/class="[^"]*"/', 'class="page-link"' . $style, $link, 1 );
      ?>
        <li class="<?php echo esc_attr( $li_class ); ?>"><?php echo $link; ?></li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var filterWrap = document.getElementById('noticeFilter');
    var searchBox  = document.getElementById('noticeSearch');
    var rows       = document.querySelectorAll('#noticeRows .notice-row');
    var noResults  = document.getElementById('noticeNoResults');

    if (!filterWrap || !rows.length) {
        return;
    }

    function applyFilters() {
        var activeBtn = filterWrap.querySelector('button.active');
        var cat   = activeBtn ? activeBtn.getAttribute('data-cat') : 'all';
        var query = searchBox.value.trim().toLowerCase();
        var visibleCount = 0;

        rows.forEach(function (row) {
            var matchesCat   = (cat === 'all') || (row.getAttribute('data-cat') === cat);
            var matchesTitle = row.getAttribute('data-title').toLowerCase().indexOf(query) !== -1;
            var show = matchesCat && matchesTitle;

            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        if (noResults) {
            noResults.classList.toggle('d-none', visibleCount !== 0);
        }
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

    <div class="col-lg-3">
      <div class="side-card reveal">
        <div class="side-card-head navy">ফরম ডাউনলোড</div>
        <div class="side-card-body">
          <div class="dl-list">
            <a href="#"><i class="bi bi-file-earmark-pdf"></i> ভর্তি নির্দেশিকা-২০২৬</a>
            <a href="#"><i class="bi bi-file-earmark-pdf"></i> ভর্তি ফরম আলিম</a>
            <a href="#"><i class="bi bi-file-earmark-pdf"></i> ভর্তি ফরম কামিল</a>
          </div>
        </div>
      </div>
      <div class="side-card reveal">
        <div class="side-card-head">যোগাযোগ</div>
        <div class="side-card-body small">
          <p class="mb-1"><i class="bi bi-telephone"></i> ০১৩০৯-১০৭৯০৬</p>
          <p class="mb-0"><i class="bi bi-envelope"></i> kawniagirls.fazil@gmail.com</p>
        </div>
      </div>

    </div>
  </div>
</div>

<?php get_footer(); ?>
