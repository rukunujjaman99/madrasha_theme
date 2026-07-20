document.addEventListener('DOMContentLoaded', function () {
    var form       = document.getElementById('contactForm');
    var successBox = document.getElementById('contactSuccess');
    var successText = document.getElementById('contactSuccessText');
    var errorBox   = document.getElementById('contactError');
    var errorText  = document.getElementById('contactErrorText');
    var submitBtn  = document.getElementById('contactSubmitBtn');
    var btnText    = document.getElementById('contactBtnText');

    if (!form || typeof rsContactForm === 'undefined') {
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        // Bootstrap-style client-side validation
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        form.classList.add('was-validated');

        // Hide any previous alerts
        successBox.classList.add('d-none');
        errorBox.classList.add('d-none');

        // Lock the button while submitting
        submitBtn.disabled = true;
        var originalBtnText = btnText.textContent;
        btnText.textContent = 'পাঠানো হচ্ছে...';

        var formData = new FormData(form);
        formData.append('action', 'rs_contact_form_submit');
        formData.append('nonce', rsContactForm.nonce);

        fetch(rsContactForm.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            submitBtn.disabled = false;
            btnText.textContent = originalBtnText;

            if (data.success) {
                successText.textContent = data.data.message;
                successBox.classList.remove('d-none');

                form.reset();
                form.classList.remove('was-validated');
            } else {
                errorText.textContent = data.data.message || 'দুঃখিত, একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।';
                errorBox.classList.remove('d-none');
            }
        })
        .catch(function () {
            submitBtn.disabled = false;
            btnText.textContent = originalBtnText;
            errorText.textContent = 'নেটওয়ার্ক সমস্যা হয়েছে। আবার চেষ্টা করুন।';
            errorBox.classList.remove('d-none');
        });
    });
});