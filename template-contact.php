<?php 
// Template Name: Contact Page
get_header(); 
?>

<div class="page-hero">
  <div class="container">
    <h1>যোগাযোগ করুন</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / যোগাযোগ</div>
  </div>
</div>



<div class="container my-5">
 <?php
/**
 * Frontend Output — Contact Info Cards (Address / Phone / Email)
 * Drop this where the static 3-card block used to be.
 */

$rs_phone1 = get_theme_mod( 'rs_contact_phone1', '০১৩০৯-১০৭৯০৬ (অধ্যক্ষ)' );
$rs_phone2 = get_theme_mod( 'rs_contact_phone2', '০১৮১৬-১০৪০০ (উপাধ্যক্ষ)' );
$rs_email1 = get_theme_mod( 'rs_contact_email1', 'kawniagirls.fazil@gmail.com' );
$rs_email2 = get_theme_mod( 'rs_contact_email2', 'kgfmm.edu.bd' );
?>

<div class="row g-4 mb-5">

  <div class="col-md-4 reveal">
    <div class="contact-info-card">
      <div class="ic"><i class="bi bi-geo-alt-fill"></i></div>
      <h6 class="fw-bold" style="color:var(--navy)"><?php esc_html_e( 'ঠিকানা', 'rs-madrasha' ); ?></h6>
      <p class="text-secondary small mb-0">
        <?php echo esc_html( get_theme_mod( 'rs_contact_address', 'কাউনিয়া, বরিশাল সদর, বরিশাল' ) ); ?>
      </p>
    </div>
  </div>

  <div class="col-md-4 reveal">
    <div class="contact-info-card">
      <div class="ic"><i class="bi bi-telephone-fill"></i></div>
      <h6 class="fw-bold" style="color:var(--navy)"><?php esc_html_e( 'ফোন', 'rs-madrasha' ); ?></h6>
      <p class="text-secondary small mb-0">
        <?php if ( $rs_phone1 ) : ?><?php echo esc_html( $rs_phone1 ); ?><?php endif; ?>
        <?php if ( $rs_phone1 && $rs_phone2 ) : ?><br><?php endif; ?>
        <?php if ( $rs_phone2 ) : ?><?php echo esc_html( $rs_phone2 ); ?><?php endif; ?>
      </p>
    </div>
  </div>

  <div class="col-md-4 reveal">
    <div class="contact-info-card">
      <div class="ic"><i class="bi bi-envelope-fill"></i></div>
      <h6 class="fw-bold" style="color:var(--navy)"><?php esc_html_e( 'ইমেইল', 'rs-madrasha' ); ?></h6>
      <p class="text-secondary small mb-0">
        <?php if ( $rs_email1 ) : ?><?php echo esc_html( $rs_email1 ); ?><?php endif; ?>
        <?php if ( $rs_email1 && $rs_email2 ) : ?><br><?php endif; ?>
        <?php if ( $rs_email2 ) : ?><?php echo esc_html( $rs_email2 ); ?><?php endif; ?>
      </p>
    </div>
  </div>

</div>

  <div class="row g-5">
    <div class="col-lg-7 reveal">
      <div class="section-title text-start"><h3 style="font-size:1.4rem;">মেসেজ পাঠান</h3></div>

      <div id="contactSuccess" class="alert alert-success d-none">
  <i class="bi bi-check-circle-fill"></i> <span id="contactSuccessText">আপনার বার্তা সফলভাবে পাঠানো হয়েছে। ধন্যবাদ!</span>
</div>
<div id="contactError" class="alert alert-danger d-none">
  <i class="bi bi-exclamation-triangle-fill"></i> <span id="contactErrorText"></span>
</div>

<form id="contactForm" class="row g-3 needs-validation" novalidate method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

  <div class="col-md-6">
    <label class="form-label small fw-bold">নাম *</label>
    <input type="text" name="name" class="form-control" required>
    <div class="invalid-feedback">নাম আবশ্যক</div>
  </div>

  <div class="col-md-6">
    <label class="form-label small fw-bold">মোবাইল নম্বর *</label>
    <input type="tel" name="phone" class="form-control" pattern="[0-9]{11}" required>
    <div class="invalid-feedback">সঠিক ১১ ডিজিটের নম্বর দিন</div>
  </div>

  <div class="col-md-6">
    <label class="form-label small fw-bold">ইমেইল *</label>
    <input type="email" name="email" class="form-control" required>
    <div class="invalid-feedback">সঠিক ইমেইল দিন</div>
  </div>

  <div class="col-md-6">
    <label class="form-label small fw-bold">বিষয়</label>
    <select name="subject" class="form-select">
      <option>ভর্তি সংক্রান্ত</option>
      <option>হোস্টেল সংক্রান্ত</option>
      <option>সাধারণ জিজ্ঞাসা</option>
      <option>অভিযোগ</option>
    </select>
  </div>

  <div class="col-12">
    <label class="form-label small fw-bold">বার্তা *</label>
    <textarea name="message" class="form-control" rows="4" required></textarea>
    <div class="invalid-feedback">বার্তা লিখুন</div>
  </div>

  <div class="col-12">
    <button type="submit" id="contactSubmitBtn" class="btn" style="background:var(--rose);color:#fff;">
      <i class="bi bi-send"></i> <span id="contactBtnText">বার্তা পাঠান</span>
    </button>
  </div>

</form>

    </div>

    <?php
/**
 * Frontend Output — Map + Department-wise Contact Table
 * Drop this where the static col-lg-5 block used to be.
 */

$dept_rows_defaults = array(
    1 => array( 'label' => 'দাখিল বিভাগ',    'phone' => '০১৭১২-৪৫৭৬২০' ),
    2 => array( 'label' => 'আলিম বিভাগ',     'phone' => '০১৯১৪-৫৮৭৯১৩' ),
    3 => array( 'label' => 'ফাযিল বিভাগ',    'phone' => '০১৯১৬-৬০৪২২৫' ),
    4 => array( 'label' => 'কামিল বিভাগ',    'phone' => '০১১২৫-৭৪৫৭৩৬' ),
    5 => array( 'label' => 'হোস্টেল সুপার',  'phone' => '০১৭১২-৪৮১৮৭' ),
);
?>

<div class="col-lg-5 reveal">

  <div class="section-title text-start">
    <h3 style="font-size:1.4rem;"><?php echo esc_html( get_theme_mod( 'rs_contact_map_title', 'অবস্থান' ) ); ?></h3>
  </div>

  <div class="map-frame mb-3">
    <iframe src="<?php echo esc_url( get_theme_mod( 'rs_contact_map_url', 'https://www.google.com/maps?q=Demra,Dhaka&output=embed' ) ); ?>"
            width="100%" height="260" style="border:0;" loading="lazy"></iframe>
  </div>

  <div class="side-card">
    <div class="side-card-head navy">
      <?php echo esc_html( get_theme_mod( 'rs_contact_dept_heading', 'বিভাগভিত্তিক যোগাযোগ' ) ); ?>
    </div>
    <div class="side-card-body">
      <table class="table table-sm mb-0">
        <tbody>
          <?php foreach ( $dept_rows_defaults as $i => $default ) :
              $label = get_theme_mod( "rs_contact_dept{$i}_label", $default['label'] );
              $phone = get_theme_mod( "rs_contact_dept{$i}_phone", $default['phone'] );

              if ( '' === $label && '' === $phone ) {
                  continue;
              }
          ?>
            <tr>
              <td><?php echo esc_html( $label ); ?></td>
              <td class="text-end"><?php echo esc_html( $phone ); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

  </div>
</div>

<?php get_footer(); ?>