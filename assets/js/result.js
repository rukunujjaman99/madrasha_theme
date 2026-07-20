// reuse notice filter logic scoped to resultFilter/resultSearch
(function(){
  const filter = document.getElementById('resultFilter');
  const search = document.getElementById('resultSearch');
  function apply(){
    const activeBtn = filter.querySelector('button.active');
    const cat = activeBtn?.dataset.cat || 'all';
    const q = (search.value || '').trim();
    document.querySelectorAll('#res-pdf .notice-row').forEach(row=>{
      const rowCat = row.dataset.cat || '';
      const title = row.dataset.title || '';
      const matchC = cat==='all' || rowCat===cat;
      const matchQ = !q || title.includes(q);
      row.style.display = (matchC && matchQ) ? '' : 'none';
    });
  }
  filter.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      filter.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      apply();
    });
  });
  search.addEventListener('input', apply);
})();