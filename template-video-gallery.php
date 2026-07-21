<?php
// Template Name: Video Gallery Page
get_header();
?>

<div class="page-hero">
  <div class="container">
    <h1>ভিডিও গ্যালারি</h1>
    <div class="breadcrumb-custom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">হোম</a> / ভিডিও গ্যালারি</div>
  </div>
</div>
<?php
/**
 * Frontend Output — Video Gallery
 * Drop this where the static video grid used to be.
 * Filter buttons are generated dynamically from whatever
 * "video_category" terms currently exist — add a new category
 * in wp-admin and it shows up here automatically.
 */

$categories = get_terms( array(
    'taxonomy'   => 'video_category',
    'hide_empty' => false,
    'orderby'    => 'term_order',
) );

$videos_query = new WP_Query( array(
    'post_type'      => 'video',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>



<div class="container my-5">

  <div class="text-center gallery-filter reveal mb-4" id="videoFilter">
    <button class="active" data-cat="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></button>
    <?php if ( ! is_wp_error( $categories ) ) : ?>
      <?php foreach ( $categories as $term ) : ?>
        <button data-cat="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></button>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="row g-4" id="videoGrid">

    <?php if ( $videos_query->have_posts() ) : ?>

      <?php while ( $videos_query->have_posts() ) : $videos_query->the_post();

        $youtube_id = get_post_meta( get_the_ID(), '_video_youtube_id', true );
        $title      = get_the_title();
        $terms      = get_the_terms( get_the_ID(), 'video_category' );
        $cat_slugs  = ( $terms && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'slug' ) : array();

        if ( ! $youtube_id ) {
            continue; // skip entries with no valid YouTube video set
        }
      ?>

        <div class="col-md-6 col-lg-4 video-col reveal">
          <div class="video-card" data-cat="<?php echo esc_attr( implode( ' ', $cat_slugs ) ); ?>" data-yt="<?php echo esc_attr( $youtube_id ); ?>">
            <div class="video-thumb-wrap">
              <img src="https://img.youtube.com/vi/<?php echo esc_attr( $youtube_id ); ?>/hqdefault.jpg" alt="<?php echo esc_attr( $title ); ?>">
              <div class="play-btn"><i class="bi bi-play-fill"></i></div>
            </div>
            <div class="video-info">
              <h6><?php echo esc_html( $title ); ?></h6>
            </div>
          </div>
        </div>

      <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>

      <p class="text-center w-100"><?php esc_html_e( 'কোনো ভিডিও পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

    <?php endif; ?>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var filterWrap = document.getElementById('videoFilter');
    var grid       = document.getElementById('videoGrid');

    if (!grid) {
        return;
    }

    // Inline play — replaces the thumbnail with an embedded iframe
    // in the SAME card position. No modal/lightbox involved.
    grid.addEventListener('click', function (e) {
        var playBtn = e.target.closest('.play-btn');
        if (!playBtn) return;

        var card      = playBtn.closest('.video-card');
        var thumbWrap = card.querySelector('.video-thumb-wrap');
        var ytId      = card.getAttribute('data-yt');

        if (!ytId || !thumbWrap) return;

        var iframe = document.createElement('iframe');
        iframe.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0';
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
        iframe.setAttribute('allowfullscreen', '');
        iframe.style.width = '100%';
        iframe.style.height = '100%';
        iframe.style.position = 'absolute';
        iframe.style.top = '0';
        iframe.style.left = '0';

        thumbWrap.style.position = 'relative';
        thumbWrap.innerHTML = '';
        thumbWrap.appendChild(iframe);
    });

    if (!filterWrap) {
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

        grid.querySelectorAll('.video-col').forEach(function (col) {
            var card = col.querySelector('.video-card');
            if (!card) return;

            var cardCats = card.getAttribute('data-cat').split(' ');
            var show = (cat === 'all') || cardCats.indexOf(cat) !== -1;
            col.style.display = show ? '' : 'none';
        });
    });
});
</script>







<?php get_footer(); ?>