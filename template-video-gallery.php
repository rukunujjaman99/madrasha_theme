<?php
// Template Name: Video Gallery Page
get_header();
?>

<div class="page-hero">
  <div class="container">
    <h1>ভিডিও গ্যালারি</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / ভিডিও গ্যালারি</div>
  </div>
</div>

<div class="container my-5">
  <div class="text-center gallery-filter reveal mb-4" id="videoFilter">
    <button class="active" data-cat="all">সকল</button>
    <button data-cat="event">অনুষ্ঠান</button>
    <button data-cat="campus">ক্যাম্পাস ভ্রমণ</button>
    <button data-cat="cultural">সাংস্কৃতিক</button>
  </div>

  <div class="row g-4" id="videoGrid">

    <div class="col-md-6 col-lg-4 video-col reveal">
      <div class="video-card" data-cat="event" data-yt="dQw4w9WgXcQ">
        <div class="video-thumb-wrap">
          <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="বার্ষিক সম্মেলন">
          <div class="play-btn"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-info"><h6>বার্ষিক সম্মেলন ২০২৬</h6><small class="text-secondary">৪:৩২ মিনিট</small></div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4 video-col reveal">
      <div class="video-card" data-cat="campus" data-yt="dQw4w9WgXcQ">
        <div class="video-thumb-wrap">
          <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="ক্যাম্পাস ভ্রমণ">
          <div class="play-btn"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-info"><h6>ক্যাম্পাস ভার্চুয়াল ভ্রমণ</h6><small class="text-secondary">৬:১০ মিনিট</small></div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4 video-col reveal">
      <div class="video-card" data-cat="cultural" data-yt="dQw4w9WgXcQ">
        <div class="video-thumb-wrap">
          <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="সাংস্কৃতিক অনুষ্ঠান">
          <div class="play-btn"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-info"><h6>বার্ষিক সাংস্কৃতিক সন্ধ্যা</h6><small class="text-secondary">৮:৪৫ মিনিট</small></div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4 video-col reveal">
      <div class="video-card" data-cat="event" data-yt="dQw4w9WgXcQ">
        <div class="video-thumb-wrap">
          <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="পুরস্কার বিতরণী">
          <div class="play-btn"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-info"><h6>পুরস্কার বিতরণী অনুষ্ঠান</h6><small class="text-secondary">৩:৫৫ মিনিট</small></div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4 video-col reveal">
      <div class="video-card" data-cat="campus" data-yt="dQw4w9WgXcQ">
        <div class="video-thumb-wrap">
          <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="লাইব্রেরি পরিচিতি">
          <div class="play-btn"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-info"><h6>লাইব্রেরি ও ক্লাসরুম পরিচিতি</h6><small class="text-secondary">৫:২০ মিনিট</small></div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4 video-col reveal">
      <div class="video-card" data-cat="cultural" data-yt="dQw4w9WgXcQ">
        <div class="video-thumb-wrap">
          <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="ক্রীড়া প্রতিযোগিতা">
          <div class="play-btn"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-info"><h6>বার্ষিক ক্রীড়া প্রতিযোগিতা</h6><small class="text-secondary">৭:১৫ মিনিট</small></div>
      </div>
    </div>

  </div>
</div>

<!-- Video modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
          <iframe id="videoFrame" src="" title="Video" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>