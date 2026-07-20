<?php
// Template Name: Result Page 
get_header();
?>




<div class="page-hero">
  <div class="container">
    <h1>পরীক্ষার ফলাফল</h1>
    <div class="breadcrumb-custom"><a href="index.html">হোম</a> / ফলাফল</div>
  </div>
</div>

<div class="container my-5">

  <ul class="nav nav-pills mv-tabs mb-4 reveal">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#res-pdf">ফলাফল পিডিএফ</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#res-img">ফলাফল ছবি</button></li>
  </ul>

  <div class="tab-content">

    <!-- PDF LIST -->
    <div class="tab-pane fade show active" id="res-pdf">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 reveal">
        <div class="notice-filter" id="resultFilter">
          <button class="active" data-cat="all">সকল</button>
          <button data-cat="dakhil">দাখিল</button>
          <button data-cat="alim">আলিম</button>
          <button data-cat="fazil">ফাযিল</button>
          <button data-cat="kamil">কামিল</button>
        </div>
        <input id="resultSearch" type="text" class="form-control" style="max-width:240px;" placeholder="ফলাফল খুঁজুন...">
      </div>

      <div class="reveal">
        <div class="notice-row" data-cat="dakhil" data-title="দাখিল বার্ষিক পরীক্ষার ফলাফল ২০২৬">
          <div><span class="tag">দাখিল</span> <a href="#" class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">দাখিল বার্ষিক পরীক্ষার ফলাফল ২০২৬</a></div>
          <div class="d-flex align-items-center gap-3"><span class="date">১০ জুলাই ২০২৬</span><a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-file-earmark-pdf"></i> PDF</a></div>
        </div>
        <div class="notice-row" data-cat="alim" data-title="আলিম বার্ষিক পরীক্ষার ফলাফল ২০২৬">
          <div><span class="tag">আলিম</span> <a href="#" class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">আলিম বার্ষিক পরীক্ষার ফলাফল ২০২৬</a></div>
          <div class="d-flex align-items-center gap-3"><span class="date">০৮ জুলাই ২০২৬</span><a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-file-earmark-pdf"></i> PDF</a></div>
        </div>
        <div class="notice-row" data-cat="fazil" data-title="ফাযিল (পাস/অনার্স) ফলাফল ২০২৬">
          <div><span class="tag">ফাযিল</span> <a href="#" class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">ফাযিল (পাস/অনার্স) ফলাফল ২০২৬</a></div>
          <div class="d-flex align-items-center gap-3"><span class="date">৫ জুলাই ২০২৬</span><a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-file-earmark-pdf"></i> PDF</a></div>
        </div>
        <div class="notice-row" data-cat="kamil" data-title="কামিল (হাদিস/ফিকহ/তাফসির) ফলাফল ২০২৬">
          <div><span class="tag">কামিল</span> <a href="#" class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">কামিল (হাদিস/ফিকহ/তাফসির) ফলাফল ২০২৬</a></div>
          <div class="d-flex align-items-center gap-3"><span class="date">২ জুলাই ২০২৬</span><a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-file-earmark-pdf"></i> PDF</a></div>
        </div>
        <div class="notice-row" data-cat="dakhil" data-title="দাখিল নির্বাচনী পরীক্ষার ফলাফল ২০২৫">
          <div><span class="tag">দাখিল</span> <a href="#" class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">দাখিল নির্বাচনী পরীক্ষার ফলাফল ২০২৫</a></div>
          <div class="d-flex align-items-center gap-3"><span class="date">২৮ ডিসেম্বর ২০২৫</span><a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-file-earmark-pdf"></i> PDF</a></div>
        </div>
        <div class="notice-row" data-cat="alim" data-title="আলিম ১ম বর্ষ মূল্যায়ন পরীক্ষা ফলাফল">
          <div><span class="tag">আলিম</span> <a href="#" class="fw-bold ms-2" style="color:var(--navy);text-decoration:none;">আলিম ১ম বর্ষ মূল্যায়ন পরীক্ষা ফলাফল</a></div>
          <div class="d-flex align-items-center gap-3"><span class="date">১৫ ডিসেম্বর ২০২৫</span><a href="#" class="btn btn-sm" style="background:var(--rose);color:#fff;"><i class="bi bi-file-earmark-pdf"></i> PDF</a></div>
        </div>
      </div>
    </div>

    <!-- IMAGE RESULTS -->
    <div class="tab-pane fade" id="res-img">
      <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-3 reveal">
          <div class="gallery-item" data-img="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=1000">
            <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=500" alt="দাখিল ফলাফল শীট">
            <div class="gallery-overlay"><span>দাখিল — জিপিএ শীট ২০২৬</span></div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 reveal">
          <div class="gallery-item" data-img="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=1000">
            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=500" alt="আলিম ফলাফল শীট">
            <div class="gallery-overlay"><span>আলিম — জিপিএ শীট ২০২৬</span></div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 reveal">
          <div class="gallery-item" data-img="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1000">
            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=500" alt="ফাযিল ফলাফল শীট">
            <div class="gallery-overlay"><span>ফাযিল — ফলাফল শীট ২০২৬</span></div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 reveal">
          <div class="gallery-item" data-img="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1000">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=500" alt="কামিল ফলাফল শীট">
            <div class="gallery-overlay"><span>কামিল — ফলাফল শীট ২০২৬</span></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>






<?php get_footer(); ?>