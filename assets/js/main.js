// ===== Live clock =====
function tickClock(){
  const el = document.getElementById('liveClock');
  if(!el) return;
  const d = new Date();
  el.textContent = d.toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit',second:'2-digit'})+', '+d.toLocaleDateString('en-GB');
}
tickClock(); setInterval(tickClock,1000);

// ===== Back to top =====
const backTop = document.getElementById('backTop');
if(backTop){
  window.addEventListener('scroll',()=>backTop.classList.toggle('show', window.scrollY>500));
  backTop.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));
}

// ===== Scroll reveal =====
const revealEls = document.querySelectorAll('.reveal');
if(revealEls.length){
  const io = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} });
  },{threshold:.12});
  revealEls.forEach(el=>io.observe(el));
}

// ===== Counters =====
const counters = document.querySelectorAll('.stat-num[data-count]');
if(counters.length){
  const cio = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){
        const el = entry.target;
        const target = +el.dataset.count;
        let cur = 0;
        const step = Math.max(1, Math.ceil(target/60));
        const timer = setInterval(()=>{
          cur += step;
          if(cur>=target){cur=target; clearInterval(timer);}
          el.textContent = cur.toLocaleString('bn-BD');
        },25);
        cio.unobserve(el);
      }
    });
  },{threshold:.5});
  counters.forEach(c=>cio.observe(c));
}

// ===== Hero / main slider (true sliding carousel) =====
const sliderTrack = document.getElementById('sliderTrack');
if(sliderTrack){
  const slideEls = sliderTrack.querySelectorAll('.slider-slide');
  const total = slideEls.length;
  let curSlide = 0;
  let autoTimer = null;

  const dotsWrap = document.getElementById('sliderDots');
  for(let i=0;i<total;i++){
    const d = document.createElement('span');
    if(i===0) d.classList.add('active');
    d.onclick = ()=>{ curSlide = i; renderSlide(); restartAuto(); };
    dotsWrap.appendChild(d);
  }

  function renderSlide(){
    sliderTrack.style.transform = `translateX(-${curSlide*100}%)`;
    [...dotsWrap.children].forEach((d,i)=>d.classList.toggle('active', i===curSlide));
  }
  window.changeSlide = function(dir){
    curSlide = (curSlide+dir+total)%total;
    renderSlide();
    restartAuto();
  };
  function restartAuto(){
    clearInterval(autoTimer);
    autoTimer = setInterval(()=>window.changeSlide(1), 4500);
  }

  // swipe support
  let startX = 0;
  sliderTrack.addEventListener('touchstart', e=>{ startX = e.touches[0].clientX; });
  sliderTrack.addEventListener('touchend', e=>{
    const diff = e.changedTouches[0].clientX - startX;
    if(diff > 50) window.changeSlide(-1);
    else if(diff < -50) window.changeSlide(1);
  });

  renderSlide();
  restartAuto();
}

// ===== Read more toggle =====
window.toggleMore = function(el){
  const p = document.querySelector('.more-text');
  if(!p) return;
  const open = p.style.display !== 'none';
  p.style.display = open ? 'none' : 'block';
  el.innerHTML = open ? 'আরও পড়ুন <i class="bi bi-chevron-down"></i>' : 'সংক্ষিপ্ত করুন <i class="bi bi-chevron-up"></i>';
};

// ===== Notice board tabs (home sidebar) =====
const noticeData = {
  dakhil:[['দাখিল রুটিন ২০২৬ প্রকাশিত','নতুন'],['দাখিল নির্বাচনী পরীক্ষার ফলাফল','১০ জুলাই'],['দাখিল ভর্তি নির্দেশিকা','০২ জুলাই']],
  alim:[['আলিম বৃত্তি পরীক্ষার সময়সূচি','নতুন'],['আলিম ১ম বর্ষ ভর্তি তালিকা','২৮ জুন']],
  fazil:[['ফাযিল (অনার্স) ক্লাস শুরুর তারিখ','৫ জুলাই'],['ফাযিল প্রবেশপত্র বিতরণ','২০ জুন']],
  kamil:[['কামিল মাস্টার্স ভর্তি বিজ্ঞপ্তি','নতুন'],['কামিল হাদিস বিভাগ সেমিনার','১৫ জুন']]
};
const noticeGrid = document.getElementById('noticeGrid');
if(noticeGrid){
  function renderNotice(tab){
    const list = document.getElementById('noticeList');
    list.innerHTML = '';
    noticeData[tab].forEach(([t,d])=>{
      list.innerHTML += `<a href="notice.html">${t} <small class="text-secondary float-end">${d}</small></a>`;
    });
  }
  noticeGrid.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      noticeGrid.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      renderNotice(btn.dataset.t);
    });
  });
  renderNotice('dakhil');
}

