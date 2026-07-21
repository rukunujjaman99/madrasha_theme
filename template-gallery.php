<?php
// Template Name: Gallery Page
get_header();
?>


<div class="page-hero">
  <div class="container">
    <h1>ফটো গ্যালারি</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / গ্যালারি</div>
  </div>
</div>

<?php
/**
 * Frontend Output — Full Gallery Page
 * Drop this where the static filterable grid used to be.
 */

$cat_labels = array(
    'campus' => 'ক্যাম্পাস',
    'event'  => 'অনুষ্ঠান',
    'sports' => 'খেলাধুলা',
    'class'  => 'শ্রেণিকক্ষ',
);

$initial_batch = 12; // how many photos show before "আরও ছবি দেখুন" is needed

$gallery_query = new WP_Query( array(
    'post_type'      => 'gallery',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'meta_query'     => array(
        array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ),
    ),
) );

$total_photos = $gallery_query->post_count;
?>

<div class="container my-5">

  <div class="text-center gallery-filter reveal mb-4" id="galleryFilter">
    <button class="active" data-cat="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></button>
    <?php foreach ( $cat_labels as $slug => $label ) : ?>
      <button data-cat="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
    <?php endforeach; ?>
  </div>

  <div class="row g-3" id="galleryGrid">

    <?php if ( $gallery_query->have_posts() ) :

        $i = 0;
        while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
            $i++;

            $category  = get_post_meta( get_the_ID(), '_gallery_category', true );
            $caption   = get_the_title();
            $full_url  = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );

            $is_extra = ( $i > $initial_batch );
    ?>

        <div class="col-6 col-md-4 col-lg-3 reveal<?php echo $is_extra ? ' gallery-extra d-none' : ''; ?>">
            <div class="gallery-item" data-cat="<?php echo esc_attr( $category ); ?>" data-img="<?php echo esc_url( $full_url ); ?>">
                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
                <div class="gallery-overlay"><span><?php echo esc_html( $caption ); ?></span></div>
            </div>
        </div>

    <?php
        endwhile;
        wp_reset_postdata();

    else :
    ?>

        <p class="text-center w-100"><?php esc_html_e( 'কোনো ছবি পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

    <?php endif; ?>

  </div>

  <?php if ( $total_photos > $initial_batch ) : ?>
    <div class="text-center mt-4 reveal">
      <button class="btn" id="galleryLoadMore" style="background:var(--navy);color:#fff;">
        <i class="bi bi-arrow-down-circle"></i> <?php esc_html_e( 'আরও ছবি দেখুন', 'rs-madrasha' ); ?>
      </button>
    </div>
  <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var filterWrap = document.getElementById('galleryFilter');
    var grid       = document.getElementById('galleryGrid');
    var loadMoreBtn = document.getElementById('galleryLoadMore');

    if (!filterWrap || !grid) {
        return;
    }

    function getCols() {
        return grid.querySelectorAll('.col-6');
    }

    filterWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;

        filterWrap.querySelectorAll('button').forEach(function (b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        var cat = btn.getAttribute('data-cat');

        getCols().forEach(function (col) {
            var item = col.querySelector('.gallery-item');
            if (!item) return;

            var matches = (cat === 'all') || (item.getAttribute('data-cat') === cat);

            if (matches) {
                col.classList.remove('d-none');
                // When filtering, ignore the "extra" hidden batching — show all matches
                col.classList.remove('gallery-extra');
            } else {
                col.classList.add('d-none');
            }
        });

        // Hide "Load more" once a specific filter is active (everything matching is already shown)
        if (loadMoreBtn) {
            loadMoreBtn.style.display = (cat === 'all') ? '' : 'none';
        }
    });

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            var hidden = grid.querySelectorAll('.gallery-extra.d-none');
            var batch = Array.prototype.slice.call(hidden, 0, 12);

            batch.forEach(function (col) {
                col.classList.remove('d-none');
            });

            if (grid.querySelectorAll('.gallery-extra.d-none').length === 0) {
                loadMoreBtn.style.display = 'none';
            }
        });
    }
});
</script>


<?php get_footer(); ?>