$(document).ready(function () {
    var $loading = $('.spinner').hide();
    $('form').submit(function (event) {
        $loading.show();
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/login/forgot.php', //Your form processing file URL
            data: $(this).serialize(), //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {

                        window.location.href = '/?reset=true';
                } else {
                    $(".alert_field").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
                $loading.hide();
            }
        });
        event.preventDefault();
    });
});

(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();