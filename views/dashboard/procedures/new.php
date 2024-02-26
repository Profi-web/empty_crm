<?php
/*Page Info*/
$page = 'Nieuwe procedure';
$type = 'procedures';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
$usertheme = new User();

/*Variables*/
//if(isset($_GET['id']) && ctype_digit($_GET['id'])){
//    $id = $_GET['id'];
//} else {
//    header('Location: /404');
//}
/**/


/*Classes*/
$user = new User();
$procedure = new Procedure();
//

/*CSS*/
?>

<?php

/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/header.php';
/**/
?>
<!--    HEADER-->

<div class="container-fluid justify-content-center" style="margin-top:-40px;">
    <div class="row px-3 px-md-5 justify-content-between">
        <div class="p-0 col-12 col-xl-9 pr-xl-4 mb-4">
            <div class="card shadow" id="procedures_info">
                <div class="card-header border-0 bg-white rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <ol class="breadcrumb bg-white m-0 p-0">
                            <li class="breadcrumb-item active">Nieuwe procedure</li>
                        </ol>
                    </div>
                </div>
                <div class="container-fluid  bg-light-second py-3 rounded-bottom">
                    <div class="row p-3">
                        <div class="col-12">
                            <div class="text-info pb-3">Tekst</div>
                            <textarea rows="35" id="input_data"></textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <form class="row" novalidate>
                <div class="col-12 p-0">
                    <div class="card shadow " id="procedures_contact">
                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div>Gegevens</div>
                            </div>
                        </div>
                        <div class="container-fluid p-4 rounded-bottom rounded-top">
                            <div class="alert_field">
                            </div>
                            <div class="row">
                                <div class="col-12 ">

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-sign"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Titel"
                                                       aria-label="Titel" id="title" required>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-0 mt-4">
                    <button class="w-100 btn btn-success text-white rounded shadow" id="save_data" type="submit">
                        Opslaan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="bottom_notes">BasicCRM versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script>
    // if ctrl + s is pressed
    $(document).keydown(function (e) {
       if ((e.ctrlKey && e.key === 's')) {
            e.preventDefault();
            $("#save_data").click();
            return false;
        }

        return true;
    });
    tinymce.init({
        plugins: "autolink link",
        selector: '#input_data',
        branding: false,
        body_class: "rounded",
        mobile: {
            theme: 'silver'
        },
        menubar: false,
        relative_urls : true,
        forced_root_block: "",
        paste_data_images: true,
        invalid_elements : "script,img,iframe",
        toolbar: " redo | undo | bold | italic | link | unlink",
        default_link_target: "_blank"
    });
    tinymce.triggerSave();
        $('form').submit(function (event) {
        event.preventDefault();

        if ($('#title').val() === '') {
            $('#title').addClass('is-invalid');
        } else {
            $('#title').removeClass('is-invalid');
        }

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/procedure/procedures_save.php', //Your form processing file URL
            data: {
                text: tinymce.get('input_data').getContent(),
                title: $('#title').val(),
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    window.location.href = '/procedures';
                } else {
                    $(".alert_field").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });
</script>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/procedures.js"></script>
<script src="/assets/js/dashboard/tables/procedure.js"></script>
