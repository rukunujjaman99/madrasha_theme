document.addEventListener('DOMContentLoaded', function () {
    var tabWrap = document.getElementById('noticeGrid');
    var items   = document.querySelectorAll('#noticeList .notice-item');

    if (!tabWrap || !items.length) {
        return;
    }

    function applyFilter(dept) {
        items.forEach(function (item) {
            item.style.display = (item.getAttribute('data-t') === dept) ? '' : 'none';
        });
    }

    tabWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;

        tabWrap.querySelectorAll('button').forEach(function (b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        applyFilter(btn.getAttribute('data-t'));
    });

    // Show the first tab's notices by default
    var activeBtn = tabWrap.querySelector('button.active');
    if (activeBtn) {
        applyFilter(activeBtn.getAttribute('data-t'));
    }
});