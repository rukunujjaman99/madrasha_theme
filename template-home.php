

<?php 
// Template Name: Home Page

get_header(); ?>
<!-- header end -->

<!-- TICKER -->
<div class="ticker-wrap d-flex align-items-center">
  <span class="ticker-label">নোটিশঃ</span>
  <span class="ticker-track">
    <span>২০২৬ সালের খামেস থেকে আসের পর্যন্ত সেশন ফি পরিশোধের বিজ্ঞপ্তি</span>
    <span>২০২৬ সালের আউয়াল থেকে রাবে পর্যন্ত সেশন ফি পরিশোধের বিজ্ঞপ্তি</span>
    <span>২০২৬ সালের ভর্তি বিজ্ঞপ্তি</span>
    <span>মুহইউসসুন্নাহ বৃত্তি পরীক্ষা</span>
  </span>
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
        <h2>কাউনিয়া বালিকা ফাজিল (ডিগ্রি) মডেল মাদ্রাসায় আপনাকে স্বাগতম</h2>
        <hr style="border-color:var(--orange);width:70px;border-width:2px;opacity:1;">
        <p>ঢাকার অদূরে দেমরায় অবস্থিত এই প্রতিষ্ঠান দীর্ঘ আশি বছরের বেশি সময় ধরে এলাকার শিক্ষা-দীক্ষার কেন্দ্রবিন্দু হিসেবে কাজ করে যাচ্ছে। কুরআন-হাদিসের জ্ঞানের পাশাপাশি আধুনিক শিক্ষার সমন্বয়ে হাজারো শিক্ষার্থীকে যোগ্য নাগরিক হিসেবে গড়ে তোলা এই প্রতিষ্ঠানের মূল লক্ষ্য।</p>
        <p class="more-text" style="display:none;">এক সময়ের জনমানবহীন প্রান্তর থেকে ধাপে ধাপে আজকের সুবিশাল ক্যাম্পাসে রূপান্তরিত হওয়ার পেছনে রয়েছে স্থানীয় আলেম ও দানশীল ব্যক্তিবর্গের অক্লান্ত পরিশ্রম। ১৯৯০ সনে ইবতেদায়ী স্তরে যাত্রা শুরু করে ধারাবাহিকভাবে দাখিল, আলিম, ফাযিল এবং সবশেষে কামিল স্তর পর্যন্ত মাদরাসাকে উন্নীত করা হয়েছে।</p>
        <span class="read-more-toggle" onclick="toggleMore(this)">আরও পড়ুন <i class="bi bi-chevron-down"></i></span>
      </div>

      <!-- NEW: features -->
      <div class="mt-5 reveal">
        <div class="section-title text-start">
          <h3 style="font-size:1.3rem;">কেন কাউনিয়া বালিকা ফাজিল</h3>
        </div>
        <div class="row g-3">
          <div class="col-6 col-md-3">
            <div class="feature-card"><div class="feature-icon"><i class="bi bi-book-half"></i></div><h6 class="fw-bold" style="color:var(--navy)">কুরআন-হাদিস শিক্ষা</h6><small class="text-secondary">নূরানী থেকে কামিল পর্যন্ত মানসম্মত দ্বীনি শিক্ষা</small></div>
          </div>
          <div class="col-6 col-md-3">
            <div class="feature-card"><div class="feature-icon"><i class="bi bi-house-heart"></i></div><h6 class="fw-bold" style="color:var(--navy)">আবাসিক ব্যবস্থা</h6><small class="text-secondary">নিরাপদ ও শৃঙ্খলাপূর্ণ হোস্টেল সুবিধা</small></div>
          </div>
          <div class="col-6 col-md-3">
            <div class="feature-card"><div class="feature-icon"><i class="bi bi-award"></i></div><h6 class="fw-bold" style="color:var(--navy)">বৃত্তি কার্যক্রম</h6><small class="text-secondary">মেধাবী ও দুস্থ শিক্ষার্থীদের জন্য বৃত্তি</small></div>
          </div>
          <div class="col-6 col-md-3">
            <div class="feature-card"><div class="feature-icon"><i class="bi bi-trophy"></i></div><h6 class="fw-bold" style="color:var(--navy)">খেলাধুলা ও সহশিক্ষা</h6><small class="text-secondary">নিয়মিত ক্রীড়া ও সাংস্কৃতিক কার্যক্রম</small></div>
          </div>
        </div>
      </div>

      <!-- Best of the year -->
      <div class="my-5 reveal" id="best">
        <div class="section-title"><h3>এ বছরের সেরা শিক্ষার্থী</h3><p>বিভাগ অনুযায়ী ফিল্টার করুন, বিস্তারিত দেখতে ছবিতে ক্লিক করুন</p></div>
        <div class="text-center gallery-filter mb-4" id="studentFilter">
          <button class="active" data-dept="all">সকল</button>
          <button data-dept="dakhil">দাখিল</button>
          <button data-dept="alim">আলিম</button>
          <button data-dept="fazil">ফাযিল</button>
          <button data-dept="kamil">কামিল</button>
        </div>
        <div class="row g-3" id="studentGrid">
          <div class="col-6 col-md-3 student-col">
            <div class="student-card" data-dept="dakhil" data-bs-toggle="modal" data-bs-target="#stuModal"
                 data-info='{"name":"তাসনিম জাহান","dept":"দাখিল বিভাগ","res":"জিপিএ ৫.০০","roll":"রোল: ০১","img":"https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=400"}'>
              <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=400" alt="">
              <div class="student-badge">জিপিএ ৫.০০</div>
              <div class="cap">দাখিল — তাসনিম জাহান</div>
            </div>
          </div>
          <div class="col-6 col-md-3 student-col">
            <div class="student-card" data-dept="alim" data-bs-toggle="modal" data-bs-target="#stuModal"
                 data-info='{"name":"রুকাইয়া সুলতানা","dept":"আলিম বিভাগ","res":"জিপিএ ৫.০০","roll":"রোল: ০৩","img":"https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=400"}'>
              <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=400" alt="">
              <div class="student-badge">জিপিএ ৫.০০</div>
              <div class="cap">আলিম — রুকাইয়া সুলতানা</div>
            </div>
          </div>
          <div class="col-6 col-md-3 student-col">
            <div class="student-card" data-dept="fazil" data-bs-toggle="modal" data-bs-target="#stuModal"
                 data-info='{"name":"সুমাইয়া আক্তার","dept":"ফাযিল বিভাগ","res":"১ম শ্রেণি, ১ম স্থান","roll":"রোল: ০৫","img":"https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400"}'>
              <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400" alt="">
              <div class="student-badge">১ম স্থান</div>
              <div class="cap">ফাযিল — সুমাইয়া আক্তার</div>
            </div>
          </div>
          <div class="col-6 col-md-3 student-col">
            <div class="student-card" data-dept="kamil" data-bs-toggle="modal" data-bs-target="#stuModal"
                 data-info='{"name":"নুসরাত জাহান মিম","dept":"কামিল বিভাগ","res":"১ম শ্রেণি, ১ম স্থান","roll":"রোল: ০২","img":"https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400"}'>
              <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400" alt="">
              <div class="student-badge">১ম স্থান</div>
              <div class="cap">কামিল — নুসরাত জাহান মিম</div>
            </div>
          </div>
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

      <div class="reveal">
        <h4 class="font-display mb-3" style="color:var(--navy)">প্রতিষ্ঠার সংক্ষিপ্ত ইতিহাস</h4>
        <div class="accordion" id="histAcc">
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#a1">১৯৪৬ — সূচনা</button></h2>
            <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#histAcc"><div class="accordion-body">স্থানীয় মাহফিলকে কেন্দ্র করে অঞ্চলে দ্বীনি শিক্ষা প্রতিষ্ঠার আকাঙ্ক্ষা জন্ম নেয়।</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#a2">১৯৯০ — একাডেমিক যাত্রা শুরু</button></h2>
            <div id="a2" class="accordion-collapse collapse" data-bs-parent="#histAcc"><div class="accordion-body">ইবতেদায়ী স্তরে শিক্ষার্থী নিয়ে মাদরাসার আনুষ্ঠানিক কার্যক্রম শুরু হয়।</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#a3">২০০৪–২০১৮ — কামিল স্তরে উন্নীতকরণ</button></h2>
            <div id="a3" class="accordion-collapse collapse" data-bs-parent="#histAcc"><div class="accordion-body">ধাপে ধাপে দাখিল থেকে কামিল পর্যন্ত এবং একাধিক অনার্স-মাস্টার্স বিভাগ চালু করা হয়।</div></div>
          </div>
        </div>
        <a href="about.html" class="btn btn-sm mt-3" style="background:var(--navy);color:#fff;">বিস্তারিত জানুন »</a>
      </div>

    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="col-lg-4">

      <div class="side-card text-center reveal">
        <div class="side-card-body">
          <img class="principal-photo mb-2" src="assets/img/principal.png" alt="অধ্যক্ষ">
          <div style="color:var(--rose);font-weight:700;">প্রতিষ্ঠাতা অধ্যক্ষ</div>
          <div class="font-display fw-bold" style="color:var(--navy)">মাওলানা মোহাম্মদ আমির হোসেন তালুকদার</div>
          <small class="text-secondary d-block mb-2">কামিল (হাদিস, তাফসীর) ১ম শ্রেণি; দাওরায়ে হাদিস-১ম শ্রেণি; এম.এ, বি.এড-১ম শ্রেণি</small>
          <a href="about.html#principal-speech" class="btn btn-sm w-100" style="background:var(--green);color:#fff;">অধ্যক্ষের বাণী পড়ুন »</a>
        </div>
      </div>

      <div class="side-card reveal" id="notice">
        <div class="side-card-head">নোটিশ বোর্ড</div>
        <div class="side-card-body">
          <div class="notice-grid" id="noticeGrid">
            <button class="active" data-t="dakhil">দাখিল</button>
            <button data-t="alim">আলিম</button>
            <button data-t="fazil">ফাযিল</button>
            <button data-t="kamil">কামিল</button>
          </div>
          <div class="notice-result-list" id="noticeList"></div>
          <a href="notice.html" class="btn btn-sm w-100 mt-2" style="background:var(--green);color:#fff;">সমস্ত নোটিশ দেখুন »</a>
        </div>
      </div>

      <div class="side-card reveal" id="downloads">
        <div class="side-card-head navy">ফরম ডাউনলোড</div>
        <div class="side-card-body">
          <div class="dl-list">
            <a href="admission.html"><i class="bi bi-file-earmark-pdf"></i> ভর্তি নির্দেশিকা-২০২৬</a>
            <a href="admission.html#dakhil"><i class="bi bi-file-earmark-pdf"></i> ভর্তি ফরম দাখিল</a>
            <a href="admission.html#alim"><i class="bi bi-file-earmark-pdf"></i> ভর্তি ফরম আলিম</a>
            <a href="admission.html#fazil"><i class="bi bi-file-earmark-pdf"></i> ভর্তি ফরম ফাযিল (পাস)</a>
            <a href="admission.html#kamil"><i class="bi bi-file-earmark-pdf"></i> ভর্তি ফরম কামিল</a>
            <a href="result.html"><i class="bi bi-file-earmark-pdf"></i> সাম্প্রতিক ফলাফল</a>
          </div>
          <a href="admission.html" class="btn btn-sm w-100 mt-2" style="background:var(--orange);color:#1c1c1c;">সকল ভর্তি ফরম »</a>
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
      <div class="side-card reveal">
        <div class="side-card-head navy">সাম্প্রতিক ছবি</div>
        <div class="side-card-body">
          <div class="row g-2">
            <div class="col-4"><img src="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=200" class="w-100 rounded" style="height:60px;object-fit:cover;"></div>
            <div class="col-4"><img src="https://images.unsplash.com/photo-1519452575417-564c1401ecc0?q=80&w=200" class="w-100 rounded" style="height:60px;object-fit:cover;"></div>
            <div class="col-4"><img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=200" class="w-100 rounded" style="height:60px;object-fit:cover;"></div>
          </div>
          <a href="gallery.html" class="btn btn-sm w-100 mt-2" style="background:var(--orange);color:#1c1c1c;">সম্পূর্ণ গ্যালারি »</a>
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
