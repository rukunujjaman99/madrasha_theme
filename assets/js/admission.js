(function(){
  const filter = document.getElementById('admFilter');
  filter.querySelectorAll('button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      filter.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const cat = btn.dataset.cat;
      document.querySelectorAll('#admList .notice-row').forEach(row=>{
        row.style.display = (cat==='all' || row.dataset.cat===cat) ? '' : 'none';
      });
    });
  });
})();