<?php
// Template Name: Publication Page
get_header();
?>

<div class="page-hero">
  <div class="container">
    <h1>প্রকাশনা</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / প্রকাশনা</div>
  </div>
</div>

<?php
/**
 * Frontend Output — Publications Grid
 * Drop this where the static publication cards used to be.
 */

$publications_query = new WP_Query( array(
    'post_type'      => 'publication',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

<div class="container my-5">
  <div class="row g-4">

    <?php if ( $publications_query->have_posts() ) : ?>

      <?php while ( $publications_query->have_posts() ) : $publications_query->the_post();

        $icon        = get_post_meta( get_the_ID(), '_publication_icon', true ) ?: 'bi bi-journal-richtext';
        $description = get_post_meta( get_the_ID(), '_publication_description', true );
        $file_id     = get_post_meta( get_the_ID(), '_publication_file', true );
        $file_url    = $file_id ? wp_get_attachment_url( $file_id ) : '';
      ?>

        <div class="col-md-6 col-lg-4 reveal">
          <div class="pub-card">
            <div class="pub-cover"><i class="<?php echo esc_attr( $icon ); ?>"></i></div>
            <div class="pub-body">
              <h6><?php the_title(); ?></h6>

              <?php if ( $description ) : ?>
                <small class="text-secondary d-block mb-2"><?php echo esc_html( $description ); ?></small>
              <?php endif; ?>

              <?php if ( $file_url ) : ?>
                <a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener"
                   class="btn btn-sm w-100" style="background:var(--rose);color:#fff;">
                  <i class="bi bi-file-earmark-pdf"></i> <?php esc_html_e( 'PDF ডাউনলোড', 'rs-madrasha' ); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

      <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>

      <p class="text-center w-100"><?php esc_html_e( 'কোনো প্রকাশনা পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

    <?php endif; ?>

  </div>
</div>

<?php get_footer(); ?>