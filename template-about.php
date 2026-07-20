<?php 
// Template Name: About Page
get_header();

?>




<div class="page-hero">
  <div class="container">
    <h1>আমাদের পরিচিতি</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / পরিচিতি</div>
  </div>
</div>




<div class="container my-5">
  <div class="row g-5">
    <div class="col-lg-8">

     <?php
/**
 * Frontend Output — About Page: Founding History
 * Drop this where the static block used to be.
 */

$rs_history_body = get_theme_mod( 'rs_history_body', '' );
$paragraphs = preg_split( '/\r\n\r\n|\n\n|\r\r/', trim( $rs_history_body ) );
?>

<div class="reveal mb-5">
    <div class="section-title text-start">
        <h3 style="font-size:1.4rem;"><?php echo esc_html( get_theme_mod( 'rs_history_title', 'প্রতিষ্ঠার ইতিহাস' ) ); ?></h3>
    </div>

    <?php foreach ( $paragraphs as $para ) :
        $para = trim( $para );
        if ( '' === $para ) {
            continue;
        }
    ?>
        <p style="line-height:1.9;color:#4c5a63;text-align:justify;">
            <?php echo esc_html( $para ); ?>
        </p>
    <?php endforeach; ?>

</div>

   <?php
/**
 * Frontend Output — "অধ্যক্ষের কথা" (Principal's Speech) Section
 * Drop this where the static block used to be (e.g. on the About page).
 * Reuses rs_principal_photo / rs_principal_name / rs_principal_badge
 * from the same "Principal Card" Customizer section used elsewhere.
 */

$rs_photo_id = get_theme_mod( 'rs_principal_photo' );
$rs_speech   = get_theme_mod( 'rs_principal_speech', '' );
?>

<div id="principal-speech" class="reveal mb-5">
    <div class="section-title text-start">
        <h3 style="font-size:1.4rem;"><?php esc_html_e( 'অধ্যক্ষের কথা', 'rs-madrasha' ); ?></h3>
    </div>

    <div class="row g-4 align-items-start">

        <div class="col-md-4">

            <?php if ( $rs_photo_id ) :
                echo wp_get_attachment_image( $rs_photo_id, 'medium', false, array(
                    'class' => 'w-100 rounded',
                    'style' => 'border:3px solid var(--green);',
                    'alt'   => esc_attr( get_theme_mod( 'rs_principal_name', 'অধ্যক্ষ' ) ),
                ) );
            else : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/principal.png' ); ?>"
                     alt="<?php esc_attr_e( 'অধ্যক্ষ', 'rs-madrasha' ); ?>"
                     class="w-100 rounded" style="border:3px solid var(--green);">
            <?php endif; ?>

            <div class="text-center mt-2">
                <div class="fw-bold" style="color:var(--navy)">
                    <?php echo esc_html( get_theme_mod( 'rs_principal_name', 'মাওলানা মোহাম্মদ আমির হোসেন তালুকদার' ) ); ?>
                </div>
                <small class="text-secondary">
                    <?php echo esc_html( get_theme_mod( 'rs_principal_badge', 'প্রতিষ্ঠাতা অধ্যক্ষ' ) ); ?><br>
                    <?php echo esc_html( get_theme_mod( 'rs_principal_institution', 'কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদরাসা' ) ); ?><br>
                    <?php echo esc_html( get_theme_mod( 'rs_principal_address', 'বরিশাল-৮২০০' ) ); ?>
                </small>
            </div>

        </div>

        <div class="col-md-8">

            <?php
            // Split on blank lines -> one <p> per paragraph, matching the Customizer control's instructions.
            $paragraphs = preg_split( '/\r\n\r\n|\n\n|\r\r/', trim( $rs_speech ) );

            foreach ( $paragraphs as $para ) :
                $para = trim( $para );
                if ( '' === $para ) {
                    continue;
                }
            ?>
                <p class="text-secondary" style="line-height:1.95;text-align:justify;">
                    <?php echo esc_html( $para ); ?>
                </p>
            <?php endforeach; ?>

            <?php $rs_quote = get_theme_mod( 'rs_principal_quote', '' ); ?>
            <?php if ( $rs_quote ) : ?>
                <p class="fst-italic" style="color:var(--navy);border-left:3px solid var(--orange);padding-left:1rem;">
                    "<?php echo esc_html( $rs_quote ); ?>"
                </p>
            <?php endif; ?>

        </div>

    </div>
</div>





      <?php
/**
 * Frontend Output — Mission / Vision / Values Tabs
 * Drop this where the static "লক্ষ্য ও উদ্দেশ্য" block used to be.
 */
?>

<div id="mv" class="reveal mb-5">
    <div class="section-title text-start">
        <h3 style="font-size:1.4rem;"><?php echo esc_html( get_theme_mod( 'rs_mv_title', 'লক্ষ্য ও উদ্দেশ্য' ) ); ?></h3>
    </div>

    <ul class="nav nav-pills mv-tabs mb-3">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#mv-mission">
                <?php echo esc_html( get_theme_mod( 'rs_mv_mission_label', 'লক্ষ্য' ) ); ?>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#mv-vision">
                <?php echo esc_html( get_theme_mod( 'rs_mv_vision_label', 'উদ্দেশ্য' ) ); ?>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#mv-value">
                <?php echo esc_html( get_theme_mod( 'rs_mv_value_label', 'মূল্যবোধ' ) ); ?>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="mv-mission">
            <p class="text-secondary" style="line-height:1.9;">
                <?php echo esc_html( get_theme_mod( 'rs_mv_mission_content', '' ) ); ?>
            </p>
        </div>
        <div class="tab-pane fade" id="mv-vision">
            <p class="text-secondary" style="line-height:1.9;">
                <?php echo esc_html( get_theme_mod( 'rs_mv_vision_content', '' ) ); ?>
            </p>
        </div>
        <div class="tab-pane fade" id="mv-value">
            <p class="text-secondary" style="line-height:1.9;">
                <?php echo esc_html( get_theme_mod( 'rs_mv_value_content', '' ) ); ?>
            </p>
        </div>
    </div>
