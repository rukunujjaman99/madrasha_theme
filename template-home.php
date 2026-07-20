

<?php 
// Template Name: Home Page

get_header(); ?>
<!-- header end -->

<!-- TICKER -->
<?php
/**
 * Notice Ticker — Dynamic
 * Pulls the latest notices and feeds them into the scrolling ticker.
 * The item list is rendered twice back-to-back (a standard marquee trick)
 * so a CSS animation can loop seamlessly without a visible jump/reset.
 */

$ticker_notices = new WP_Query( array(
    'post_type'      => 'notice',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

$ticker_items = array();

if ( $ticker_notices->have_posts() ) {
    while ( $ticker_notices->have_posts() ) {
        $ticker_notices->the_post();

        $file_id  = get_post_meta( get_the_ID(), '_notice_file', true );
        $file_url = $file_id ? wp_get_attachment_url( $file_id ) : '';

        $ticker_items[] = array(
            'title' => get_the_title(),
            'url'   => $file_url ? $file_url : get_permalink(),
        );
    }
    wp_reset_postdata();
}
?>

<div class="ticker-wrap d-flex align-items-center">
    <span class="ticker-label"><?php esc_html_e( 'নোটিশঃ', 'rs-madrasha' ); ?></span>

    <?php if ( ! empty( $ticker_items ) ) : ?>

        <span class="ticker-track">
            <?php
            // Render the list TWICE in a row so the marquee loop has no visible gap/jump.
            for ( $repeat = 0; $repeat < 2; $repeat++ ) :
                foreach ( $ticker_items as $item ) :
            ?>
                <span>
                    <a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener"
                       style="color:inherit;text-decoration:none;">
                        <?php echo esc_html( $item['title'] ); ?>
                    </a>
                </span>
            <?php
                endforeach;
            endfor;
            ?>
        </span>

    <?php else : ?>

        <span class="ticker-track">
            <span><?php esc_html_e( 'কোনো নতুন নোটিশ নেই।', 'rs-madrasha' ); ?></span>
        </span>

    <?php endif; ?>
</div>

<!-- MAIN -->
<div class="container my-4" id="home">
  <div class="row g-4">

    <!-- LEFT -->
    <div class="col-lg-8">
    <div class="main-slider mb-4 reveal">

    <div class="slider-track" id="sliderTrack">

        <?php
        $slider = new WP_Query(array(
            'post_type'      => 'slider',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC'
        ));

        if ($slider->have_posts()) :
            while ($slider->have_posts()) : $slider->the_post();
        ?>

            <div class="slider-slide">

                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('full', array(
                        'alt' => get_the_title()
                    ));
                }
                ?>

                <div class="slide-caption">
                    <?php the_title(); ?>
                </div>

            </div>

        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

    </div>

    <button class="slider-arrow" style="left:10px" onclick="changeSlide(-1)">
        <i class="bi bi-chevron-left"></i>
    </button>

    <button class="slider-arrow" style="right:10px" onclick="changeSlide(1)">
        <i class="bi bi-chevron-right"></i>
    </button>

    <div class="slider-dots" id="sliderDots"></div>

</div>

    <div class="welcome-block reveal">

    <h2>
        <?php echo esc_html(get_theme_mod('rs_home_about_title')); ?>
    </h2>

    <hr style="border-color:var(--orange);width:70px;border-width:2px;opacity:1;">

    <p>
        <?php
        echo nl2br(
            esc_html(
                get_theme_mod('rs_home_about_description')
            )
        );
        ?>
    </p>

    <?php if(get_theme_mod('rs_home_about_more')): ?>

    <p class="more-text" style="display:none;">

        <?php
        echo nl2br(
            esc_html(
                get_theme_mod('rs_home_about_more')
            )
        );
        ?>

    </p>

    <span class="read-more-toggle" onclick="toggleMore(this)">

        <?php echo esc_html(get_theme_mod('rs_home_about_btn','আরও পড়ুন')); ?>

        <i class="bi bi-chevron-down"></i>

    </span>

    <?php endif; ?>

</div>

      <!-- NEW: features -->
     <?php
/**
 * Frontend Output — Madrasha Feature Section
 * Drop this where the static "কেন কাউনিয়া বালিকা ফাজিল" block used to be
 * (e.g. front-page.php / home.php / a template part).
 *
 * Pulls the latest published "madrasha_feature" post.
 * Post Title  -> Section Title
 * Repeater    -> Feature Cards (icon, title, description)
 */

$feature_post = get_posts( array(
    'post_type'      => 'madrasha_feature',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

if ( ! empty( $feature_post ) ) :

    $feature_post = $feature_post[0];
    $section_title = get_the_title( $feature_post->ID );
    $items = get_post_meta( $feature_post->ID, '_rs_feature_items', true );

    if ( is_array( $items ) && ! empty( $items ) ) :
    ?>

    <div class="mt-5 reveal">
        <div class="section-title text-start">
            <h3 style="font-size:1.3rem;"><?php echo esc_html( $section_title ); ?></h3>
        </div>
        <div class="row g-3">
            <?php foreach ( $items as $item ) :
                if ( empty( $item['title'] ) && empty( $item['desc'] ) ) {
                    continue;
                }
            ?>
            <div class="col-6 col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                    </div>
                    <h6 class="fw-bold" style="color:var(--navy)">
                        <?php echo esc_html( $item['title'] ); ?>
                    </h6>
                    <small class="text-secondary">
                        <?php echo esc_html( $item['desc'] ); ?>
                    </small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    endif;
endif;
?>

      <!-- Best of the year -->
     <?php
/**
 * Frontend Output — Best Students Section
 * Drop this where the static "এ বছরের সেরা শিক্ষার্থী" block used to be.
 */

$dept_labels = array(
    'dakhil' => 'দাখিল',
    'alim'   => 'আলিম',
    'fazil'  => 'ফাযিল',
    'kamil'  => 'কামিল',
);

$students = new WP_Query( array(
    'post_type'      => 'student',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

<div class="my-5 reveal" id="best">
    <div class="section-title">
        <h3><?php echo esc_html( get_theme_mod( 'rs_student_title', 'এ বছরের সেরা শিক্ষার্থী' ) ); ?></h3>
        <p><?php echo esc_html( get_theme_mod( 'rs_student_subtitle', 'বিভাগ অনুযায়ী ফিল্টার করুন, বিস্তারিত দেখতে ছবিতে ক্লিক করুন' ) ); ?></p>
    </div>

    <div class="text-center gallery-filter mb-4" id="studentFilter">
        <button class="active" data-dept="all"><?php esc_html_e( 'সকল', 'rs-madrasha' ); ?></button>
        <?php foreach ( $dept_labels as $slug => $label ) : ?>
            <button data-dept="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
        <?php endforeach; ?>
    </div>

    <div class="row g-3" id="studentGrid">

        <?php if ( $students->have_posts() ) : ?>

            <?php while ( $students->have_posts() ) : $students->the_post();

                $dept   = get_post_meta( get_the_ID(), '_student_dept', true );
                $result = get_post_meta( get_the_ID(), '_student_result', true );
                $roll   = get_post_meta( get_the_ID(), '_student_roll', true );
                $name   = get_the_title();
                $dept_label = isset( $dept_labels[ $dept ] ) ? $dept_labels[ $dept ] : '';

                $img_url = has_post_thumbnail()
                    ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
                    : '';

                $info = array(
                    'name' => $name,
                    'dept' => $dept_label . ' বিভাগ',
                    'res'  => $result,
                    'roll' => $roll,
                    'img'  => $img_url,
                );
            ?>

            <div class="col-6 col-md-3 student-col">
                <div class="student-card"
                     data-dept="<?php echo esc_attr( $dept ); ?>"
                     data-bs-toggle="modal"
                     data-bs-target="#stuModal"
                     data-info='<?php echo esc_attr( wp_json_encode( $info ) ); ?>'>

                    <?php if ( $img_url ) : ?>
                        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>">
                    <?php endif; ?>

                    <?php if ( $result ) : ?>
                        <div class="student-badge"><?php echo esc_html( $result ); ?></div>
                    <?php endif; ?>

                    <div class="cap"><?php echo esc_html( $name . ' — ' . $dept_label ); ?></div>
                </div>
            </div>

            <?php endwhile; wp_reset_postdata(); ?>

        <?php else : ?>

            <p class="text-center w-100"><?php esc_html_e( 'কোনো শিক্ষার্থী পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

        <?php endif; ?>

    </div>
</div>

      <!-- student detail modal -->
      <div class="modal fade" id="stuModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header" style="background:var(--navy);color:#fff;">
              <h5 class="modal-title">শিক্ষার্থীর তথ্য</h5>
              <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
              <img id="stuImg" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover;border:3px solid var(--orange);">
              <h5 id="stuName" class="fw-bold" style="color:var(--navy)"></h5>
              <span id="stuDept" class="dept-tag"></span>
              <p class="mt-3 mb-1"><b>ফলাফল:</b> <span id="stuRes"></span></p>
              <p class="mb-0"><span id="stuRoll"></span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- NEW: upcoming event countdown -->
      <div class="reveal p-4 mb-5" style="background:var(--cream);border-radius:10px;">
        <div class="row align-items-center g-3">
          <div class="col-md-6">
            <div class="eyebrow" style="color:var(--rose);font-weight:700;letter-spacing:.05em;">আসন্ন অনুষ্ঠান</div>
            <h5 class="fw-bold" style="color:var(--navy)">নতুন শিক্ষাবর্ষ ১৪৪৮ হিজরী উদ্বোধন</h5>
            <p class="mb-0 text-secondary">১লা সেপ্টেম্বর, ২০২৬ — সকাল ৯টায় কেন্দ্রীয় মিলনায়তনে</p>
          </div>
          <div class="col-md-6">
            <div id="eventCountdown" class="d-flex gap-2 justify-content-md-end justify-content-start">
              <div class="text-center"><div class="fs-4 fw-bold cd-d" style="color:var(--rose)">00</div><small>দিন</small></div>
              <div class="text-center"><div class="fs-4 fw-bold cd-h" style="color:var(--rose)">00</div><small>ঘণ্টা</small></div>
              <div class="text-center"><div class="fs-4 fw-bold cd-m" style="color:var(--rose)">00</div><small>মিনিট</small></div>
              <div class="text-center"><div class="fs-4 fw-bold cd-s" style="color:var(--rose)">00</div><small>সেকেন্ড</small></div>
            </div>
          </div>
        </div>
      </div>

    <?php
/**
 * Frontend Output — Madrasha History Accordion
 * Drop this where the static accordion block used to be.
 * Order controlled via "Page Attributes -> Order" (menu_order) on each post.
 */

$history_items = new WP_Query( array(
    'post_type'      => 'madrasha_history',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

<div class="reveal">
    <h4 class="font-display mb-3" style="color:var(--navy)"><?php esc_html_e( 'প্রতিষ্ঠার সংক্ষিপ্ত ইতিহাস', 'rs-madrasha' ); ?></h4>

    <?php if ( $history_items->have_posts() ) : ?>

        <div class="accordion" id="histAcc">

            <?php
            $i = 0;
            while ( $history_items->have_posts() ) : $history_items->the_post();
                $i++;
                $item_id   = 'a' . $i;
                $is_first  = ( 1 === $i );
            ?>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?php echo esc_attr( $item_id ); ?>">
                        <?php the_title(); ?>
                    </button>
                </h2>
                <div id="<?php echo esc_attr( $item_id ); ?>"
                     class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
                     data-bs-parent="#histAcc">
                    <div class="accordion-body">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

            <?php endwhile; wp_reset_postdata(); ?>

        </div>

    <?php else : ?>

        <p class="text-secondary"><?php esc_html_e( 'কোনো ইতিহাস যোগ করা হয়নি।', 'rs-madrasha' ); ?></p>

    <?php endif; ?>

    <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>"
       class="btn btn-sm mt-3" style="background:var(--navy);color:#fff;">
        <?php esc_html_e( 'বিস্তারিত জানুন »', 'rs-madrasha' ); ?>
    </a>
</div>

    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="col-lg-4">

      <div class="side-card text-center reveal">
      <?php
/**
 * Frontend Output — Principal Card
 * Drop this where the static principal block used to be.
 */

$rs_photo_id = get_theme_mod( 'rs_principal_photo' );
?>
<div class="side-card-body">

    <?php if ( $rs_photo_id ) :
        echo wp_get_attachment_image( $rs_photo_id, 'medium', false, array(
            'class' => 'principal-photo mb-2',
            'alt'   => esc_attr( get_theme_mod( 'rs_principal_name', 'অধ্যক্ষ' ) ),
        ) );
    else : ?>
        <img class="principal-photo mb-2"
             src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/principal.png' ); ?>"
             alt="<?php esc_attr_e( 'অধ্যক্ষ', 'rs-madrasha' ); ?>">
    <?php endif; ?>

    <div style="color:var(--rose);font-weight:700;">
        <?php echo esc_html( get_theme_mod( 'rs_principal_badge', 'প্রতিষ্ঠাতা অধ্যক্ষ' ) ); ?>
    </div>

    <div class="font-display fw-bold" style="color:var(--navy)">
        <?php echo esc_html( get_theme_mod( 'rs_principal_name', 'মাওলানা মোহাম্মদ আমির হোসেন তালুকদার' ) ); ?>
    </div>

    <small class="text-secondary d-block mb-2">
        <?php echo esc_html( get_theme_mod( 'rs_principal_qualification', 'কামিল (হাদিস, তাফসীর) ১ম শ্রেণি; দাওরায়ে হাদিস-১ম শ্রেণি; এম.এ, বি.এড-১ম শ্রেণি' ) ); ?>
    </small>

    <a href="<?php echo esc_url( get_theme_mod( 'rs_principal_btn_url', '#principal-speech' ) ); ?>"
       class="btn btn-sm w-100" style="background:var(--green);color:#fff;">
        <?php echo esc_html( get_theme_mod( 'rs_principal_btn_text', 'অধ্যক্ষের বাণী পড়ুন »' ) ); ?>
    </a>

</div>

      </div>

   <?php
/**
 * Frontend Output — Notice Board Widget
 * Drop this where the static notice board block used to be.
 */

$dept_labels = array(
    'dakhil' => 'দাখিল',
    'alim'   => 'আলিম',
    'fazil'  => 'ফাযিল',
    'kamil'  => 'কামিল',
);

$notices = new WP_Query( array(
    'post_type'      => 'notice',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

// Helper: pick an icon class by file extension
function rs_notice_file_icon( $url ) {
    $ext = strtolower( pathinfo( $url, PATHINFO_EXTENSION ) );
    switch ( $ext ) {
        case 'pdf':
            return 'bi bi-file-earmark-pdf-fill text-danger';
        case 'doc':
        case 'docx':
            return 'bi bi-file-earmark-word-fill text-primary';
        case 'jpg':
        case 'jpeg':
        case 'png':
            return 'bi bi-file-earmark-image-fill text-success';
        default:
            return 'bi bi-file-earmark-fill text-secondary';
    }
}
?>

<div class="side-card reveal" id="notice">
    <div class="side-card-head"><?php esc_html_e( 'নোটিশ বোর্ড', 'rs-madrasha' ); ?></div>
    <div class="side-card-body">

        <div class="notice-grid" id="noticeGrid">
            <?php $first = true; foreach ( $dept_labels as $slug => $label ) : ?>
                <button class="<?php echo $first ? 'active' : ''; ?>" data-t="<?php echo esc_attr( $slug ); ?>">
                    <?php echo esc_html( $label ); ?>
                </button>
            <?php $first = false; endforeach; ?>
        </div>

        <div class="notice-result-list" id="noticeList">

            <?php if ( $notices->have_posts() ) : ?>

                <?php while ( $notices->have_posts() ) : $notices->the_post();

                    $dept    = get_post_meta( get_the_ID(), '_notice_dept', true );
                    $file_id = get_post_meta( get_the_ID(), '_notice_file', true );
                    $file_url = $file_id ? wp_get_attachment_url( $file_id ) : '';
                ?>

                    <a href="<?php echo $file_url ? esc_url( $file_url ) : '#'; ?>"
                       target="_blank" rel="noopener"
                       class="notice-item"
                       data-t="<?php echo esc_attr( $dept ); ?>">
                        <i class="<?php echo esc_attr( rs_notice_file_icon( $file_url ) ); ?>"></i>
                        <span class="notice-title"><?php echo esc_html( get_the_title() ); ?></span>
                        <span class="notice-date"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></span>
                    </a>

                <?php endwhile; wp_reset_postdata(); ?>

            <?php else : ?>

                <p class="text-secondary small mb-0"><?php esc_html_e( 'কোনো নোটিশ পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

            <?php endif; ?>

        </div>

        <a href="<?php echo esc_url( get_post_type_archive_link( 'notice' ) ); ?>"
           class="btn btn-sm w-100 mt-2" style="background:var(--green);color:#fff;">
            <?php esc_html_e( 'সমস্ত নোটিশ দেখুন »', 'rs-madrasha' ); ?>
        </a>

    </div>
</div>

      <?php
/**
 * Frontend Output — Download Forms Widget
 * Drop this where the static download list block used to be.
 */

$downloads = new WP_Query( array(
    'post_type'      => 'download_form',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );

if ( ! function_exists( 'rs_notice_file_icon' ) ) {
    // Reuse the same icon helper if it's not already defined elsewhere (e.g. by the Notice template)
    function rs_notice_file_icon( $url ) {
        $ext = strtolower( pathinfo( $url, PATHINFO_EXTENSION ) );
        switch ( $ext ) {
            case 'pdf':
                return 'bi bi-file-earmark-pdf';
            case 'doc':
            case 'docx':
                return 'bi bi-file-earmark-word';
            case 'jpg':
            case 'jpeg':
            case 'png':
                return 'bi bi-file-earmark-image';
            default:
                return 'bi bi-file-earmark';
        }
    }
}
?>

<div class="side-card reveal" id="downloads">
    <div class="side-card-head navy"><?php esc_html_e( 'ফরম ডাউনলোড', 'rs-madrasha' ); ?></div>
    <div class="side-card-body">

        <div class="dl-list">

            <?php if ( $downloads->have_posts() ) : ?>

                <?php while ( $downloads->have_posts() ) : $downloads->the_post();

                    $file_id  = get_post_meta( get_the_ID(), '_download_file', true );
                    $file_url = $file_id ? wp_get_attachment_url( $file_id ) : '';

                    if ( ! $file_url ) {
                        continue; // Skip items with no file attached
                    }
                ?>

                    <a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener">
                        <i class="<?php echo esc_attr( rs_notice_file_icon( $file_url ) ); ?>"></i>
                        <?php echo esc_html( get_the_title() ); ?>
                    </a>

                <?php endwhile; wp_reset_postdata(); ?>

            <?php else : ?>

                <p class="text-secondary small mb-0"><?php esc_html_e( 'কোনো ফরম পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

            <?php endif; ?>

        </div>

        <a href="<?php echo esc_url( home_url( '/admission' ) ); ?>"
           class="btn btn-sm w-100 mt-2" style="background:var(--orange);color:#1c1c1c;">
            <?php esc_html_e( 'সকল ভর্তি ফরম »', 'rs-madrasha' ); ?>
        </a>

    </div>
</div>

      <div class="side-card reveal">
        <div class="cal-head">
          <button id="prevMonth"><i class="bi bi-chevron-left"></i></button>
          <span id="calTitle">জুলাই ২০২৬</span>
          <button id="nextMonth"><i class="bi bi-chevron-right"></i></button>
        </div>
        <div class="side-card-body">
          <table class="cal-table">
            <thead><tr><th>শনি</th><th>রবি</th><th>সোম</th><th>মঙ্গল</th><th>বুধ</th><th>বৃহঃ</th><th>শুক্র</th></tr></thead>
            <tbody id="calBody"></tbody>
          </table>
        </div>
      </div>

      <!-- NEW: quick gallery preview -->
     <?php
/**
 * Frontend Output — Recent Photos Widget
 * Drop this where the static 3-photo block used to be.
 */

$gallery_photos = new WP_Query( array(
    'post_type'      => 'gallery',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => array(
        array(
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
) );
?>

<div class="side-card reveal">
    <div class="side-card-head navy"><?php esc_html_e( 'সাম্প্রতিক ছবি', 'rs-madrasha' ); ?></div>
    <div class="side-card-body">

        <?php if ( $gallery_photos->have_posts() ) : ?>

            <div class="row g-2">
                <?php while ( $gallery_photos->have_posts() ) : $gallery_photos->the_post(); ?>
                    <div class="col-4">
                        <a href="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>"
                           target="_blank" rel="noopener">
                            <?php
                            the_post_thumbnail( 'thumbnail', array(
                                'class' => 'w-100 rounded',
                                'style' => 'height:60px;object-fit:cover;',
                                'alt'   => esc_attr( get_the_title() ),
                            ) );
                            ?>
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        <?php else : ?>

            <p class="text-secondary small mb-0"><?php esc_html_e( 'কোনো ছবি পাওয়া যায়নি।', 'rs-madrasha' ); ?></p>

        <?php endif; ?>

        <a href="<?php echo esc_url( get_post_type_archive_link( 'gallery' ) ); ?>"
           class="btn btn-sm w-100 mt-2" style="background:var(--orange);color:#1c1c1c;">
            <?php esc_html_e( 'সম্পূর্ণ গ্যালারি »', 'rs-madrasha' ); ?>
        </a>

    </div>
</div>

    </div>
  </div>
</div>

<!-- NEW: stat strip -->
<div class="stat-strip reveal">
  <div class="container">
    <div class="row text-center g-3">
      <div class="col-6 col-lg-3"><span class="stat-num" data-count="80">0</span><span class="stat-label">বছরের ঐতিহ্য</span></div>
      <div class="col-6 col-lg-3"><span class="stat-num" data-count="3500">0</span><span class="stat-label">শিক্ষার্থী</span></div>
      <div class="col-6 col-lg-3"><span class="stat-num" data-count="120">0</span><span class="stat-label">শিক্ষক ও কর্মকর্তা</span></div>
      <div class="col-6 col-lg-3"><span class="stat-num" data-count="6">0</span><span class="stat-label">শাখা প্রতিষ্ঠান</span></div>
    </div>
  </div>
</div>

<!-- NEW: programs -->
<div class="container my-5">
  <div class="section-title reveal"><h3>শিক্ষা কার্যক্রম</h3><p>ইবতেদায়ী থেকে কামিল মাস্টার্স পর্যন্ত সকল স্তরের পাঠদান</p></div>
  <div class="row g-4">
    <div class="col-md-6 col-lg-3 reveal">
      <div class="program-card"><div class="band" style="background:var(--rose)"></div><div class="body"><h5>দাখিল</h5><p class="text-secondary small mb-2">৬ষ্ঠ থেকে ১০ম শ্রেণি — মাধ্যমিক স্তর</p><a href="notice.html" class="small fw-bold" style="color:var(--navy);text-decoration:none;">বিস্তারিত »</a></div></div>
    </div>
    <div class="col-md-6 col-lg-3 reveal">
      <div class="program-card"><div class="band" style="background:var(--green)"></div><div class="body"><h5>আলিম</h5><p class="text-secondary small mb-2">উচ্চ মাধ্যমিক স্তর — বিজ্ঞান ও সাধারণ শাখা</p><a href="notice.html" class="small fw-bold" style="color:var(--navy);text-decoration:none;">বিস্তারিত »</a></div></div>
    </div>
    <div class="col-md-6 col-lg-3 reveal">
      <div class="program-card"><div class="band" style="background:var(--orange)"></div><div class="body"><h5>ফাযিল</h5><p class="text-secondary small mb-2">স্নাতক (পাস ও অনার্স) স্তর</p><a href="notice.html" class="small fw-bold" style="color:var(--navy);text-decoration:none;">বিস্তারিত »</a></div></div>
    </div>
    <div class="col-md-6 col-lg-3 reveal">
      <div class="program-card"><div class="band" style="background:var(--navy)"></div><div class="body"><h5>কামিল</h5><p class="text-secondary small mb-2">স্নাতকোত্তর — হাদিস, ফিকহ, তাফসির</p><a href="notice.html" class="small fw-bold" style="color:var(--navy);text-decoration:none;">বিস্তারিত »</a></div></div>
    </div>
  </div>
</div>

<!-- NEW: testimonials -->
<div class="container my-5">
  <div class="section-title reveal"><h3>শিক্ষার্থী ও অভিভাবকদের মতামত</h3></div>
  <div id="testiCarousel" class="carousel slide reveal" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="testi-card text-center">
              <i class="bi bi-quote"></i>
              <p class="fst-italic">এই মাদরাসায় আমার সন্তানের দ্বীনি ও একাডেমিক উভয় দিকের বিকাশ দেখে আমি সন্তুষ্ট।</p>
              <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=200" class="testi-photo mb-2">
              <div class="fw-bold" style="color:var(--navy)">অভিভাবক, দাখিল বিভাগ</div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="testi-card text-center">
              <i class="bi bi-quote"></i>
              <p class="fst-italic">শিক্ষকদের আন্তরিকতা ও লাইব্রেরির সুবিধা আমাকে পড়াশোনায় অনেক সাহায্য করেছে।</p>
              <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=200" class="testi-photo mb-2">
              <div class="fw-bold" style="color:var(--navy)">শিক্ষার্থী, কামিল বিভাগ</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#testiCarousel" data-bs-slide="prev" style="width:5%"><span class="carousel-control-prev-icon" style="filter:invert(1) grayscale(1);"></span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#testiCarousel" data-bs-slide="next" style="width:5%"><span class="carousel-control-next-icon" style="filter:invert(1) grayscale(1);"></span></button>
  </div>
</div>

<!-- FOOTER -->

<?php get_footer(); ?>

</body>
</html>
