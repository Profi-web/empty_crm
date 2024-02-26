<?php
/*Page Info*/
$page = 'KennisPlein Artikel';
$type = 'article';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
//if(isset($_GET['id']) && ctype_digit($_GET['id'])){
//    $id = $_GET['id'];
//} else {
//    header('Location: /404');
//}
/**/


/*Classes*/
$user = new User();
$article = new Article();
//

/*CSS*/


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
            <div class="card shadow" id="article_info">
                <div class="card-header border-0 bg-white rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <ol class="breadcrumb bg-white m-0 p-0">
                            <li class="breadcrumb-item active">Nieuw artikel</li>
                        </ol>
                    </div>
                </div>
                <div class="container-fluid  bg-light-second py-3 rounded-bottom">
                    <div class="row p-3">
                        <div class="col-12">
                            <div class="text-info pb-3">Informatie</div>
                            <textarea rows="35" id="input_data"></textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <form class="row" novalidate>
                <div class="col-12 p-0">
                    <div class="card shadow " id="article_contact">
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
                                                    <span class="input-group-text"><i
                                                            class="fad fa-info-circle"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Onderwerp"
                                                       aria-label="Onderwerp" id="name" required>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group date" id="date" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#date"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i
                                                            class="fad fa-calendar-alt pl-1"></i></div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input"
                                                       data-target="#date"
                                                       placeholder="Kies een datum en tijd"/>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-0">
                    <div class="card shadow mt-4" id="article_tags" style="min-height: 100px;">
                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div>Tags</div>
                            </div>
                        </div>
                        <div class="container-fluid px-4 py-2 rounded-bottom rounded-top">
                            <div class="alert_field_relations pt-2">
                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="container-fluid">
                                        <div class="row relations_edit mb-2">

                                            <label for="selectedChoice" class="pt-2">
                                                Kies een bestaande tag
                                            </label>
                                            <div class="input-group mb-3">
                                                <select class="rounded selectpicker" id="selectedChoice"
                                                        multiple>
                                                    <?php
                                                    $article->showOptionsNoId();
                                                    ?>
                                                </select>
                                                <div id="selectedRemove">
                                                    <div class="h-100 d-flex align-items-center px-2"><i
                                                            class="fad fa-times"></i></div>
                                                </div>
                                            </div>

                                            <label for="selectedChoice" class="pt-2">
                                                Maak een nieuwe tag
                                            </label>
                                            <div class="input-group mb-3">
                                                <input class="form-control rounded" type="text" name="newTag"
                                                       placeholder="Tag naam" id="newTag"/>
                                            </div>
                                        </div>
                                    </div>

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
<div class="bottom_notes">BasicCRM versie <?php $versions = new Versions();
    echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script>
    $(function () {
        $('#date').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'L'
        });
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
        var error = '';
        event.preventDefault();
        if ($('#name').val() === '') {
            $('#name').addClass('is-invalid');
        } else {
            $('#name').removeClass('is-invalid');
        }


        if ($('#date input').val() == '') {
            $('#date input').addClass('is-invalid');
        } else {
            $('#date input').removeClass('is-invalid');
        }
        var alreadyTag = '';
        var newTag = '';

        if ($("#newTag").val()) {
            newTag = $("#newTag").val();
            $(".alert_field_relations").html('');
        } else {
            if (!$("#selectedChoice").val()) {
                error = error + 'Error 404';
                $(".alert_field_relations").load("/controllers/error.php", {
                    message: 'Je hebt geen bestaande of nieuwe toegevoegd.',
                    class: 'alert-danger'
                }, function () {

                    $('.alert').fadeIn(1000);
                });
            }
        }

        if ($("#selectedChoice").val()) {
            alreadyTag = $('#selectedChoice').val();
            $(".alert_field_relations").html('');
        } else {
            if (!$("#newTag").val()) {
                error = error + 'Error 404';
                $(".alert_field_relations").load("/controllers/error.php", {
                    message: 'Je hebt geen bestaande of nieuwe toegevoegd',
                    class: 'alert-danger'
                }, function () {

                    $('.alert').fadeIn(1000);
                });
            }
        }
        console.log('newtag' + newTag);
        console.log('alreadyTag' + alreadyTag);
        if (error === '') {
            // if (newTag || alreadyTag) {
            if ($('#name').val() && $('#date input').val()) {
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method type
                    url: '/controllers/tables/articles/articles_save.php', //Your form processing file URL
                    data: {
                        text: tinymce.get('input_data').getContent(),
                        name: $('#name').val(),
                        date: $('#date input').val(),
                        newTag: newTag,
                        alreadyTag: alreadyTag
                    }, //Forms name
                    success: function (data) {
                        data = JSON.parse(data);
                        console.log(data);
                        if (data.status === 'success') {
                            window.location.href = '/kennisplein';
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
            }
            // } else {
            //     $(".alert_field_relations").load("/controllers/error.php", {
            //         message: 'Je hebt geen bestaande of nieuwe toegevoegd.',
            //         class: 'alert-danger'
            //     }, function () {
            //
            //         $('.alert').fadeIn(1000);
            //     });
            // }
        }
    });
    $('#selectedChoice ').on('change', function () {
        if ($('#selectedChoice').val()) {
            $('#selectedRemove').show();
        }
    });
    $("#selectedRemove").on('click', function () {
        $('#selectedChoice').selectpicker('deselectAll');
        $('#selectedRemove').hide();
    });
    // if ctrl + s is pressed
    $(document).keydown(function (e) {
       if ((e.ctrlKey && e.key === 's')) {
            e.preventDefault();
            $("#save_data").click();
            return false;
        }

        return true;
    });

</script>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/article.js"></script>
<script src="/assets/js/dashboard/tables/article/companies.js"></script>