// ===== Calendar =====
const calBody = document.getElementById('calBody');
if(calBody){
  const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  const toBn = n => String(n).split('').map(d=>bnDigits[d]??d).join('');
  const bnMonths = ['জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
  let calDate = new Date(2026,6,1);
  const eventDays = [3,10,17,24,29];
  function renderCalendar(){
    const y=calDate.getFullYear(), m=calDate.getMonth();
    document.getElementById('calTitle').textContent = bnMonths[m]+' '+toBn(y);
    const first = new Date(y,m,1);
    let offset = (first.getDay()+1)%7;
    const days = new Date(y,m+1,0).getDate();
    const today = new Date();
    let html = '<tr>';
    for(let i=0;i<offset;i++) html += '<td></td>';
    let col = offset;
    for(let d=1; d<=days; d++){
      const isToday = today.getFullYear()===y && today.getMonth()===m && today.getDate()===d;
      const isEvent = eventDays.includes(d);
      html += `<td><div class="cal-day ${isToday?'today':''} ${isEvent?'event':''}">${toBn(d)}</div></td>`;
      col++;
      if(col%7===0) html += '</tr><tr>';
    }
    html += '</tr>';
    calBody.innerHTML = html;
  }
  document.getElementById('prevMonth').addEventListener('click',()=>{ calDate.setMonth(calDate.getMonth()-1); renderCalendar(); });
  document.getElementById('nextMonth').addEventListener('click',()=>{ calDate.setMonth(calDate.getMonth()+1); renderCalendar(); });
  renderCalendar();
}

// ===== Event countdown (home) =====
const countdownEl = document.getElementById('eventCountdown');
if(countdownEl){
  const target = new Date('2026-09-01T09:00:00');
  function updateCountdown(){
    const now = new Date();
    let diff = target - now;
    if(diff<0) diff = 0;
    const d = Math.floor(diff/(1000*60*60*24));
    const h = Math.floor((diff/(1000*60*60))%24);
    const m = Math.floor((diff/(1000*60))%60);
    const s = Math.floor((diff/1000)%60);
    countdownEl.querySelector('.cd-d').textContent = String(d).padStart(2,'0');
    countdownEl.querySelector('.cd-h').textContent = String(h).padStart(2,'0');
    countdownEl.querySelector('.cd-m').textContent = String(m).padStart(2,'0');
    countdownEl.querySelector('.cd-s').textContent = String(s).padStart(2,'0');
  }
  updateCountdown(); setInterval(updateCountdown,1000);
}

// ===== Student showcase filter + modal (home page) =====
const studentFilter = document.getElementById('studentFilter');
if(studentFilter){
  const cards = document.querySelectorAll('.student-card');
  studentFilter.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      studentFilter.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const dept = btn.dataset.dept;
      cards.forEach(c=>{
        c.closest('.student-col').style.display = (dept==='all' || c.dataset.dept===dept) ? '' : 'none';
      });
    });
  });
  cards.forEach(card=>{
    card.addEventListener('click',()=>{
      const info = JSON.parse(card.dataset.info);
      document.getElementById('stuImg').src = info.img;
      document.getElementById('stuName').textContent = info.name;
      document.getElementById('stuDept').textContent = info.dept;
      document.getElementById('stuRes').textContent = info.res;
      document.getElementById('stuRoll').textContent = info.roll;
    });
  });
}

