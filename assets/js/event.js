(function () {
        var wrap = document.getElementById('eventCountdown');
        if (!wrap) return;

        var targetTime = new Date(wrap.getAttribute('data-target')).getTime();
        var dEl = wrap.querySelector('.cd-d');
        var hEl = wrap.querySelector('.cd-h');
        var mEl = wrap.querySelector('.cd-m');
        var sEl = wrap.querySelector('.cd-s');

        function pad(n) { return String(n).padStart(2, '0'); }

        function tick() {
            var diff = targetTime - Date.now();

            if (diff <= 0) {
                dEl.textContent = hEl.textContent = mEl.textContent = sEl.textContent = '00';
                clearInterval(timer);
                return;
            }

            var days    = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours   = Math.floor((diff / (1000 * 60 * 60)) % 24);
            var minutes = Math.floor((diff / (1000 * 60)) % 60);
            var seconds = Math.floor((diff / 1000) % 60);

            dEl.textContent = pad(days);
            hEl.textContent = pad(hours);
            mEl.textContent = pad(minutes);
            sEl.textContent = pad(seconds);
        }

        tick();
        var timer = setInterval(tick, 1000);
    })();