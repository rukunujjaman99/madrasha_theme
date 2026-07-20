<?php 
// Template Name: Admission Page
get_header();
?>

<div class="page-hero">
  <div class="container">
    <h1>ভর্তি তথ্য ও ফরম</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / ভর্তি</div>
  </div>
</div>

<div class="container my-5">
  <div class="row g-4">
    <div class="col-lg-8">

      <div class="reveal p-4 mb-4" style="background:var(--cream);border-radius:10px;">
        <h5 class="fw-bold" style="color:var(--navy)"><i class="bi bi-info-circle"></i> ভর্তি সংক্রান্ত সাধারণ নির্দেশনা</h5>
        <p class="text-secondary small mb-0">নিচের তালিকা থেকে আপনার প্রয়োজনীয় স্তরের ভর্তি ফরম ডাউনলোড করুন। পূরণকৃত ফরম প্রয়োজনীয় কাগজপত্রসহ নির্ধারিত সময়ের মধ্যে অফিসে জমা দিতে হবে।</p>
      </div>

      <div class="d-flex flex-wrap gap-2 mb-3 notice-filter reveal" id="admFilter">
        <button class="active" data-cat="all">সকল</button>
        <button data-cat="dakhil">দাখিল</button>
        <button data-cat="alim">আলিম</button>
        <button data-cat="fazil">ফাযিল</button>
        <button data-cat="kamil">কামিল</button>
      </div>

      <div class="reveal" id="admList">
        <div class="notice-row" data-cat="dakhil" id="dakhil">
          <div><span class="tag">দাখিল</span> <span class="fw-bold ms-2" style="color:var(--navy);">দাখিল ভর্তি নির্দেশিকা-২০২৬</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="dakhil">
          <div><span class="tag">দাখিল</span> <span class="fw-bold ms-2" style="color:var(--navy);">দাখিল ভর্তি ফরম (৬ষ্ঠ-৯ম শ্রেণি)</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="alim" id="alim">
          <div><span class="tag">আলিম</span> <span class="fw-bold ms-2" style="color:var(--navy);">আলিম ১ম বর্ষ ভর্তি ফরম</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="alim">
          <div><span class="tag">আলিম</span> <span class="fw-bold ms-2" style="color:var(--navy);">আলিম ভর্তি নির্দেশিকা ও যোগ্যতা</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="fazil" id="fazil">
          <div><span class="tag">ফাযিল</span> <span class="fw-bold ms-2" style="color:var(--navy);">ফাযিল (পাস) ভর্তি ফরম</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="fazil">
          <div><span class="tag">ফাযিল</span> <span class="fw-bold ms-2" style="color:var(--navy);">ফাযিল (অনার্স) ভর্তি ফরম</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="kamil" id="kamil">
          <div><span class="tag">কামিল</span> <span class="fw-bold ms-2" style="color:var(--navy);">কামিল (মাস্টার্স) ভর্তি ফরম</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="kamil">
          <div><span class="tag">কামিল</span> <span class="fw-bold ms-2" style="color:var(--navy);">কামিল ভর্তি নির্দেশিকা ও প্রয়োজনীয় কাগজপত্র</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
        <div class="notice-row" data-cat="dakhil">
          <div><span class="tag">সাধারণ</span> <span class="fw-bold ms-2" style="color:var(--navy);">বৃত্তির তথ্য ফরম</span></div>
          <a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-download"></i> PDF</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="side-card reveal">
        <div class="side-card-head navy">ভর্তি সময়সূচি</div>
        <div class="side-card-body">
          <div class="d-flex justify-content-between border-bottom py-2"><span>দাখিল</span><b style="color:var(--navy)">১-৩১ জুলাই</b></div>
          <div class="d-flex justify-content-between border-bottom py-2"><span>আলিম</span><b style="color:var(--navy)">১-২০ জুলাই</b></div>
          <div class="d-flex justify-content-between border-bottom py-2"><span>ফাযিল</span><b style="color:var(--navy)">১-১৫ আগস্ট</b></div>
          <div class="d-flex justify-content-between py-2"><span>কামিল</span><b style="color:var(--navy)">১-১০ আগস্ট</b></div>
        </div>
      </div>
      <div class="side-card reveal">
        <div class="side-card-head">যোগাযোগ</div>
        <div class="side-card-body small">
          <p class="mb-1"><i class="bi bi-telephone"></i> ০১৭১২-৪৫৭৬২০ (ভর্তি শাখা)</p>
          <p class="mb-0"><i class="bi bi-envelope"></i> kawniagirls.fazil@gmail.com</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>