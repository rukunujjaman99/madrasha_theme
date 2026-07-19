document.addEventListener('DOMContentLoaded', function () {
    var filterWrap = document.getElementById('studentFilter');
    var cols       = document.querySelectorAll('#studentGrid .student-col');

    if (!filterWrap || !cols.length) {
        return;
    }

    filterWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;

        filterWrap.querySelectorAll('button').forEach(function (b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        var dept = btn.getAttribute('data-dept');

        cols.forEach(function (col) {
            var card = col.querySelector('.student-card');
            var show = (dept === 'all') || (card.getAttribute('data-dept') === dept);
            col.style.display = show ? '' : 'none';
        });
    });
});