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

<div class="container my-5">
  <div class="text-center gallery-filter reveal mb-4" id="galleryFilter">
    <button class="active" data-cat="all">সকল</button>
    <button data-cat="campus">ক্যাম্পাস</button>
    <button data-cat="event">অনুষ্ঠান</button>
    <button data-cat="sports">খেলাধুলা</button>
    <button data-cat="class">শ্রেণিকক্ষ</button>
  </div>

  <div class="row g-3" id="galleryGrid">
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="campus" data-img="https://images.unsplash.com/photo-1564769662533-4f00a87b4056?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1564769662533-4f00a87b4056?q=80&w=500" alt="প্রধান ফটক">
        <div class="gallery-overlay"><span>প্রধান ফটক</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="class" data-img="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=500" alt="শ্রেণিকক্ষ">
        <div class="gallery-overlay"><span>শ্রেণিকক্ষ</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="campus" data-img="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=500" alt="লাইব্রেরি">
        <div class="gallery-overlay"><span>লাইব্রেরি</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="campus" data-img="https://images.unsplash.com/photo-1519452575417-564c1401ecc0?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1519452575417-564c1401ecc0?q=80&w=500" alt="কেন্দ্রীয় মসজিদ">
        <div class="gallery-overlay"><span>কেন্দ্রীয় মসজিদ</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="event" data-img="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=500" alt="বার্ষিক সম্মেলন">
        <div class="gallery-overlay"><span>বার্ষিক সম্মেলন</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="sports" data-img="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?q=80&w=500" alt="ক্রীড়া অনুষ্ঠান">
        <div class="gallery-overlay"><span>ক্রীড়া অনুষ্ঠান</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="event" data-img="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=500" alt="পুরস্কার বিতরণী">
        <div class="gallery-overlay"><span>পুরস্কার বিতরণী</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="class" data-img="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=500" alt="পাঠদান">
        <div class="gallery-overlay"><span>পাঠদান</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="sports" data-img="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=500" alt="বার্ষিক ক্রীড়া">
        <div class="gallery-overlay"><span>বার্ষিক ক্রীড়া</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="campus" data-img="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=500" alt="প্রশাসনিক ভবন">
        <div class="gallery-overlay"><span>প্রশাসনিক ভবন</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="event" data-img="https://images.unsplash.com/photo-1607013251379-e6eecfffe234?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1607013251379-e6eecfffe234?q=80&w=500" alt="দোয়া মাহফিল">
        <div class="gallery-overlay"><span>দোয়া মাহফিল</span></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-3 reveal">
      <div class="gallery-item" data-cat="class" data-img="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?q=80&w=1000">
        <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?q=80&w=500" alt="গ্রন্থাগার পাঠ">
        <div class="gallery-overlay"><span>গ্রন্থাগার পাঠ</span></div>
      </div>
    </div>
  </div>

  <div class="text-center mt-4 reveal">
    <button class="btn" style="background:var(--navy);color:#fff;"><i class="bi bi-arrow-down-circle"></i> আরও ছবি দেখুন</button>
  </div>
</div>


<?php get_footer(); ?>