</div>

      <?php
/**
 * Frontend Output — Committee Table
 * Drop this where the static committee table used to be.
 */

$committee_query = new WP_Query( array(
    'post_type'      => 'committee',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

<div id="committee" class="reveal">
    <div class="section-title text-start">
        <h3 style="font-size:1.4rem;"><?php esc_html_e( 'পরিচালনা কমিটি', 'rs-madrasha' ); ?></h3>
    </div>

    <div class="table-responsive">
        <table class="table committee-table align-middle">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'নাম', 'rs-madrasha' ); ?></th>
                    <th><?php esc_html_e( 'পদবি', 'rs-madrasha' ); ?></th>
                    <th><?php esc_html_e( 'দায়িত্ব', 'rs-madrasha' ); ?></th>
                </tr>
            </thead>
            <tbody>

                <?php if ( $committee_query->have_posts() ) : ?>

                    <?php while ( $committee_query->have_posts() ) : $committee_query->the_post();
                        $designation    = get_post_meta( get_the_ID(), '_committee_designation', true );
                        $responsibility = get_post_meta( get_the_ID(), '_committee_responsibility', true );
                    ?>
                        <tr>
                            <td><?php the_title(); ?></td>
                            <td><?php echo esc_html( $designation ); ?></td>
                            <td><?php echo esc_html( $responsibility ); ?></td>
                        </tr>
                    <?php endwhile; wp_reset_postdata(); ?>

                <?php else : ?>

                    <tr><td colspan="3" class="text-center text-secondary"><?php esc_html_e( 'কোনো তথ্য পাওয়া যায়নি।', 'rs-madrasha' ); ?></td></tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

    </div>

    <div class="col-lg-4">
    

     <?php
/**
 * Frontend Output — Founder Card
 * Drop this where the static founder block used to be.
 */

$rs_founder_photo_id = get_theme_mod( 'rs_founder_photo' );
$rs_qualification     = get_theme_mod( 'rs_founder_qualification', '' );
?>

<div class="side-card reveal">

    <?php if ( $rs_founder_photo_id ) :
        echo wp_get_attachment_image( $rs_founder_photo_id, 'medium', false, array(
            'class' => 'principal-photo mb-2',
            'alt'   => esc_attr( get_theme_mod( 'rs_founder_name', 'প্রতিষ্ঠাতা' ) ),
        ) );
    else : ?>
        <img class="principal-photo mb-2"
             src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/principal.png' ); ?>"
             alt="<?php esc_attr_e( 'প্রতিষ্ঠাতা', 'rs-madrasha' ); ?>">
    <?php endif; ?>

    <div class="side-card-head navy"><?php echo esc_html( get_theme_mod( 'rs_founder_badge', 'প্রতিষ্ঠাতা' ) ); ?></div>

    <div class="side-card-body text-center">
        <div class="fw-bold" style="color:var(--navy)">
            <?php echo esc_html( get_theme_mod( 'rs_founder_name', 'আলহাজ্ব এ্যাড. মোঃ মজিবর রহমান সরোয়ার' ) ); ?>
        </div>
        <small class="text-secondary">
            <?php echo esc_html( get_theme_mod( 'rs_founder_badge', 'প্রতিষ্ঠাতা' ) ); ?>

            <?php if ( $rs_qualification ) : ?>
                <br><?php echo esc_html( $rs_qualification ); ?>
            <?php endif; ?>

            <br><?php echo esc_html( get_theme_mod( 'rs_founder_institution', 'কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদরাসা' ) ); ?>
            <br><?php echo esc_html( get_theme_mod( 'rs_founder_address', 'বরিশাল সদর, বরিশাল' ) ); ?>
        </small>
    </div>

</div>

   <?php
/**
 * Frontend Output — Infrastructure Widget
 * Drop this where the static block used to be.
 */

$rows_defaults = array(
    1 => array( 'label' => 'শ্রেণিকক্ষ',    'value' => '৪৮টি' ),
    2 => array( 'label' => 'হোস্টেল ভবন',   'value' => '৩টি' ),
    3 => array( 'label' => 'লাইব্রেরি বই',   'value' => '১৫,০০০+' ),
    4 => array( 'label' => 'খেলার মাঠ',     'value' => '২টি' ),
);

$row_count = count( $rows_defaults );
?>

<div class="side-card reveal">
    <div class="side-card-head navy">
        <?php echo esc_html( get_theme_mod( 'rs_infra_heading', 'অবকাঠামো' ) ); ?>
    </div>
    <div class="side-card-body">

        <?php $i = 0; foreach ( $rows_defaults as $index => $default ) :
            $i++;
            $label = get_theme_mod( "rs_infra_row{$index}_label", $default['label'] );
            $value = get_theme_mod( "rs_infra_row{$index}_value", $default['value'] );

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

    </div>

  </div>
</div>

<?php get_footer(); ?>