// ===== Gallery filter + lightbox =====
const galleryFilter = document.getElementById('galleryFilter');
if(galleryFilter){
  const items = document.querySelectorAll('.gallery-item');
  galleryFilter.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      galleryFilter.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const cat = btn.dataset.cat;
      items.forEach(it=>{
        it.parentElement.style.display = (cat==='all' || it.dataset.cat===cat) ? '' : 'none';
      });
    });
  });
}
document.querySelectorAll('.gallery-item').forEach(item=>{
  item.addEventListener('click',()=>{
    const src = item.dataset.img || item.querySelector('img').src;
    const modal = document.createElement('div');
    modal.style.cssText = 'position:fixed;inset:0;background:rgba(8,20,20,.92);z-index:2000;display:flex;align-items:center;justify-content:center;padding:2rem;cursor:zoom-out;';
    modal.innerHTML = `<img src="${src}" style="max-width:100%;max-height:100%;border-radius:10px;box-shadow:0 20px 60px rgba(0,0,0,.5);">`;
    modal.addEventListener('click',()=>modal.remove());
    document.body.appendChild(modal);
  });
});

// ===== Teacher filter/search =====
const teacherSearch = document.getElementById('teacherSearch');
const teacherDept = document.getElementById('teacherDept');
if(teacherSearch || teacherDept){
  function filterTeachers(){
    const q = (teacherSearch?.value || '').trim();
    const dept = teacherDept?.value || 'all';
    document.querySelectorAll('.teacher-card').forEach(card=>{
      const name = card.dataset.name || '';
      const cardDept = card.dataset.dept || '';
      const matchQ = !q || name.includes(q);
      const matchD = dept==='all' || cardDept===dept;
      card.closest('.teacher-col').style.display = (matchQ && matchD) ? '' : 'none';
    });
  }
  teacherSearch?.addEventListener('input', filterTeachers);
  teacherDept?.addEventListener('change', filterTeachers);
}

// ===== Notice page filter/search =====
const noticeFilter = document.getElementById('noticeFilter');
const noticeSearch = document.getElementById('noticeSearch');
if(noticeFilter || noticeSearch){
  function filterNotices(){
    const activeBtn = noticeFilter?.querySelector('button.active');
    const cat = activeBtn?.dataset.cat || 'all';
    const q = (noticeSearch?.value || '').trim();
    document.querySelectorAll('.notice-row').forEach(row=>{
      const rowCat = row.dataset.cat || '';
      const title = row.dataset.title || '';
      const matchC = cat==='all' || rowCat===cat;
      const matchQ = !q || title.includes(q);
      row.style.display = (matchC && matchQ) ? '' : 'none';
    });
  }
  noticeFilter?.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      noticeFilter.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      filterNotices();
    });
  });
  noticeSearch?.addEventListener('input', filterNotices);
}

// ===== Video gallery filter + modal player =====
const videoFilter = document.getElementById('videoFilter');
if(videoFilter){
  const vcards = document.querySelectorAll('.video-card');
  videoFilter.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      videoFilter.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const cat = btn.dataset.cat;
      vcards.forEach(c=>{
        c.closest('.video-col').style.display = (cat==='all' || c.dataset.cat===cat) ? '' : 'none';
      });
    });
  });
  const videoModalEl = document.getElementById('videoModal');
  const videoFrame = document.getElementById('videoFrame');
  vcards.forEach(card=>{
    card.addEventListener('click',()=>{
      const id = card.dataset.yt;
      videoFrame.src = `https://www.youtube.com/embed/${id}?autoplay=1`;
      const modal = new bootstrap.Modal(videoModalEl);
      modal.show();
    });
  });
  videoModalEl?.addEventListener('hidden.bs.modal', ()=>{ videoFrame.src=''; });
}
const contactForm = document.getElementById('contactForm');
if(contactForm){
  contactForm.addEventListener('submit', function(e){
    e.preventDefault();
    if(!contactForm.checkValidity()){
      e.stopPropagation();
      contactForm.classList.add('was-validated');
      return;
    }
    document.getElementById('contactSuccess').classList.remove('d-none');
    contactForm.reset();
    contactForm.classList.remove('was-validated');
    setTimeout(()=>document.getElementById('contactSuccess').classList.add('d-none'), 4000);
  });
}
