<?php
/**
 * Dynamic Footer
 * Pulls all values from the Customizer (rs_footer_customizer settings).
 * Second argument of get_theme_mod() is the fallback shown until admin sets a value.
 */

// Logo
$rs_logo_id = get_theme_mod( 'rs_footer_logo' );
?>
<footer class="pt-5 pb-0">
  <div class="container">
    <div class="row g-4">

      <!-- Institution Info -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-2">
          <?php if ( $rs_logo_id ) :
            echo wp_get_attachment_image( $rs_logo_id, 'thumbnail', false, array(
              'style' => 'width:46px;height:46px;border-radius:50%;object-fit:cover;',
            ) );
          else : ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>"
                 style="width:46px;height:46px;border-radius:50%;object-fit:cover;"
                 alt="<?php esc_attr_e( 'Logo', 'rs-madrasha' ); ?>">
          <?php endif; ?>
          <strong style="color:#fff;">
            <?php echo esc_html( get_theme_mod( 'rs_footer_name', 'কাউনিয়া বালিকা ফাজিল' ) ); ?>
          </strong>
        </div>

        <?php $rs_address = get_theme_mod( 'rs_footer_address', 'কাউনিয়া, বরিশাল সদর, বরিশাল' );
        if ( $rs_address ) : ?>
          <p class="mb-1"><?php echo esc_html( $rs_address ); ?></p>
        <?php endif;

        $rs_phone = get_theme_mod( 'rs_footer_phone', '০১৩০৯-১০৭৯০৬ (অধ্যক্ষ)' );
        if ( $rs_phone ) : ?>
          <p class="mb-1"><?php echo esc_html( $rs_phone ); ?></p>
        <?php endif;

        $rs_email = get_theme_mod( 'rs_footer_email', 'kawniagirls.fazil@gmail.com' );
        if ( $rs_email ) : ?>
          <p class="mb-1"><a href="mailto:<?php echo esc_attr( $rs_email ); ?>"><?php echo esc_html( $rs_email ); ?></a></p>
        <?php endif;

        $rs_website = get_theme_mod( 'rs_footer_website', 'kgfmm.edu.bd' );
        if ( $rs_website ) : ?>
          <p class="mb-0"><a href="<?php echo esc_url( $rs_website ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $rs_website ); ?></a></p>
        <?php endif; ?>
      </div>

      <!-- Important Links -->
      <div class="col-lg-3 col-md-6">
        <h6><?php echo esc_html( get_theme_mod( 'rs_footer_links_heading', 'গুরুত্বপূর্ণ লিংকসমূহ' ) ); ?></h6>
        <ul class="list-unstyled">
          <?php
          $rs_links_default = array(
            1 => 'বাংলাদেশ মাদরাসা শিক্ষা বোর্ড',
            2 => 'বাংলাদেশ মাদরাসা শিক্ষা অধিদপ্তর',
            3 => 'ইসলামি আরবি বিশ্ববিদ্যালয়',
            4 => 'শিক্ষা মন্ত্রণালয়',
          );
          for ( $i = 1; $i <= 4; $i++ ) :
            $rs_link_text = get_theme_mod( "rs_footer_link{$i}_text", $rs_links_default[ $i ] );
            $rs_link_url  = get_theme_mod( "rs_footer_link{$i}_url", '#' );
            if ( $rs_link_text ) :
          ?>
            <li class="mb-2">
              <a href="<?php echo esc_url( $rs_link_url ); ?>">
                <i class="bi bi-caret-right-fill"></i> <?php echo esc_html( $rs_link_text ); ?>
              </a>
            </li>
          <?php
            endif;
          endfor;
          ?>
        </ul>
      </div>

      <!-- Pages -->
      <div class="col-lg-3 col-md-6">
        <h6><?php echo esc_html( get_theme_mod( 'rs_footer_pages_heading', 'পেইজ সমূহ' ) ); ?></h6>
        <ul class="list-unstyled">
          <?php
          $rs_pages_default = array(
            1 => array( 'পরিচিতি', 'about.html' ),
            2 => array( 'শিক্ষকবৃন্দ', 'teachers.html' ),
            3 => array( 'নোটিশ বোর্ড', 'notice.html' ),
            4 => array( 'গ্যালারি', 'gallery.html' ),
            5 => array( 'যোগাযোগ', 'contact.html' ),
          );
          for ( $i = 1; $i <= 5; $i++ ) :
            $rs_page_text = get_theme_mod( "rs_footer_page{$i}_text", $rs_pages_default[ $i ][0] );
            $rs_page_url  = get_theme_mod( "rs_footer_page{$i}_url", $rs_pages_default[ $i ][1] );
            if ( $rs_page_text ) :
          ?>
            <li class="mb-2">
              <a href="<?php echo esc_url( $rs_page_url ); ?>">
                <i class="bi bi-caret-right-fill"></i> <?php echo esc_html( $rs_page_text ); ?>
              </a>
            </li>
          <?php
            endif;
          endfor;
          ?>
        </ul>
      </div>

      <!-- Facebook Widget -->
      <div class="col-lg-3 col-md-6">
        <div class="fb-widget">
          <div class="fb-widget-head">
            <i class="bi bi-facebook fs-5"></i>
            <?php echo esc_html( get_theme_mod( 'rs_footer_fb_title', 'কাউনিয়া বালিকা ফাজিল...' ) ); ?>
            <br>
            <small><?php echo esc_html( get_theme_mod( 'rs_footer_fb_followers', '৮৩,৭৩৫ ফলোয়ার' ) ); ?></small>
          </div>
          <div class="p-2 d-flex gap-2">
            <?php $rs_fb_url = get_theme_mod( 'rs_footer_fb_url', '#' ); ?>
            <a href="<?php echo esc_url( $rs_fb_url ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary flex-fill">
              <?php echo esc_html( get_theme_mod( 'rs_footer_follow_btn', 'Follow Page' ) ); ?>
            </a>
            <a href="<?php echo esc_url( $rs_fb_url ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary flex-fill">
              <?php echo esc_html( get_theme_mod( 'rs_footer_share_btn', 'Share' ) ); ?>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Copyright Bar -->
  <div class="footer-bottom mt-4 text-center">
    <?php
    echo esc_html( get_theme_mod( 'rs_footer_copyright', 'Copyright © 2015, Kawnia Girls Fazil Model Madrasah, Barishal. All Rights Reserved.' ) );

    $rs_support_text = get_theme_mod( 'rs_footer_support_text', 'Technical Support' );
    $rs_support_name = get_theme_mod( 'rs_footer_support_name', 'Rukunujjaman' );
    $rs_support_url  = get_theme_mod( 'rs_footer_support_url', '#' );

    if ( $rs_support_name ) :
    ?>
      &nbsp;|&nbsp;
      <?php echo esc_html( $rs_support_text ); ?>:
      <a href="<?php echo esc_url( $rs_support_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $rs_support_name ); ?></a>
    <?php endif; ?>
  </div>
</footer>

<button id="backTop"><i class="bi bi-arrow-up"></i></button>
<?php wp_footer(); ?>